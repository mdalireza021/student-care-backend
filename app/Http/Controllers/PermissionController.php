<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function create(Role $role)
    {
        return view('admin.permission.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Role $role
     * @return void
     */
    public function store(Request $request, Role $role)
    {
        $permission = Permission::create(['name' => $request->input('name')]);
        $role->givePermissionTo($permission);

        flash('Permission has been added.')->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
