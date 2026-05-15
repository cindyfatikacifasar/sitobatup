<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'penanggungjawab')->orderBy('name')->paginate(10);
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|min:6|confirmed',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data               = $request->except(['foto', '_token', 'password_confirmation']);
        $data['password']   = Hash::make($request->password);
        $data['role']       = 'penanggungjawab';

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('users', 'public');
        }

        User::create($data);

        return redirect()->route('admin.user.index')->with('success', 'Akun penanggungjawab berhasil ditambahkan.');
    }

    public function show(User $user) { return redirect()->route('admin.user.index'); }

    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|min:6|confirmed',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except(['foto', '_token', '_method', 'password_confirmation']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) Storage::disk('public')->delete($user->foto);
            $data['foto'] = $request->file('foto')->store('users', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'Akun penanggungjawab berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->foto) Storage::disk('public')->delete($user->foto);
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'Akun berhasil dihapus.');
    }
}