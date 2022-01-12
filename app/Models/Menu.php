<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    use HasFactory;

    public static function getMenuById($id)
    {
        $menu = DB::table('menu')
            ->join('user_menu', 'menu.id', '=', 'user_menu.menu_id')
            ->join('users', 'user_menu.user_id', '=', 'users.id')
            ->where('users.id', '=', $id)
            ->select('menu', 'url', 'uri', 'icon')
            ->orderBy('menu.id')
            ->get();

        return $menu;
    }

    public static function getMenuByIdAndUrl($id, $url)
    {
        if ($url !== '/') {
            $url = '/' . $url;
        }

        $menu = DB::table('menu')
            ->join('user_menu', 'menu.id', '=', 'user_menu.menu_id')
            ->join('users', 'user_menu.user_id', '=', 'users.id')
            ->where('users.id', '=', $id)
            ->where('menu.url', '=', $url)
            ->get();

        if (count($menu) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAllMenu()
    {
        $menu = DB::table('menu')
            ->select('id', 'menu')
            ->orderBy('menu.id')
            ->get();
        return $menu;
    }
}
