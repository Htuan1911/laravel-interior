<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name|max:50',
        ]);

        Role::create($request->only('name'));
        return redirect()->route('admin.roles.index')->with('success', 'Vai trò đã được tạo.');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|max:50|unique:roles,name,' . $role->id,
        ]);

        $role->update($request->only('name'));
        return redirect()->route('admin.roles.index')->with('success', 'Cập nhật thành công.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Xóa thành công.');
    }
}
