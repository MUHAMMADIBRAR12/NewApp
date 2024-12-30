<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Roles = ROle::all();
        $Permissions = Permission::all();
        return view('role.index',compact('Roles','Permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('role.create',compact('permissions'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>[
                'required',
                'string',
            ]
        ]);
        $role = new Role;
        $role->name = $request->name;
        $role->save();
        if ($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }
        return redirect()->route('role.index')->with('role created successfully');
    }

    /**
     * Display the specified resource.
     */

     public function assignPermissions(Request $request)
     {
        
        $role = Role::findById($request->role_id);
        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);
        return redirect()->back()->with('success', 'Permissions assigned successfully!');
     }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::Where('id', $id)->first();
        return view('role.edit', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => [
                'required',
                // 'string',
                // 'unique:permission,name'
            ]
        ]);
        $role = Role::Where('id', $id)->first();
        $role->name = $request->name;
        $role->save();
        return redirect()->route('role.index')->with('Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role= Role::where('id',$id);
        $role->delete();
        return redirect('role')->with('role deleted successfully');
    }
}
