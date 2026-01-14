<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $members = User::where('role', 'member')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone'    => 'nullable',
            'address'  => 'nullable',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'address'  => $request->address,
            'role'     => 'member',
        ]);

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Member berhasil ditambahkan');
    }

    public function edit(User $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, User $member)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $member->id,
            'phone' => 'nullable',
            'address' => 'nullable',
        ]);

        $member->update($request->only(
            'name',
            'email',
            'phone',
            'address'
        ));

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Data member berhasil diperbarui');
    }

    public function destroy(User $member)
    {
        $member->delete();

        return back()->with('success', 'Member berhasil dihapus');
    }
}
