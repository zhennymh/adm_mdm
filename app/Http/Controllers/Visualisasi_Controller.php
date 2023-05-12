<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// load model
use App\Models\Menu;

class Visualisasi_Controller extends Controller
{
    public function index()
    {
        // $id = auth()->user()->id; //tarik id user yang login
        // $menu = Menu::getMenuById($id); //tarik menu berdasarkan id user yang login

        $data['title'] = 'Visualisasi';
        $data['uri'] = 'visualisasi';
        // $data['menu'] = $menu;

        return view('dashboard.dashboard_index', $data);
    }

    public function metadatastation()
    {
        $id = auth()->user()->id; //tarik id user yang login
        $menu = Menu::getMenuById($id); //tarik menu berdasarkan id user yang login        

        $data['title'] = 'Visualisasi';
        $data['uri'] = 'visualisasi';
        $data['menu'] = $menu;

        return view('dashboard.visualisasi.metadatastation_index', $data);
    }
}
