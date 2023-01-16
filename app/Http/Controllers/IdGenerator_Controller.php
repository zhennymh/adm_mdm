<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\Site;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiteExport;

class IdGenerator_Controller extends Controller
{
    public function index()
    {
        $id = auth()->user()->id; //tarik id user yang login
        $menu = Menu::getMenuById($id); //tarik menu berdasarkan id user yang login

        $data['title'] = 'ID Generator';
        $data['uri'] = 'idGenerator';
        $data['menu'] = $menu;

        return view('dashboard.idgenerator.idgenerator_index', $data);
    }

    //fungsi untuk menarik data alat
    function idgen_getAlat()
    {
        $alat = DB::table('idgen_alat')
            ->get();

        echo json_encode($alat);
    }

    //fungsi untuk menarik data provinsi
    function idgen_getProvinsi()
    {
        $provinsi = DB::table('idgen_provinsi')
            ->get();

        echo json_encode($provinsi);
    }

    //fungsi untuk menarik data kabupaten berdasarkan provinsi yang dipilih
    function idgen_getKabupaten(Request $request)
    {
        $kabupaten = DB::table('idgen_kabupaten')
            ->where('id_provinsi', '=', $request->id_provinsi)
            ->get();

        echo json_encode($kabupaten);
    }

    //fungsi untuk menarik data kecamatan berdasarkan kabupaten yang dipilih
    function idgen_getKecamatan(Request $request)
    {
        $kecamatan = DB::table('idgen_kecamatan')
            ->where('id_kabupaten', '=', $request->id_kabupaten)
            ->get();

        echo json_encode($kecamatan);
    }

    //fungsi untuk menarik data semua site
    function idgen_getSite(Request $request)
    {
        $id_alat = $request->id_alat;
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $id_provinsi = $request->id_provinsi;
        $id_kabupaten = $request->id_kabupaten;
        $id_kecamatan = $request->id_kecamatan;

        $columns = [
            'no',
            'id_site',
            'id_site_old',
            'site',
            'alat',
            'lat',
            'lon',
            'elevasi',
            'kecamatan',
            'kabupaten',
            'provinsi',
            'username',
            'date_created',
            'action'
        ];

        $orderBy = $columns[request()->input("order.0.column")];

        $data = DB::table('idgen_site as s')
            ->select('id_site', 'id_site_old','site', 'alat', 'lat', 'lon', 'elevasi', 'kecamatan', 'kabupaten', 'provinsi', 'username', 'date_created')
            ->join('idgen_provinsi as p', 's.id_provinsi', '=', 'p.id')
            ->join('idgen_kabupaten as kb', 's.id_kabupaten', '=', 'kb.id')
            ->join('idgen_kecamatan as kc', 's.id_kecamatan', '=', 'kc.id')
            ->join('idgen_alat as a', 's.id_alat', '=', 'a.id')
            ->join('users as u', 's.id_user', '=', 'u.id');

        if ($id_alat) {
            $data->where('s.id_alat', '=', $id_alat);
        }

        if ($id_provinsi) {
            $data->where('s.id_provinsi', '=', $id_provinsi);
        }

        if ($id_kabupaten) {
            $data->where('s.id_kabupaten', '=', $id_kabupaten);
        }

        if ($id_kecamatan) {
            $data->where('s.id_kecamatan', '=', $id_kecamatan);
        }

        if ($date_start && $date_end) {
            $data->whereRaw('DATE(date_created) BETWEEN "' . $date_start . '" AND "' . $date_end . '"');
        }

        if (request()->input("search.value")) {
            $data = $data->where(function ($query) {
                $query->whereRaw('LOWER(site) like ?', ['%' . strtolower(request()->input("search.value")) . '%'])
                    ->orWhereRaw('LOWER(date_created) like ?', ['%' . strtolower(request()->input("search.value")) . '%']);
            });
        }

        $data->orderBy('s.date_created', 'desc');

        $recordsFiltered = $data->get()->count();

        $data = $data
            ->skip(request()->input('start'))
            ->take(request()->input('length'))
            ->orderBy($orderBy, request()->input("order.0.dir"))
            ->get();

        $recordsTotal = $data->count();

        return response()->json([
            'draw' => request()->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
            'all_request' => request()->all()
        ]);
    }

