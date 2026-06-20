<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Mentorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MentorshipController extends Controller
{
    public function index(Request $request)
    {
        $query = Mentorship::query()->with('alumni');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $mentorships = $query->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('mentorships.index', compact('mentorships'));
    }

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $alumni = $user->isAdmin()
            ? Alumni::orderBy('last_name')->get()
            : collect([$user->alumni])->filter();

        return view('mentorships.create', [
            'alumni' => $alumni,
            'mentorship' => new Mentorship(),
        ]);
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $data = $this->validateMentorship($request);

        if ($user->isAlumni() && $user->alumni) {
            $data['alumni_id'] = $user->alumni->id;
        }

        Mentorship::create($data);

        return redirect()->route('mentorships.index')
            ->with('status', 'Mentorship request created successfully.');
    }

    public function show(Mentorship $mentorship)
    {
        $mentorship->load('alumni');

        return view('mentorships.show', compact('mentorship'));
    }

    public function edit(Mentorship $mentorship)
    {
        $this->authorizeMentorshipAccess($mentorship);
        $alumni = Alumni::orderBy('last_name')->get();

        return view('mentorships.edit', compact('mentorship', 'alumni'));
    }

    public function update(Request $request, Mentorship $mentorship)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->authorizeMentorshipAccess($mentorship);
        $data = $this->validateMentorship($request);

        if ($user->isAlumni() && $user->alumni) {
            $data['alumni_id'] = $user->alumni->id;
        }

        $mentorship->update($data);

        return redirect()->route('mentorships.show', $mentorship)
            ->with('status', 'Mentorship updated successfully.');
    }

    public function destroy(Mentorship $mentorship)
    {
        $this->authorizeMentorshipAccess($mentorship);
        $mentorship->delete();

        return redirect()->route('mentorships.index')
            ->with('status', 'Mentorship deleted.');
    }

    private function validateMentorship(Request $request): array
    {
        return $request->validate([
            'alumni_id' => ['required', 'exists:alumnis,id'],
            'area_of_interest' => ['required', 'string', 'max:255'],
            'availability' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:open,active,closed'],
            'started_at' => ['nullable', 'date'],
            'ended_at' => ['nullable', 'date', 'after_or_equal:started_at'],
        ]);
    }

    private function authorizeMentorshipAccess(Mentorship $mentorship): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return;
        }

        if (!$user->alumni || $mentorship->alumni_id !== $user->alumni->id) {
            abort(403);
        }
    }
}
