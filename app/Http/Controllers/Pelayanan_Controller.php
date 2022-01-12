<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class Pelayanan_Controller extends Controller
{
    public function index()
    {
        $id = auth()->user()->id; //tarik id user yang login
        $menu = Menu::getMenuById($id); //tarik menu berdasarkan id user yang login

        $data['title'] = 'Pelayanan Data';
        $data['uri'] = 'pelayananData';
        $data['menu'] = $menu;

        return view('dashboard.pelayanandata.pelayanandata_index', $data);
    }
}
