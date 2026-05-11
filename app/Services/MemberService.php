<?php

namespace App\Services;

use App\Models\Member;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MemberService
{
    public function uploadFoto(?UploadedFile $file): ?string
    {
        if (!$file) {
            return null;
        }

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('members', $filename, 'public');
    }

    public function store(array $data): Member
    {
        return DB::transaction(function () use ($data) {

            $fotoPath = $this->uploadFoto($data['foto'] ?? null);

            try {
                $lastOrder = Member::lockForUpdate()->max('sort_order') ?? 0;

                return Member::create([
                    'nama' => $data['nama'],
                    'divisi' => $data['divisi'] ?? null,
                    'foto' => $fotoPath,
                    'instagram_link' => $data['instagram_link'] ?? null,
                    'linkedin_link' => $data['linkedin_link'] ?? null,
                    'facebook_link' => $data['facebook_link'] ?? null,
                    'sort_order' => $lastOrder + 1,
                ]);
            } catch (\Exception $e) {

                if ($fotoPath) {
                    Storage::disk('public')->delete($fotoPath);
                }

                throw $e;
            }
        });
    }

    public function update(Member $member, array $data): Member
    {
        return DB::transaction(function () use ($member, $data) {

            $newFotoPath = $this->uploadFoto($data['foto'] ?? null);
            $oldFoto = $member->foto;

            $member->update([
                'nama' => $data['nama'],
                'divisi' => $data['divisi'] ?? null,
                'foto' => $newFotoPath ?? $oldFoto,
                'instagram_link' => $data['instagram_link'] ?? null,
                'linkedin_link' => $data['linkedin_link'] ?? null,
                'facebook_link' => $data['facebook_link'] ?? null,
            ]);

            if ($newFotoPath && $oldFoto && Storage::disk('public')->exists($oldFoto)) {
                Storage::disk('public')->delete($oldFoto);
            }

            return $member;
        });
    }

    public function delete(Member $member): bool
    {

        DB::transaction(function () use ($member) {

            if ($member->foto && Storage::disk('public')->exists($member->foto)) {
                Storage::disk('public')->delete($member->foto);
            }

            $deletedOrder = $member->sort_order;

            $member->delete();

            Member::where('sort_order', '>', $deletedOrder)
                ->decrement('sort_order');
        });

        return true;
    }
}
