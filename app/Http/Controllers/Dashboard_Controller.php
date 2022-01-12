<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// load model
use App\Models\Menu;


class Dashboard_Controller extends Controller
{
    public function index()
    {
        $id = auth()->user()->id; //tarik id user yang login
        $menu = Menu::getMenuById($id); //tarik menu berdasarkan id user yang login

        $data['title'] = 'Dashboard';
        $data['uri'] = 'dashboard';
        $data['menu'] = $menu;

        return view('dashboard.dashboard_index', $data);
    }

    public function users()
    {
        $id = auth()->user()->id; //tarik id user yang login
        $menu = Menu::getMenuById($id); //tarik menu berdasarkan id user yang login

        //tarik semua role
        $roles = DB::table('roles')
            ->select('id as role_id', 'role')
            ->get();

        $data['title'] = 'Manajemen User';
        $data['uri'] = 'manajemenUser';
        $data['menu'] = $menu;
        $data['roles'] = $roles;

        return view('dashboard.dashboard_users', $data);
    }

    public function getUsers(Request $request)
    {
        $users = DB::table('users')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->select('users.id as userid', 'username', 'role')
            ->get();

        $data = [];
        $no = 1;

        foreach ($users as $user) {
            $row = [];
            $row[] = $no++;
            $row[] = $user->username;
            $row[] = $user->role;
            $row[] = "<button class=\"btn btn-outline-primary btn-sm\" onclick=\"formEdit($user->userid)\">
            <svg xmlns=\"http://www.w3.org/2000/svg\" class=\"icon\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" stroke-width=\"2\" stroke=\"currentColor\" fill=\"none\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><path d=\"M9 7h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3\" /><path d=\"M9 15h3l8.5 -8.5a1.5 1.5 0 0 0 -3 -3l-8.5 8.5v3\" /><line x1=\"16\" y1=\"5\" x2=\"19\" y2=\"8\" /></svg></span>
            Edit</button>" .
                "<button class=\"btn btn-outline-danger btn-sm\" onclick=\"deleteUser($user->userid, '$user->username')\">
                <span><svg xmlns=\"http://www.w3.org/2000/svg\" class=\"icon\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" stroke-width=\"2\" stroke=\"currentColor\" fill=\"none\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path stroke=\"none\" d=\"M0 0h24v24H0z\" fill=\"none\"/><line x1=\"4\" y1=\"7\" x2=\"20\" y2=\"7\" /><line x1=\"10\" y1=\"11\" x2=\"10\" y2=\"17\" /><line x1=\"14\" y1=\"11\" x2=\"14\" y2=\"17\" /><path d=\"M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12\" /><path d=\"M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3\" /></svg></span>
                Delete</button>";
            $data[] = $row;
        }

        $output = [
            "draw" => $request->draw,
            "recordsTotal" => $no,
            "recordsFiltered" => $no,
            "data" => $data
        ];

        echo json_encode($output);
    }

    public function getUserDetail(Request $request)
    {
        $userDetail = DB::table('users')
            ->select('username', 'users.id as user_id', 'role_id')
            ->where('users.id', '=', $request->userid)
            ->get();

        $userPermissions = DB::table('user_menu')
            ->select('menu_id')
            ->where('user_id', '=', $request->userid)
            ->get();

        // dd($userDetail);

        $data['user_id'] = $userDetail[0]->user_id;
        $data['username'] = $userDetail[0]->username;
        $data['role_id'] = $userDetail[0]->role_id;

        $menu = [];
        foreach ($userPermissions as $userPermission) {
            $menu[] = $userPermission->menu_id;
        }

        $data['menu'] = $menu;


        echo json_encode($data);
    }

    public function addUser(Request $request)
    {
        $username = $request->username;
        $role_id = $request->role_id;
        $password = $request->password;
        $permissions = $request->permission;

        try {
            //insert row baru dan tangkap id dari row baru tersebut
            $insertedId = DB::table('users')
                ->insertGetId([
                    'username' => $username,
                    'password' => Hash::make($password),
                    'role_id' => $role_id,
                ]);

            // $deletePermission = DB::table('user_server_permission')->where('userid', '=', $userid)->delete();
            if ($permissions !== null) {
                foreach ($permissions as $permission) {
                    $updatePermission = DB::table('user_menu')->insert([
                        'user_id' => $insertedId,
                        'menu_id' => $permission
                    ]);
                }
            }

            echo "Data user berhasil ditambahkan.";
        } catch (\Illuminate\Database\QueryException $err) {
            // dd($ex->getMessage());
            echo $err->getMessage();
        }
    }

    public function updateUser(Request $request)
    {
        $user_id = $request->user_id;
        $username = $request->username;
        $role_id = $request->role_id;
        $permissions = $request->permission;

        // dd($user_id, $username, $role_id, $permissions);

        try {
            $updateUser = DB::table('users')
                ->where('id', $user_id)
                ->update([
                    'username' => $username,
                    'role_id' => $role_id,
                ]);

            $deletePermission = DB::table('user_menu')->where('user_id', '=', $user_id)->delete();
            if ($permissions !== null) {
                foreach ($permissions as $permission) {
                    $updatePermission = DB::table('user_menu')->insert([
                        'user_id' => $user_id,
                        'menu_id' => $permission
                    ]);
                }
            }

            echo "Data user berhasil diubah.";
        } catch (\Illuminate\Database\QueryException $err) {
            // dd($ex->getMessage());
            echo $err->getMessage();
        }
    }

    public function deleteUser(Request $request)
    {
        $user_id = $request->user_id;

        try {
            // delete user di tabel users
            $deleteUser = DB::table('users')->where('id', '=', $user_id)->delete();

            // delete permission di tabel user_menu
            $deletePermission = DB::table('user_menu')->where('user_id', '=', $user_id)->delete();

            echo "Data user berhasil dihapus.";
        } catch (\Illuminate\Database\QueryException $err) {
            // dd($ex->getMessage());
            echo $err->getMessage();
        }
    }

    public function getRoles(Request $request)
    {
        $roles = DB::table('roles')
            ->select('id as role_id', 'role')
            ->get();

        echo json_encode($roles);
    }

    public function getAllMenu(Request $request)
    {
        $menu = Menu::getAllMenu(); //tarik menu berdasarkan id user yang login

        echo json_encode($menu);
    }
}
