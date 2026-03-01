<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'admin.users-management.index',
            [
                'title' => 'Users Management',
                'users' => User::where('id', '!=', Auth::id())->get()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $this->userService->store($request->validated());
        return redirect()->route('users-management.index')
            ->with('success', 'New user has been added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->userService->update($user, $request->validated());

        // 7️⃣ Redirect dengan notifikasi sukses
        return redirect()->route('users-management.index')
            ->with('success', 'User telah berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->avatar && Storage::exists($user->avatar)) {
            Storage::delete($user->avatar);
        }

        $user->delete();

        return redirect('/users-management')->with('success', 'User Telah Di hapus!');
    }

    public function profile()
    {
        $title = 'Profile';
        $user = Auth::user();
        return view('admin.profile.index', compact('user', 'title'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // ✅ Validasi dasar
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password_current' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed', // gunakan confirmed untuk validasi password_confirmation
        ]);

        // ✅ Jika user ingin ganti password
        if ($request->filled('password_current') || $request->filled('password')) {

            // Pastikan password lama benar
            if (!Hash::check($request->password_current, $user->password)) {
                return back()->withErrors(['password_current' => 'Password lama tidak sesuai.'])->withInput();
            }

            // Update password baru
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']); // jangan ubah password
        }

        // ✅ Upload avatar baru (hapus lama jika ada)
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }

            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Hapus field yang tidak perlu sebelum update
        unset($validated['password_current']);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
