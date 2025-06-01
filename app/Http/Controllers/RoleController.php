<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'RoleId' => 'required|string|max:450|unique:roles,RoleId',
            'Name'   => 'nullable|string|max:256',
        ]);

        Role::create($data);

        return redirect()
            ->route('roles.index')
            ->with('success','Rol creado correctamente.');
    }

    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'Name' => 'nullable|string|max:256',
        ]);

        $role->update($data);

        return redirect()
            ->route('roles.index')
            ->with('success','Rol actualizado correctamente.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('success','Rol eliminado correctamente.');
    }
}
