<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Site extends Model
{
    use HasFactory;

    public static function getAllSite()
    {
        $site = DB::table('idgen_site as s')
            ->select('id_site', 'site', 'alat', 'lat', 'lon', 'kecamatan', 'kabupaten', 'provinsi', 'username', 'date_created')
            ->join('idgen_provinsi as p', 's.id_provinsi', '=', 'p.id')
            ->join('idgen_kabupaten as kb', 's.id_kabupaten', '=', 'kb.id')
            ->join('idgen_kecamatan as kc', 's.id_kecamatan', '=', 'kc.id')
            ->join('idgen_alat as a', 's.id_alat', '=', 'a.id')
            ->join('users as u', 's.id_user', '=', 'u.id')
            ->get();
        return $site;
    }

    public static function getSite()
    {
        return DB::table('idgen_site as s')
            ->select('id_site', 'site', 'alat', 'lat', 'lon', 'kecamatan', 'kabupaten', 'provinsi', 'username', 'date_created')
            ->join('idgen_provinsi as p', 's.id_provinsi', '=', 'p.id')
            ->join('idgen_kabupaten as kb', 's.id_kabupaten', '=', 'kb.id')
            ->join('idgen_kecamatan as kc', 's.id_kecamatan', '=', 'kc.id')
            ->join('idgen_alat as a', 's.id_alat', '=', 'a.id')
            ->join('users as u', 's.id_user', '=', 'u.id')
            ->orderBy('date_created', 'desc');
    }
}
