<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{

    function __construct()
    {
        $this->middleware('is_admin');
    }
    function control_panel(Request $request)
    {
        if ($request->ajax()) {
            # code...

            $users = DB::table('users')->get('*');

            return DataTables::of($users)
                ->addColumn('edit', function ($edit) {
                    $edit = '<td class="text-center"><a onclick="edit_user(' . $edit->id . ')">Editar</a></td>';
                    return $edit;
                })
                ->addColumn('delete', function ($delete) {
                    $delete = '<td class="text-center "><a onclick="show_delete_form(' . $delete->id . ')">Borrar</a></td>';
                    return $delete;
                })
                ->rawColumns(['edit', 'delete'])
                ->make(true);
        }
        return view('admin.controlpanel');
    }
    function showdeletemodal($id)
    {
        $user = DB::table('users')->select('username')->where('id', $id)->first();
        return response()->json($user->username);
    }
    function delete_register(Request $request)
    {
        $id = $request->id;
        $user = DB::table('users')->where('id', $id)->first();
        
        if ($user->id == Auth::user()->id) {
            return response()->json("same_admin");
        } else {
            $user_delete = DB::delete('delete from users where id = ?', [$id]);
            
            if ($user_delete == 1) {
                return response()->json(true);
            } else {
                return response()->json(false);
            }
        }
    }
    function edit_register($id)
    { // Return Edit User view
        $user = DB::table('users')->where('id', $id)->first();
        return view('admin.editregister')->with('user', $user);
    }
    function update_register(Request $request)
    { // Query to edit user
        $data = [$request->name, $request->username, $request->email,  $request->password];
        $hashed_password = Hash::make($data[3]);

        DB::table('users')
            ->where('email', $data[2])
            ->update(['name' => $data[0], 'username' => $data[1], 'email' => $data[2], 'password' => $hashed_password, 'updated_at' => date('Y-m-d G:i:s')]);
        return back();
    }
    function edit_users($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return response()->json($user);
    }
    function add_users(Request $request){
        $data = [$request->name, $request->username, $request->email, $request->password];
        $hashed_password = Hash::make($data[3]);
        $adduser = DB::table('users')->insert(['name' => $data[0], 'username' => $data[1], 'email' => $data[2], 'password' => $hashed_password, 'created_at' => date('Y-m-d G:i:s'), 'updated_at' => date('Y-m-d G:i:s') ]); 
        //DB::insert('insert into users (name, username, email, password, created_at, updated_at) values (?, ?, ?, ?, ?, ?)', [$data[0], $data[1], $data[2], $hashed_password, date('Y-m-d G:i:s'), date('Y-m-d G:i:s')]);
        return response()->json($adduser);
        
    }
}
