<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kelompok;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::query()
            ->with(['kelompok'])
            ->select(['id', 'name', 'username', 'email', 'role', 'kelompok_id', 'created_at'])
            ->latest('id')
            ->get();

        $kelompoks = Kelompok::query()
            ->orderBy('nama_kelompok')
            ->get();

        return view('admin.users', [
            'user' => $request->user(),
            'users' => $users,
            'kelompoks' => $kelompoks,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateUserInput($request);

        User::create([
            'name' => strip_tags(trim($validated['name'])),
            'username' => strtolower(trim($validated['username'])),
            'email' => strtolower(trim($validated['email'])),
            'role' => $validated['role'],
            'kelompok_id' => $validated['kelompok_id'] ?? null,
            'password' => $validated['password'],
        ]);

        return back()->with('status', 'User baru berhasil ditambahkan.');
    }

    public function update(Request $request, User $targetUser): RedirectResponse
    {
        $validated = $this->validateUserInput($request, $targetUser);

        if ((int) $request->user()->id === (int) $targetUser->id && $validated['role'] !== 'admin') {
            return back()->withErrors('Akun admin yang sedang login tidak bisa diubah menjadi petugas.');
        }

        $updateData = [
            'name' => strip_tags(trim($validated['name'])),
            'username' => strtolower(trim($validated['username'])),
            'email' => strtolower(trim($validated['email'])),
            'role' => $validated['role'],
            'kelompok_id' => $validated['kelompok_id'] ?? null,
        ];

        if (! empty($validated['password'])) {
            $updateData['password'] = $validated['password'];
        }

        $targetUser->update($updateData);

        return back()->with('status', 'Data user berhasil diperbarui.');
    }

    private function validateUserInput(Request $request, ?User $targetUser = null): array
    {
        $isPetugas = $request->input('role') === 'petugas';

        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => [
                'required',
                'string',
                'max:60',
                'regex:/^[A-Za-z0-9._-]+$/',
                Rule::unique('users', 'username')->ignore($targetUser?->id),
            ],
            'email' => ['required', 'email', 'max:120', Rule::unique('users', 'email')->ignore($targetUser?->id)],
            'role' => ['required', 'in:admin,petugas'],
            'kelompok_id' => [
                Rule::requiredIf($isPetugas),
                'nullable',
                'integer',
                Rule::exists('kelompok', 'id'),
            ],
            'password' => [$targetUser ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function bulkDelete(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_ids' => ['required', 'array', 'min:1'],
            'user_ids.*' => ['integer', 'exists:users,id'],
        ]);

        $selectedIds = collect($validated['user_ids'])
            ->map(fn($id) => (int) $id)
            ->unique()
            ->values();

        $currentUserId = (int) $request->user()->id;
        $filteredIds = $selectedIds->reject(fn($id) => $id === $currentUserId)->values();

        if ($filteredIds->isEmpty()) {
            return back()->withErrors('Tidak ada user yang bisa dihapus.');
        }

        $deletedCount = User::query()->whereIn('id', $filteredIds)->delete();

        if ($deletedCount < 1) {
            return back()->withErrors('Hapus user gagal diproses.');
        }

        $message = $deletedCount . ' user berhasil dihapus.';
        if ($selectedIds->contains($currentUserId)) {
            $message .= ' Akun yang sedang login tidak ikut dihapus.';
        }

        return back()->with('status', $message);
    }
}
