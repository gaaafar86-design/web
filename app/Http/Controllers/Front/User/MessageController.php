<?php

namespace App\Http\Controllers\Front\User;

use App\Models\Agent;
use App\Models\Message;
use Illuminate\View\View;
use App\Models\MessageReply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    /**
     * Display a paginated list of messages for the authenticated user.
     *
     * Retrieves all messages sent by the current user, eager-loading the associated agent.
     *
     * @return View
     */
    public function index(): View
    {
        $user = Auth::guard('web')->user();
        $messages = $user->messages()->with('agent')->paginate(12);
        return view('front.user.dashboard.message.index', compact('messages'));
    }

    /**
     * Show the message creation form.
     *
     * Retrieves all active agents to populate the agent selection dropdown.
     * Used when a user wants to initiate a new message to an agent.
     *
     * @return View
     */
    public function create(): View
    {
        $agents = Agent::where('status', 1)->get();
        return view('front.user.dashboard.message.create', compact('agents'));
    }

    /**
     * Store a newly created message and notify the agent via email.
     *
     * Validates the request input, creates a new message record linking the user and agent,
     * and attempts to send an email notification to the agent. If email fails, the message is rolled back.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'subject' => 'required|string|min:3',
            'message' => 'required|string|min:10',
            'agent_id' => 'required|exists:agents,id',
        ]);

        $userId = Auth::guard('web')->id();
        $openConversation = Message::where('user_id', $userId)
            ->where('agent_id', $request->agent_id)
            ->exists();
        if ($openConversation) {
            return back()->with('error', 'You have already an open conversation with this agent.');
        };

        $agent = Agent::find($request->agent_id);
        $message = Message::create([
            'user_id' => $userId,
            'agent_id' => $agent->id,
            'subject' => ucwords($request->subject),
            'message' => $request->message,
        ]);

        try {
            Mail::send('email.agent_message', ['message' => $message], function ($message) use ($agent) {
                $message->to($agent->email);
                $message->subject('You Have a New Message');
            });
            return redirect()->route('user.messages.index')->with('success', 'Message successfully sent.');
        } catch (\Exception) {
            $message->delete();
            return back()->with('error', 'Failed to send the Message. Please try again.');
        };
    }

    /**
     * Display the reply thread for a specific message.
     *
     * Loads all replies associated with the message, along with the user and agent details.
     * Used to show the full conversation history between the user and agent.
     *
     * @param Message $message
     * @return View
     */
    public function reply(Message $message): View
    {
        $replies = MessageReply::where('message_id', $message->id)->get();
        $message->load('user', 'agent');
        return view('front.user.dashboard.message.reply', compact('replies', 'message'));
    }

    /**
     * Submit a reply to an existing message and notify the agent via email.
     *
     * Validates the reply content, creates a new MessageReply record, and sends an email
     * notification to the agent. If email fails, the reply is deleted to maintain integrity.
     *
     * @param Request $request
     * @param Message $message
     * @return RedirectResponse
     */
    public function submitReply(Request $request, Message $message): RedirectResponse
    {
        $request->validate([
            'reply' => 'required|string|min:10',
        ]);

        $reply = MessageReply::create([
            'message_id' => $message->id,
            'sender' => 'Customer',
            'message' => $request->reply,
        ]);

        try {
            Mail::send('email.agent_message', ['message' => $message], function ($mail) use ($message) {
                $mail->to($message->agent->email);
                $mail->subject('You Have a New Message');
            });
            return back()->with('success', 'Reply successfully sent.');
        } catch (\Exception) {
            $reply->delete();
            return back()->with('error', 'Failed to send the Message. Please try again.');
        };
    }

    /**
     * Delete a message and all its associated replies.
     *
     * Removes the message and its replies from the database. Used when a user
     * wants to permanently delete a conversation thread.
     *
     * @param Message $message
     * @return RedirectResponse
     */
    public function destroy(Message $message): RedirectResponse
    {
        $message->replies()->delete();
        $message->delete();
        return back()->with('success', 'Message deleted successfully');
    }
}
