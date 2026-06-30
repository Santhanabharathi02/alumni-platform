<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AlumniController extends Controller
{
    public function index(Request $request)
    {
        $query = Alumni::query();

        if ($request->filled('q')) {
            $search = $request->string('q');
            $searchTerms = explode(' ', trim($search));
            $searchColumns = Alumni::searchableColumns();
            
            $query->where(function ($builder) use ($searchTerms, $searchColumns) {
                foreach ($searchTerms as $term) {
                    $term = "%{$term}%";
                    $builder->where(function ($subBuilder) use ($term, $searchColumns) {
                        foreach ($searchColumns as $column) {
                            $subBuilder->orWhere($column, 'like', $term);
                        }
                    });
                }
            });
        }

        if ($request->filled('department')) {
            $query->where('department', $request->string('department'));
        }
        if ($request->filled('graduation_year')) {
            $query->where('graduation_year', $request->integer('graduation_year'));
        }
        if ($request->filled('mentor')) {
            $query->where('is_mentor', true);
        }

        foreach (Alumni::nameSortColumns() as $column) {
            $query->orderBy($column, 'asc');
        }

        $alumni = $query->paginate(10)->withQueryString();

        $departments = Alumni::select('department')->whereNotNull('department')->distinct()->orderBy('department')->pluck('department');
        $gradYears = Alumni::select('graduation_year')->whereNotNull('graduation_year')->distinct()->orderByDesc('graduation_year')->pluck('graduation_year');

        return view('alumni.index', compact('alumni', 'departments', 'gradYears'));
    }

    public function create()
    {
        if (Auth::check() && Auth::user()?->role === 'alumni') { abort(403); }
        return view('alumni.create', ['alumni' => new Alumni()]);
    }

    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()?->role === 'alumni') { abort(403); }
        $data = $this->validateAlumni($request);
        $data['is_mentor'] = $request->boolean('is_mentor');
        $data['available_for_internships'] = $request->boolean('available_for_internships');
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('alumni-photos', 'public');
        }
        Alumni::create($data);
        return redirect()->route('alumni.index')->with('status', 'Alumni profile created successfully.');
    }

    public function show(Alumni $alumnus)
    {
        $alumni = $alumnus;
        $alumni->load(['mentorships', 'donations', 'eventRegistrations.event']);
        $userRegisteredEventIds = [];
        if (Auth::check() && Auth::user()?->role === 'alumni' && Auth::user()->alumni) {
            $userRegisteredEventIds = Auth::user()->alumni->eventRegistrations()->pluck('event_id')->toArray();
        }
        return view('alumni.show', compact('alumni', 'userRegisteredEventIds'));
    }

    public function edit(Alumni $alumnus)
    {
        $alumni = $alumnus;
        if (Auth::check() && Auth::user()?->role === 'alumni') {
            if (!Auth::user()->alumni || Auth::user()->alumni->id !== $alumni->id) { abort(403); }
        }
        return view('alumni.edit', compact('alumni'));
    }

    public function update(Request $request, Alumni $alumnus)
    {
        $alumni = $alumnus;
        if (Auth::check() && Auth::user()?->role === 'alumni') {
            if (!Auth::user()->alumni || Auth::user()->alumni->id !== $alumni->id) { abort(403); }
        }
        $data = $this->validateAlumni($request, $alumni->id);
        $data['is_mentor'] = $request->boolean('is_mentor');
        $data['available_for_internships'] = $request->boolean('available_for_internships');
        if ($request->hasFile('photo')) {
            if ($alumni->photo_path) { Storage::disk('public')->delete($alumni->photo_path); }
            $data['photo_path'] = $request->file('photo')->store('alumni-photos', 'public');
        }
        $alumni->update($data);
        return redirect()->route('alumni.show', $alumni)->with('status', 'Alumni profile updated successfully.');
    }

    public function destroy(Alumni $alumnus)
    {
        $alumni = $alumnus;
        if (Auth::check() && Auth::user()?->role === 'alumni') { abort(403); }
        if ($alumni->photo_path) { Storage::disk('public')->delete($alumni->photo_path); }
        $alumni->delete();
        return redirect()->route('alumni.index')->with('status', 'Alumni profile deleted.');
    }

    public function createAccount(Alumni $alumnus)
    {
        abort_unless(Auth::user()->isAdmin(), 403);

        // Already has a user account?
        if (User::where('email', $alumnus->email)->exists()) {
            return back()->with('error', 'A portal account for this email already exists. The alumni can log in at /login.');
        }

        // Generate a temporary password
        $tempPassword = ucfirst(Str::random(6)) . rand(10, 99) . '!';

        User::create([
            'name'      => $alumnus->full_name,
            'email'     => $alumnus->email,
            'password'  => Hash::make($tempPassword),
            'role'      => 'alumni',
            'alumni_id' => $alumnus->id,
        ]);

        return back()->with('status',
            "Portal account created! Email: {$alumnus->email} — Temporary password: {$tempPassword} — Ask the alumni to change it after first login."
        );
    }

    public function export()
    {
        if (Auth::check() && Auth::user()?->role === 'alumni') { abort(403); }
        $alumniQuery = Alumni::query();

        foreach (Alumni::nameSortColumns() as $column) {
            $alumniQuery->orderBy($column, 'asc');
        }

        $alumni = $alumniQuery->get();
        $filename = 'alumni-export-' . now()->format('Y-m-d') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="' . $filename . '"'];
        $columns = ['ID','First Name','Last Name','Email','Phone','Graduation Year','Degree','Department','Company','Job Title','Location','LinkedIn','Is Mentor','Available for Internships','Last Contacted','Created At'];
        $callback = function () use ($alumni, $columns) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            foreach ($alumni as $a) {
                fputcsv($out, [$a->id,$a->first_name ?? '',$a->last_name ?? '',$a->email,$a->phone,$a->graduation_year,$a->degree,$a->department,$a->company,$a->job_title,$a->location,$a->linkedin_url,$a->is_mentor?'Yes':'No',$a->available_for_internships?'Yes':'No',$a->last_contacted_at?->format('Y-m-d'),$a->created_at->format('Y-m-d')]);
            }
            fclose($out);
        };
        return response()->stream($callback, 200, $headers);
    }

    private function validateAlumni(Request $request, ?int $alumniId = null): array
    {
        return $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:alumnis,email,' . ($alumniId ?? 'NULL') . ',id'],
            'phone' => ['nullable', 'string', 'max:50'],
            'graduation_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 5)],
            'degree' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'bio' => ['nullable', 'string'],
            'last_contacted_at' => ['nullable', 'date'],
            'is_mentor' => ['nullable', 'boolean'],
            'available_for_internships' => ['nullable', 'boolean'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ], [
            'email.unique' => 'This alumni email address is already in the system.',
        ]);
    }
}
