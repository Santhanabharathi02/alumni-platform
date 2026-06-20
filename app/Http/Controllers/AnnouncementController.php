<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $query = Announcement::query();

        if ($request->filled('category')) {
            $query->where('category', $request->string('category'));
        }

        // Non-admins only see published announcements
        if (!$user->isAdmin()) {
            $query->where('is_published', true);
        }

        $announcements = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('announcements.create', ['announcement' => new Announcement()]);
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $data = $this->validateAnnouncement($request);
        $data['created_by'] = Auth::id();
        $data['is_published'] = $request->boolean('is_published');
        Announcement::create($data);

        return redirect()->route('announcements.index')->with('status', 'Announcement published successfully.');
    }

    public function show(Announcement $announcement)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isAdmin() && !$announcement->is_published) {
            abort(403);
        }
        return view('announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        $this->authorizeAdmin();
        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $this->authorizeAdmin();
        $data = $this->validateAnnouncement($request);
        $data['is_published'] = $request->boolean('is_published');
        $announcement->update($data);

        return redirect()->route('announcements.show', $announcement)->with('status', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorizeAdmin();
        $announcement->delete();
        return redirect()->route('announcements.index')->with('status', 'Announcement deleted.');
    }

    private function validateAnnouncement(Request $request): array
    {
        return $request->validate([
            'title'      => ['required', 'string', 'max:255'],
            'body'       => ['required', 'string'],
            'category'   => ['required', 'in:general,event,career,urgent'],
            'publish_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date'],
        ]);
    }

    private function authorizeAdmin(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (Auth::check() && !$user->isAdmin()) {
            abort(403);
        }
    }
}
