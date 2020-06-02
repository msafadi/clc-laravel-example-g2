<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.roles.index', [
            'roles' => Role::paginate(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $role = Role::forceCreate([
                'name' => $request->post('name'),
            ]);
            $permissions = $request->post('permissions');
            foreach ($permissions as $code) {
                DB::table('roles_permissions')->insert([
                    'role_id' =>  $role->id,
                    'permission' => $code,
                ]);
            }
            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('roles.index')->with('success', 'Roles added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles.show', [
            'role' => $role,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $permissions = DB::table('roles_permissions')->where('role_id', '=', $role->id)->pluck('permission')->toArray();
        
        return view('admin.roles.edit', [
            'role' => $role,
            'role_permissions' => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $role = Role::findOrFail($id);

        

        DB::beginTransaction();
        try {
            $role->name = $request->post('name');
            $role->save();

            $permissions = $request->post('permissions');
            DB::table('roles_permissions')->where('role_id', $role->id)->delete();
            foreach ($permissions as $code) {
                DB::table('roles_permissions')->insert([
                    'role_id' =>  $role->id,
                    'permission' => $code,
                ]);
            }
            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }



        return redirect()->route('roles.index')->with('success', 'Role updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        
        return redirect()->route('roles.index')->with('success', 'Role deleted!');
    }
}
