<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function uploadFoto(?UploadedFile $file): ?string
    {
        if (!$file) {
            return null;
        }

        $filename = uniqid('user_') . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('users', $filename, 'public');
    }

    public function store(array $data): User
    {
        $fotoPath = $this->uploadFoto($data['avatar'] ?? null);

        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'avatar' => $fotoPath
        ]);
    }

    public function update(User $user, array $data): User
    {
        $newFotoPath = $this->uploadFoto($data['avatar'] ?? null);

        if ($newFotoPath && $user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update([
            'name' => $data['name'],
            'username' => $data['username'] ?? $user->username,
            'password' => !empty($data['password'])
                ? Hash::make($data['password'])
                : $user->password,
            'avatar' => $newFotoPath ? $newFotoPath : $user->avatar,
            'role' => $data['role'] ?? $user->role
        ], [
            'confirm_password.same' => 'Konfirmasi password baru tidak cocok!',
        ]);

        return $user;
    }
}
