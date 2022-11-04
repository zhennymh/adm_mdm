<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pelayanan extends Model
{
    use HasFactory;

    // public static function getAllSite()
    // {
    //     $site = DB::table('idgen_site as s')
    //         ->select('id_site', 'site', 'alat', 'lat', 'lon', 'kecamatan', 'kabupaten', 'provinsi', 'username', 'date_created')
    //         ->join('idgen_provinsi as p', 's.id_provinsi', '=', 'p.id')
    //         ->join('idgen_kabupaten as kb', 's.id_kabupaten', '=', 'kb.id')
    //         ->join('idgen_kecamatan as kc', 's.id_kecamatan', '=', 'kc.id')
    //         ->join('idgen_alat as a', 's.id_alat', '=', 'a.id')
    //         ->join('users as u', 's.id_user', '=', 'u.id')
    //         ->get();
    //     return $site;
    // }

    public static function getSurat()
    {
        return DB::table('peldata_surat as s')
            ->select('tanggal_masuk', 'tanggal_terima', 'surat_masuk', 'pemohon', 'id_jenis_pemohon', 'jenis_pemohon', 'jumlah_lokasi', 'lokasi', 'jumlah_parameter', 'parameter', 'periode', 'tanggal_keluar', 'surat_keluar')
            ->join('peldata_jenis_pemohon as jp', 's.id_jenis_pemohon', '=', 'jp.id')
            ->orderBy('tanggal_masuk', 'desc');
    }
}