    //fungsi untuk menarik data id terakhir
    function idgen_getLatestId(Request $request)
    {
        $id_kecamatan = $request->id_kecamatan;

        // var_dump($kecamatan_id);
        // die();

        $latest_id = DB::table('idgen_site')
            ->select('id_site')
            ->where('id_site', 'like', $id_kecamatan . '%')
            ->orderByDesc('id_site')
            ->limit(1)
            ->get();

        // $this->db->select('id_site');
        // $this->db->from('id_list');
        // $this->db->like('id_site', $kecamatan_id, 'after');
        // $this->db->order_by('id_site', 'DESC');
        // $this->db->limit(1);
        // $latest_id = $this->db->get()->result();

        if ($latest_id == null || count($latest_id) === 0) {
            $no_data = [];
            $no_data[] = ['id_site' => 'no_data'];

            echo json_encode($no_data);
        } else {
            echo json_encode($latest_id);
        }
    }

    //cek radius
    function idgen_getRadius(Request $request)
    {
        $lat = $request->latitude;
        $lon = $request->longitude;

        $check_radius = DB::table('idgen_site')
            ->selectRaw('`id_site`, ACOS( SIN( RADIANS( `lat` ) ) * SIN( RADIANS( ' . $lat . ' ) ) + COS( RADIANS( `lon` ) ) * COS( RADIANS( ' . $lat . ' )) * COS( RADIANS( `lon` ) - RADIANS( ' . $lon . ' )) ) * 6380 AS `distance`')
            ->whereRaw('ACOS( SIN( RADIANS( `lat` ) ) * SIN( RADIANS( ' . $lat . ' ) ) + COS( RADIANS( `lat` ) ) * COS( RADIANS( ' . $lat . ' )) * COS( RADIANS( `lon` ) - RADIANS( ' . $lon . ' )) ) * 6380 < 0.111')
            ->count();

        echo json_encode($check_radius);
    }

    //menyimpan data ke db
    function idgen_saveSite(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");

        $id_site = $request->id_site;
        $site = $request->site;
        $id_alat = $request->id_alat;
        $lat = $request->lat;
        $lon = $request->lon;
        $elevasi = $request->elevasi;
        $id_provinsi = $request->id_provinsi;
        $id_kabupaten = $request->id_kabupaten;
        $id_kecamatan = $request->id_kecamatan;
        $id_user = $request->id_user;

        $data = [
            'id_site' => $id_site,
            'site' => $site,
            'id_alat' => $id_alat,
            'lat' => $lat,
            'lon' => $lon,
            'elevasi' => $elevasi,
            'id_provinsi' => $id_provinsi,
            'id_kabupaten' => $id_kabupaten,
            'id_kecamatan' => $id_kecamatan,
            'id_user' => $id_user,
            'date_created' => date("Y-m-d H:i:s")
        ];

        DB::table('idgen_site')->insert($data);

        echo "Berhasil input data";
    }

    function idgen_export(Request $request)
    {
        $filename = date("Ymd") . '-Export.xlsx';

        $id_alat = $request->filter_alat;
        $id_provinsi = $request->filter_provinsi;
        $id_kabupaten = $request->filter_kabupaten;
        $id_kecamatan = $request->filter_kecamatan;
        $date_start = $request->filter_date_start;
        $date_end = $request->filter_date_end;

        $excel = (new SiteExport);

        if ($id_alat !== null) {
            $excel = $excel->whereAlat($id_alat);
        }

        if ($id_provinsi !== null) {
            $excel = $excel->whereProvinsi($id_provinsi);
        }

        if ($id_kabupaten !== null) {
            $excel = $excel->whereKabupaten($id_kabupaten);
        }

        if ($id_kecamatan !== null) {
            $excel = $excel->whereKecamatan($id_kecamatan);
        }

        if ($date_start !== null && $date_end !== null) {
            $excel = $excel->whereDate($date_start, $date_end);
        }

        return $excel->download($filename);
    }

    function idgen_deleteSite(Request $request)
    {
        $id_site = $request->id_site;

        try {
            //insert row baru dan tangkap id dari row baru tersebut
            $deleteUser = DB::table('idgen_site')->where('id_site', '=', $id_site)->delete();

            // $deletePermission = DB::table('user_server_permission')->where('userid', '=', $userid)->delete();

            echo "Data user berhasil dihapus.";
        } catch (\Illuminate\Database\QueryException $err) {
            // dd($ex->getMessage());
            echo $err->getMessage();
        }
    }
}
