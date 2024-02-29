<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\Pelayanan;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PelayananExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    //fungsi untuk menarik data pemohon
    function peldata_getPemohon()
    {
        $pemohon = DB::table('peldata_jenis_pemohon')
            ->get();

        echo json_encode($pemohon);
    }

    //fungsi untuk menarik data semua surat
    function peldata_getSurat(Request $request)
    {
        $id_jenis_pemohon = $request->id_jenis_pemohon;
        $tanggal_masuk_start = $request->tanggal_masuk_start;
        $tanggal_masuk_end = $request->tanggal_masuk_end;
        $tanggal_terima_start = $request->tanggal_terima_start;
        $tanggal_terima_end = $request->tanggal_terima_end;
        $tanggal_keluar_start = $request->tanggal_keluar_start;
        $tanggal_keluar_end = $request->tanggal_keluar_end;

        $columns = [
            'no',
            'tanggal_masuk',
            'tanggal_terima',
            'surat_masuk',
            'pemohon',
            'jenis_pemohon',
            'jumlah lokasi',
            'lokasi',
            'jumlah_parameter',
            'provinsi',
            'username',
            'date_created',
            'action'
        ];

        $orderBy = $columns[request()->input("order.0.column")];

        $data = DB::table('peldata_surat as s')
            ->select('s.id', 'tanggal_masuk', 'tanggal_terima', 'surat_masuk', 'pemohon', 'jenis_pemohon', 'PIC', 'link_data', 'jumlah_lokasi', 'lokasi', 'jumlah_parameter', 'parameter', 'periode', 'tanggal_keluar', 'surat_keluar', 'keterangan')
            ->join('peldata_jenis_pemohon as jp', 's.id_jenis_pemohon', '=', 'jp.id');

        if ($id_jenis_pemohon) {
            $data->where('s.id_jenis_pemohon', '=', $id_jenis_pemohon);
        }

        if ($tanggal_masuk_start && $tanggal_masuk_end) {
            $data->whereRaw('tanggal_masuk BETWEEN "' . $tanggal_masuk_start . '" AND "' . $tanggal_masuk_end . '"');
        }

        if ($tanggal_terima_start && $tanggal_terima_end) {
            $data->whereRaw('tanggal_terima BETWEEN "' . $tanggal_terima_start . '" AND "' . $tanggal_terima_end . '"');
        }

        if ($tanggal_keluar_start && $tanggal_keluar_end) {
            $data->whereRaw('tanggal_keluar BETWEEN "' . $tanggal_keluar_start . '" AND "' . $tanggal_keluar_end . '"');
        }

        if (request()->input("search.value")) {
            $data = $data->where(function ($query) {
                $query->whereRaw('LOWER(pemohon) like ?', ['%' . strtolower(request()->input("search.value")) . '%'])
                    ->orWhereRaw('LOWER(lokasi) like ?', ['%' . strtolower(request()->input("search.value")) . '%']);
            });
        }

        $data->orderBy('s.id', 'desc');

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

    //fungsi untuk menghapus surat
    function peldata_deleteSurat(Request $request)
    {
        $id_surat = $request->id_surat;

        try {
            $file_exist = DB::table('peldata_surat')
                ->select('file_surat_masuk', 'file_surat_keluar')
                ->where('id', '=', $id_surat)
                ->get();

            //insert row baru dan tangkap id dari row baru tersebut
            $deleteUser = DB::table('peldata_surat')->where('id', '=', $id_surat)->delete();

            if (Storage::exists('public/upload/surat_masuk/' . $file_exist[0]->file_surat_masuk)) {
                Storage::delete('public/upload/surat_masuk/' . $file_exist[0]->file_surat_masuk);
            }

            if (Storage::exists('public/upload/surat_masuk/' . $file_exist[0]->file_surat_keluar)) {
                Storage::delete('public/upload/surat_masuk/' . $file_exist[0]->file_surat_keluar);
            }
            // $deletePermission = DB::table('user_server_permission')->where('userid', '=', $userid)->delete();

            echo "Data surat berhasil dihapus.";
        } catch (\Illuminate\Database\QueryException $err) {
            // dd($ex->getMessage());
            echo $err->getMessage();
        }
    }

    //fungsi untuk menghapus surat
    function peldata_showSurat(Request $request)
    {
        $id_surat = $request->id_surat;

        $surat = DB::table('peldata_surat')
            ->where('id', '=', $id_surat)
            ->get();

        echo json_encode($surat);
    }

    //menyimpan data ke db
    function peldata_save(Request $request)
    {
        // $id = $request->id;
        // $tanggal_masuk = $request->tanggal_masuk;
        // $tanggal_terima = $request->tanggal_terima;
        // $surat_masuk = $request->surat_masuk;
        // $pemohon = $request->pemohon;
        // $id_jenis_pemohon = $request->id_jenis_pemohon;
        // $jumlah_lokasi = $request->jumlah_lokasi;
        // $lokasi = $request->lokasi;
        // $jumlah_parameter = $request->jumlah_parameter;
        // $parameter = $request->parameter;
        // $periode = $request->periode;
        // $tanggal_keluar = $request->tanggal_keluar;
        // $surat_keluar = $request->surat_keluar;

        // $data = [
        //     'id' => $id,
        //     'tanggal_masuk' => $tanggal_masuk,
        //     'tanggal_terima' => $tanggal_terima,
        //     'surat_masuk' => $surat_masuk,
        //     'pemohon' => $pemohon,
        //     'id_jenis_pemohon' => $id_jenis_pemohon,
        //     'jumlah_lokasi' => $jumlah_lokasi,
        //     'lokasi' => $lokasi,
        //     'jumlah_parameter' => $jumlah_parameter,
        //     'parameter' => $parameter,
        //     'periode' => $periode,
        //     'tanggal_keluar' => $tanggal_keluar,
        //     'surat_keluar' => $surat_keluar,
        // ];

        $file_surat_masuk = null;
        $file_surat_keluar = null;

        $file_exist = DB::table('peldata_surat')
            ->select('file_surat_masuk', 'file_surat_keluar')
            ->where('id', '=', $request->show_id)
            ->get();

        // dd($file_exist[0]->file_surat_masuk);

        $validatedData = $request->validate([
            'show_file_surat_masuk' => 'mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'show_file_surat_keluar' => 'mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('show_file_surat_masuk')) {
            $file_surat_masuk = 'SM-' . date('Ymd') . '-' . Str::random(15) . '.' . $request->file('show_file_surat_masuk')->getClientOriginalExtension();
            $surat_masuk_path = $request->file('show_file_surat_masuk')->storeAs('public/upload/surat_masuk', $file_surat_masuk);

            if (Storage::exists('public/upload/surat_masuk/' . $file_exist[0]->file_surat_masuk)) {
                Storage::delete('public/upload/surat_masuk/' . $file_exist[0]->file_surat_masuk);
            }
        }

        if ($request->hasFile('show_file_surat_keluar')) {
            $file_surat_keluar = 'SK-' . date('Ymd') . '-' . Str::random(15) . '.' . $request->file('show_file_surat_keluar')->getClientOriginalExtension();
            $surat_keluar_path = $request->file('show_file_surat_keluar')->storeAs('public/upload/surat_keluar', $file_surat_keluar);

            if (Storage::exists('public/upload/surat_masuk/' . $file_exist[0]->file_surat_keluar)) {
                Storage::delete('public/upload/surat_masuk/' . $file_exist[0]->file_surat_keluar);
            }
        }

        $data = [
            'tanggal_masuk' => $request->show_tanggal_masuk,
            'tanggal_terima' => $request->show_tanggal_terima,
            'surat_masuk' => $request->show_surat_masuk,
            'pemohon' => $request->show_pemohon,
            'id_jenis_pemohon' => $request->show_jenis_pemohon,
            'PIC' => $request->show_pic,
            'link_data' => $request->show_link_data,
            'jumlah_lokasi' => $request->show_jumlah_lokasi,
            'lokasi' => $request->show_lokasi,
            'jumlah_parameter' => $request->show_jumlah_parameter,
            'parameter' => $request->show_parameter,
            'periode' => $request->show_periode,
            'tanggal_keluar' => $request->show_tanggal_keluar,
            'surat_keluar' => $request->show_surat_keluar,
            'keterangan' => $request->show_keterangan,
        ];

        if ($file_surat_masuk !== null) {
            $data['file_surat_masuk'] = $file_surat_masuk;
        }

        if ($file_surat_keluar !== null) {
            $data['file_surat_keluar'] = $file_surat_keluar;
        }

        // dd($data);

        DB::table('peldata_surat')->where('id', $request->show_id)->update($data);

        echo "Berhasil update data";
    }

    //menyimpan data ke db
    function peldata_add(Request $request)
    {
        $file_surat_masuk = null;
        $file_surat_keluar = null;

        $validatedData = $request->validate([
            'add_file_surat_masuk' => 'mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'add_file_surat_keluar' => 'mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('add_file_surat_masuk')) {
            $file_surat_masuk = 'SM-' . date('Ymd') . '-' . Str::random(15) . '.' . $request->file('add_file_surat_masuk')->getClientOriginalExtension();
            $surat_masuk_path = $request->file('add_file_surat_masuk')->storeAs('public/upload/surat_masuk', $file_surat_masuk);
        }

        if ($request->hasFile('add_file_surat_keluar')) {
            $file_surat_keluar = 'SK-' . date('Ymd') . '-' . Str::random(15) . '.' . $request->file('add_file_surat_keluar')->getClientOriginalExtension();
            $surat_keluar_path = $request->file('add_file_surat_keluar')->storeAs('public/upload/surat_keluar', $file_surat_keluar);
        }

        $data = [
            'tanggal_masuk' => $request->add_tanggal_masuk,
            'tanggal_terima' => $request->add_tanggal_terima,
            'surat_masuk' => $request->add_surat_masuk,
            'file_surat_masuk' => $file_surat_masuk,
            'pemohon' => $request->add_pemohon,
            'id_jenis_pemohon' => $request->add_jenis_pemohon,
            'PIC' => $request->add_pic,
            'link_data' => $request->add_link_data,
            'jumlah_lokasi' => $request->add_jumlah_lokasi,
            'lokasi' => $request->add_lokasi,
            'jumlah_parameter' => $request->add_jumlah_parameter,
            'parameter' => $request->add_parameter,
            'periode' => $request->add_periode,
            'tanggal_keluar' => $request->add_tanggal_keluar,
            'surat_keluar' => $request->add_surat_keluar,
            'file_surat_keluar' => $file_surat_keluar,
            'keterangan' => $request->add_keterangan,
        ];

        // dd($data);

        DB::table('peldata_surat')->insert($data);

        echo "Berhasil tambah data";
    }

    function peldata_export(Request $request)
    {
        $filename = date("Ymd") . '-Export-PelayananData.xlsx';

        $id_jenis_pemohon = $request->filter_pemohon;
        $tanggal_masuk = $request->filter_masuk;
        $tanggal_terima = $request->filter_terima;
        $tanggal_keluar = $request->filter_keluar;

        $excel = (new PelayananExport);

        if ($id_jenis_pemohon !== null) {
            $excel = $excel->wherePemohon($id_jenis_pemohon);
        }

        if ($tanggal_masuk !== null) {
            $excel = $excel->whereMasuk($tanggal_masuk);
        }

        if ($tanggal_terima !== null) {
            $excel = $excel->whereTerima($tanggal_terima);
        }

        if ($tanggal_keluar !== null) {
            $excel = $excel->whereKeluar($tanggal_keluar);
        }

        return $excel->download($filename);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'file_up' => 'required|max:2048',

        ]);

        $name = $request->file('file_up')->getClientOriginalName();

        // $path = $request->file('file_up')->store('public/images');

        dd($name);


        // $save = new Photo;

        // $save->name = $name;
        // $save->path = $path;

        // $save->save();

        // return response()->json($path);
    }
}
