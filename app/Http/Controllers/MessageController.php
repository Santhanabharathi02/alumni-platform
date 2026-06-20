<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Notifications\AdminRepliedToMessage;
use App\Notifications\AdminSeenMessage;
use App\Notifications\NewMessageFromAdmin;
use App\Notifications\NewMessageFromAlumni;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /** Inbox – admin sees all messages; alumni see their own */
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $messages = Message::with(['sender', 'recipient'])->latest()->paginate(20);
        } else {
            // Alumni see messages they sent OR messages sent to them by admin
            $messages = Message::where('from_user_id', auth()->id())
                ->orWhere('to_user_id', auth()->id())
                ->latest()->paginate(20);
        }

        return view('messages.index', compact('messages'));
    }

    /** Compose form */
    public function create()
    {
        $alumni = auth()->user()->isAdmin()
            ? User::where('role', 'alumni')->orderBy('name')->get()
            : collect();

        return view('messages.create', compact('alumni'));
    }

    /** Store new message */
    public function store(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            $data = $request->validate([
                'to_user_id' => ['required', 'exists:users,id'],
                'subject'    => ['required', 'string', 'max:255'],
                'body'       => ['required', 'string', 'max:5000'],
            ]);

            $msg = Message::create([
                'from_user_id' => auth()->id(),
                'to_user_id'   => $data['to_user_id'],
                'subject'      => $data['subject'],
                'body'         => $data['body'],
            ]);

            // Notify the recipient alumni
            User::find($data['to_user_id'])->notify(new NewMessageFromAdmin($msg));

            return redirect()->route('messages.index')
                ->with('status', 'Message sent to alumni successfully.');
        }

        // Alumni sending to admin
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'body'    => ['required', 'string', 'max:5000'],
        ]);

        $msg = Message::create([
            'from_user_id' => auth()->id(),
            'subject'      => $data['subject'],
            'body'         => $data['body'],
        ]);

        // Notify all admin users
        User::where('role', 'admin')->each(function ($admin) use ($msg) {
            $admin->notify(new NewMessageFromAlumni($msg));
        });

        return redirect()->route('messages.index')
            ->with('status', 'Your message has been sent to the admin.');
    }

    /** View single message */
    public function show(Message $message)
    {
        $user = auth()->user();

        // Alumni can only view their own messages (sent or received)
        if (!$user->isAdmin()) {
            $owns = $message->from_user_id === $user->id || $message->to_user_id === $user->id;
            if (!$owns) abort(403);
        }

        // Mark as read when admin views an alumni-sent (non-initiated) message
        if ($user->isAdmin() && !$message->isAdminInitiated() && !$message->is_read) {
            $message->update(['is_read' => true]);
            $message->sender->notify(new AdminSeenMessage($message));
        }

        // Mark admin-initiated message as read when alumni views it
        if (!$user->isAdmin() && $message->isAdminInitiated() && !$message->is_read) {
            $message->update(['is_read' => true]);
        }

        // Mark reply as read when alumni views it (alumni-received reply on their own thread)
        if ($user->isAlumni() && !$message->isAdminInitiated() && $message->admin_reply && !$message->reply_read) {
            $message->update(['reply_read' => true]);
        }

        // Mark alumni reply as read when admin views it
        if ($user->isAdmin() && $message->isAdminInitiated() && $message->alumni_reply && !$message->admin_read_reply) {
            $message->update(['admin_read_reply' => true]);
        }

        return view('messages.show', compact('message'));
    }

    /** Admin reply to alumni-sent message */
    public function reply(Request $request, Message $message)
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        $request->validate([
            'admin_reply' => ['required', 'string', 'max:5000'],
        ]);

        $message->update([
            'admin_reply' => $request->admin_reply,
            'replied_at'  => now(),
            'reply_read'  => false,
        ]);

        // Notify the alumni who sent the message
        $message->sender->notify(new AdminRepliedToMessage($message));

        return back()->with('status', 'Reply sent successfully.');
    }

    /** Alumni reply to admin-initiated message */
    public function alumniReply(Request $request, Message $message)
    {
        $user = auth()->user();
        abort_unless(!$user->isAdmin() && $message->to_user_id === $user->id, 403);

        $request->validate([
            'alumni_reply' => ['required', 'string', 'max:5000'],
        ]);

        $message->update([
            'alumni_reply'       => $request->alumni_reply,
            'alumni_replied_at'  => now(),
            'admin_read_reply'   => false,
        ]);

        // Notify all admins
        User::where('role', 'admin')->each(function ($admin) use ($message) {
            $admin->notify(new NewMessageFromAlumni($message));
        });

        return back()->with('status', 'Reply sent successfully.');
    }

    /** Delete message */
    public function destroy(Message $message)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && $message->from_user_id !== $user->id && $message->to_user_id !== $user->id) {
            abort(403);
        }

        $message->delete();

        return redirect()->route('messages.index')
            ->with('status', 'Message deleted.');
    }
}
