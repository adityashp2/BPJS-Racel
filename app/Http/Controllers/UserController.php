<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JobDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->with('jobDivision')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('apps.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $jobDivisions = JobDivision::all();
        return view('apps.users.create', compact('jobDivisions'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,user'],
            'job_division_id' => ['nullable', 'exists:job_divisions,id'],
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filePath = Storage::disk('public')->put(User::PHOTO_PATH, $photo);
            $photoPath = $filePath;
        }

        $user = User::create([
            'photo' => $photoPath,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'job_division_id' => $request->job_division_id,
        ]);

        return redirect()
            ->route('users.show', $user)
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $user->load(['jobDivision', 'itemLoans.item']);
        return view('apps.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $jobDivisions = JobDivision::all();
        return view('apps.users.edit', compact('user', 'jobDivisions'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:admin,user'],
            'job_division_id' => ['nullable', 'exists:job_divisions,id'],
        ], [
            'photo.image' => 'Foto harus berupa gambar.',
            'photo.mimes' => 'Foto harus berupa gambar dengan format jpeg, png, jpg, gif, atau svg.',
            'photo.max' => 'Foto maksimal 2MB.',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $photo = $request->file('photo');
            $filePath = Storage::disk('public')->put(User::PHOTO_PATH, $photo);
            $photoPath = $filePath;
        } else {
            $photoPath = $user->photo;
        }

        $user->update([
            'photo' => $photoPath,
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'job_division_id' => $request->job_division_id,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()
            ->route('users.show', $user)
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === Auth::id()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Display the profile of the user.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('apps.users.profile');
    }
}
