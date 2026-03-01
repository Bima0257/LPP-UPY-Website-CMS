<?php

namespace App\Services;

use App\Models\Member;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MemberService
{
    public function uploadFoto(?UploadedFile $file): ?string
    {
        if (!$file) {
            return null;
        }

        $filename = uniqid('member_') . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('members', $filename, 'public');
    }

    public function store(array $data): Member
    {
        $fotoPath = $this->uploadFoto($data['foto'] ?? null);

        $lastOrder = Member::max('sort_order') ?? 0;

        return Member::create([
            'nama' => $data['nama'],
            'divisi' => $data['divisi'] ?? null,
            'foto' => $fotoPath,
            'instagram_link' => $data['instagram_link'] ?? null,
            'linkedin_link' => $data['linkedin_link'] ?? null,
            'facebook_link' => $data['facebook_link'] ?? null,
            'sort_order' => $lastOrder + 1,
        ]);
    }

    public function update(Member $member, array $data): Member
    {
        $newFotoPath = $this->uploadFoto($data['foto'] ?? null);

        if ($newFotoPath && $member->foto) {
            Storage::disk('public')->delete($member->foto);
        }

        $member->update([
            'nama' => $data['nama'],
            'divisi' => $data['divisi'] ?? null,
            'foto' => $newFotoPath ? $newFotoPath : $member->foto,
            'instagram_link' => $data['instagram_link'] ?? null,
            'linkedin_link' => $data['linkedin_link'] ?? null,
            'facebook_link' => $data['facebook_link'] ?? null,
        ]);

        return $member;
    }

    public function delete(Member $member): bool
    {

        if ($member->foto && Storage::disk('public')->exists($member->foto)) {
            Storage::disk('public')->delete($member->foto);
        }

        return $member->delete();
    }
}
