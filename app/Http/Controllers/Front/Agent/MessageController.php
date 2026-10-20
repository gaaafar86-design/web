<?php

namespace App\Http\Controllers\Front\Agent;

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
     * Display a paginated list of messages received by the authenticated agent.
     *
     * Retrieves all messages where the current agent is the recipient,
     *
     * @return View
     */
    public function index(): View
    {
        $agent = Auth::guard('agent')->user();
        $messages = $agent->messages()->with('user')->paginate(12);
        return view('front.agent.dashboard.message.index', compact('messages'));
    }

    /**
     * Display the full reply thread for a specific message.
     *
     * Loads all replies associated with the given message, along with user and agent details.
     *
     * @param Message $message
     * @return View
     */
    public function reply(Message $message): View
    {
        $replies = MessageReply::where('message_id', $message->id)->get();
        $message->load('user', 'agent');
        return view('front.agent.dashboard.message.reply', compact('replies', 'message'));
    }

    /**
     * Submit a reply to a message and notify the user via email.
     *
     * Validates the reply content, creates a new MessageReply record with sender marked as "Agent",
     * and sends an email notification to the user. If email fails, the reply is deleted to maintain integrity.
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
            'sender' => 'Agent',
            'message' => $request->reply,
        ]);

        try {
            Mail::send(
                'email.user_message',
                ['message' => $message, 'agent' => $message->agent],
                function ($mail) use ($message) {
                    $mail->to($message->user->email);
                    $mail->subject('You Have a New Message');
            });
            return back()->with('success', 'Reply successfully sent.');
        } catch (\Exception) {
            $reply->delete();
            return back()->with('error', 'Failed to send the Message. Please try again.');
        };
    }
}
