<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        $query = Donation::query()->with('alumni');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $donations = $query->orderByDesc('donated_at')
            ->paginate(10)
            ->withQueryString();

        return view('donations.index', compact('donations'));
    }

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $alumni = $user->isAdmin()
            ? Alumni::orderBy('last_name')->get()
            : collect([$user->alumni])->filter();

        return view('donations.create', [
            'alumni' => $alumni,
            'donation' => new Donation(),
        ]);
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $data = $this->validateDonation($request);

        if ($user->isAlumni() && $user->alumni) {
            $data['alumni_id'] = $user->alumni->id;
        }

        Donation::create($data);

        return redirect()->route('donations.index')
            ->with('status', 'Donation recorded successfully.');
    }

    public function show(Donation $donation)
    {
        $donation->load('alumni');

        return view('donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        $this->authorizeDonationAccess($donation);
        $alumni = Alumni::orderBy('last_name')->get();

        return view('donations.edit', compact('donation', 'alumni'));
    }

    public function update(Request $request, Donation $donation)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->authorizeDonationAccess($donation);
        $data = $this->validateDonation($request);

        if ($user->isAlumni() && $user->alumni) {
            $data['alumni_id'] = $user->alumni->id;
        }

        $donation->update($data);

        return redirect()->route('donations.show', $donation)
            ->with('status', 'Donation updated successfully.');
    }

    public function destroy(Donation $donation)
    {
        $this->authorizeDonationAccess($donation);
        $donation->delete();

        return redirect()->route('donations.index')
            ->with('status', 'Donation deleted.');
    }

    private function validateDonation(Request $request): array
    {
        return $request->validate([
            'alumni_id' => ['nullable', 'exists:alumnis,id'],
            'donor_name' => ['required', 'string', 'max:255'],
            'donor_email' => ['nullable', 'email', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'donated_at' => ['required', 'date'],
            'purpose' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:pledged,received'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function authorizeDonationAccess(Donation $donation): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            return;
        }

        if (!$user->alumni || $donation->alumni_id !== $user->alumni->id) {
            abort(403);
        }
    }
}
