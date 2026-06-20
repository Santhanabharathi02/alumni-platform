<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobListingController extends Controller
{
    public function index(Request $request)
    {
        $query = JobListing::query();

        if ($request->filled('type')) {
            $query->where('type', $request->string('type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        } else {
            $query->where('status', 'open');
        }

        if ($request->filled('q')) {
            $search = $request->string('q');
            $query->where(function ($b) use ($search) {
                $b->where('title', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('department', 'like', "%{$search}%");
            });
        }

        $jobs = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('jobs.index', compact('jobs'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('jobs.create', ['job' => new JobListing()]);
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $data = $this->validateJob($request);
        $data['posted_by'] = Auth::id();
        JobListing::create($data);

        return redirect()->route('jobs.index')->with('status', 'Job listing created successfully.');
    }

    public function show(JobListing $job)
    {
        return view('jobs.show', compact('job'));
    }

    public function edit(JobListing $job)
    {
        $this->authorizeAdmin();
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, JobListing $job)
    {
        $this->authorizeAdmin();
        $data = $this->validateJob($request);
        $job->update($data);

        return redirect()->route('jobs.show', $job)->with('status', 'Job listing updated successfully.');
    }

    public function destroy(JobListing $job)
    {
        $this->authorizeAdmin();
        $job->delete();
        return redirect()->route('jobs.index')->with('status', 'Job listing deleted.');
    }

    private function validateJob(Request $request): array
    {
        return $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'company'       => ['required', 'string', 'max:255'],
            'location'      => ['nullable', 'string', 'max:255'],
            'type'          => ['required', 'in:full-time,part-time,internship,contract'],
            'department'    => ['nullable', 'string', 'max:255'],
            'description'   => ['required', 'string'],
            'requirements'  => ['nullable', 'string'],
            'apply_url'     => ['nullable', 'url', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'salary_min'    => ['nullable', 'numeric', 'min:0'],
            'salary_max'    => ['nullable', 'numeric', 'min:0', 'gte:salary_min'],
            'expires_at'    => ['nullable', 'date'],
            'status'        => ['required', 'in:open,closed,filled'],
        ]);
    }

    private function authorizeAdmin(): void
    {
        if (Auth::check() && Auth::user()?->role !== 'admin') {
            abort(403);
        }
    }
}
