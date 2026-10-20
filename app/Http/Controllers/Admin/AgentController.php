<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Agent;
use App\Models\Property;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AgentController extends Controller
{
    public function index(): View
    {
        $agents = Agent::latest()->get();
        return view('admin.agent.index', compact('agents'));
    }

    public function create(): View
    {
        return view('admin.agent.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:agents,email',
            'phone' => ['required', 'digits:10', 'regex:/^09[0-9]{8}$/', 'unique:agents,phone'],
            'password' => 'required|min:6|confirmed',
            'company' => 'required|min:2|string',
            'designation' => 'required|min:4|string',
            'address' => 'nullable|string',
            'country' => 'nullable|min:3|string',
            'state' => 'nullable|min:2|string',
            'city' => 'nullable|string',
            'website' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
            'biography' => 'nullable|string|min:10',
        ], [
            'phone.digits' => 'رقم الهاتف يجب أن يكون 10 أرقام، مثال: 0930000000',
            'phone.regex' => 'رقم الهاتف يجب أن يبدأ بـ 09، مثال: 0930000000',
            'phone.unique' => 'رقم الهاتف مستخدم مسبقاً.',
        ]);

        $fileName = null;
        if ($request->file('photo')) {
            $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
            // تم تصحيح المسار: المجلد أولاً ثم اسم الملف
            $request->photo->storeAs('user-images', $fileName);
        }

        $token = Str::random(64);
        $agent = Agent::create([
            'photo' => $fileName,
            'name' => ucwords($request->name),
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'company' => ucwords($request->company),
            'designation' => ucwords($request->designation),
            'address' => $request->address,
            'country' => ucwords($request->country),
            'state' => ucwords($request->state),
            'city' => ucwords($request->city),
            'website' => $request->website,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'instagram' => $request->instagram,
            'biography' => $request->biography,
            'token' => $token,
        ]);

        try {
            Mail::send(
                'email.register_email',
                [
                    'token' => $token,
                    'adminAgent' => $agent,
                    'request' => $request,
                ],
                function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Email Verification');
                }
            );

            return redirect()
                ->route('admin.agents.index')
                ->with('success', 'Verification email has been sent to agent\'s email.');
        } catch (\Exception $e) {
            // تجربة محلية: نعتبر الوكيل مفعّلاً بدون إيميل
            $agent->update(['token' => null]);

            return redirect()
                ->route('admin.agents.index')
                ->with('success', 'Agent created successfully for local testing.');
        }
    }

    public function show(Agent $agent): View
    {
        return view('admin.agent.show', compact('agent'));
    }

    public function edit(Agent $agent): View
    {
        return view('admin.agent.edit', compact('agent'));
    }

    public function update(Request $request, Agent $agent): RedirectResponse
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:agents,email,' . $agent->id,
            'phone' => ['required', 'digits:10', 'regex:/^09[0-9]{8}$/', 'unique:agents,phone,' . $agent->id],
            'password' => 'nullable|min:6|confirmed',
            'company' => 'required|min:2|string',
            'designation' => 'required|min:4|string',
            'address' => 'nullable|string',
            'country' => 'nullable|min:3|string',
            'state' => 'nullable|min:2|string',
            'city' => 'nullable|string',
            'website' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
            'biography' => 'nullable|string|min:10',
            'status' => 'required|in:0,1,2',
        ], [
            'phone.digits' => 'رقم الهاتف يجب أن يكون 10 أرقام، مثال: 0930000000',
            'phone.regex' => 'رقم الهاتف يجب أن يبدأ بـ 09، مثال: 0930000000',
            'phone.unique' => 'رقم الهاتف مستخدم مسبقاً.',
        ]);

        $updates = [
            'name' => ucwords($request->name),
            'email' => $request->email,
            'phone' => $request->phone,
            'company' => ucwords($request->company),
            'designation' => ucwords($request->designation),
            'address' => $request->address,
            'country' => ucwords($request->country),
            'state' => ucwords($request->state),
            'city' => ucwords($request->city),
            'website' => $request->website,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'instagram' => $request->instagram,
            'biography' => $request->biography,
            'status' => $request->status,
        ];

        // هل تغيّرت بيانات الدخول/الحساب؟
        $accountChanged = $request->filled('password')
            || ucwords($request->name) !== $agent->name
            || $request->email !== $agent->email
            || $request->phone !== $agent->phone;

        if ($request->filled('password')) {
            $updates['password'] = Hash::make($request->password);
        }

        if ($request->file('photo')) {
            if ($agent->photo) {
                Storage::delete('user-images/' . $agent->photo);
            }
            $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
            $request->photo->storeAs('user-images', $fileName);
            $updates['photo'] = $fileName;
        }

        $agent->update($updates);

        if ($accountChanged) {
            // فشل الإيميل لا يمنع الحفظ (مهم للتجربة المحلية)
            try {
                Mail::send(
                    'email.admin_user_edit',
                    [
                        'agent' => 'agent',
                        'request' => $request,
                    ],
                    function ($message) use ($request) {
                        $message->to($request->email);
                        $message->subject('Account Information Updated');
                    }
                );
            } catch (\Exception $e) {
                Log::warning('Agent update email failed: ' . $e->getMessage());
            }

            if (Auth::guard('agent')->id() == $agent->id) {
                Auth::guard('agent')->logout();
            }
        }

        return redirect()->route('admin.agents.index')->with('success', 'Agent updated successfully.');
    }

    public function destroy(Agent $agent): RedirectResponse
    {
        try {
            DB::transaction(function () use ($agent) {
                $properties = Property::where('agent_id', $agent->id)->get();
                foreach ($properties as $property) {
                    foreach ($property->photos as $photo) {
                        Storage::delete('property-images/' . $photo->photo);
                        $photo->delete();
                    }
                    $property->videos()->delete();
                    $property->amenities()->detach();
                    Storage::delete('property-images/' . $property->featured_photo);
                    $property->delete();
                }
                if ($agent->photo) {
                    Storage::delete('user-images/' . $agent->photo);
                }
                $agent->delete();
            });

            if (Auth::guard('agent')->id() == $agent->id) {
                Auth::guard('agent')->logout();
            }

            return redirect()->route('admin.agents.index')->with(
                'success',
                'Agent and all associated data deleted successfully.',
            );
        } catch (\Exception $e) {
            return redirect()->route('admin.agents.index')->with(
                'error',
                'An error occurred while deleting the agent. Please try again.',
            );
        }
    }
}