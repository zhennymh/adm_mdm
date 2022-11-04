<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PersuratanExport;

class Persuratan_Controller extends Controller
{
    public function index()
    {
        $id = auth()->user()->id; //tarik id user yang login
        $menu = Menu::getMenuById($id); //tarik menu berdasarkan id user yang login

        $data['title'] = 'Persuratan';
        $data['uri'] = 'persuratan';
        $data['menu'] = $menu;

        return view('dashboard.persuratan.persuratan_index', $data);
    }

    //fungsi untuk menarik data pemohon
    function peldata_getPemohon()
    {
        $pemohon = DB::table('peldata_jenis_pemohon')
            ->get();

        echo json_encode($pemohon);
    }

    //fungsi untuk menarik data semua surat
    function persuratan(Request $request)
    {
        // $id_jenis_pemohon = $request->id_jenis_pemohon;
        $tanggal_start = $request->tanggal_start;
        $tanggal_end = $request->tanggal_end;
        // $tanggal_terima_start = $request->tanggal_terima_start;
        // $tanggal_terima_end = $request->tanggal_terima_end;
        // $tanggal_keluar_start = $request->tanggal_keluar_start;
        // $tanggal_keluar_end = $request->tanggal_keluar_end;

        // dd($tanggal_end);

        $db_table = $request->db_table;

        $columns = [
            'no',
            'nomor_surat',
            'tanggal',
            'action',
        ];

        $orderBy = $columns[request()->input("order.0.column")];

        $data = DB::table($db_table)
            ->select('id', 'nomor_surat', 'tanggal', 'perihal');

        if ($tanggal_start && $tanggal_end) {
            $data->whereRaw('tanggal BETWEEN "' . $tanggal_start . '" AND "' . $tanggal_end . '"');
        }

        if (request()->input("search.value")) {
            $data = $data->where(function ($query) {
                $query->whereRaw('LOWER(nomor_surat) like ?', ['%' . strtolower(request()->input("search.value")) . '%']);
            });
        }

        $data->orderBy('id', 'desc');

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
    function persuratan_deleteSurat(Request $request)
    {
        $id = $request->id_surat;
        $db_table = $request->db_table;

        try {
            //insert row baru dan tangkap id dari row baru tersebut
            $deleteUser = DB::table($db_table)->where('id', '=', $id)->delete();

            // $deletePermission = DB::table('user_server_permission')->where('userid', '=', $userid)->delete();

            echo "Data surat berhasil dihapus.";
        } catch (\Illuminate\Database\QueryException $err) {
            // dd($ex->getMessage());
            echo $err->getMessage();
        }
    }

    //fungsi untuk menampilkan detail surat
    function persuratan_showSurat(Request $request)
    {
        $id = $request->id_surat;
        $db_table = $request->db_table;

        $surat = DB::table($db_table)
            ->where('id', '=', $id)
            ->get();

        echo json_encode($surat);
    }

    //menyimpan data ke db
    function peldata_save(Request $request)
    {
        $id = $request->id;
        $tanggal_masuk = $request->tanggal_masuk;
        $tanggal_terima = $request->tanggal_terima;
        $surat_masuk = $request->surat_masuk;
        $pemohon = $request->pemohon;
        $id_jenis_pemohon = $request->id_jenis_pemohon;
        $jumlah_lokasi = $request->jumlah_lokasi;
        $lokasi = $request->lokasi;
        $jumlah_parameter = $request->jumlah_parameter;
        $parameter = $request->parameter;
        $periode = $request->periode;
        $tanggal_keluar = $request->tanggal_keluar;
        $surat_keluar = $request->surat_keluar;

        $data = [
            'id' => $id,
            'tanggal_masuk' => $tanggal_masuk,
            'tanggal_terima' => $tanggal_terima,
            'surat_masuk' => $surat_masuk,
            'pemohon' => $pemohon,
            'id_jenis_pemohon' => $id_jenis_pemohon,
            'jumlah_lokasi' => $jumlah_lokasi,
            'lokasi' => $lokasi,
            'jumlah_parameter' => $jumlah_parameter,
            'parameter' => $parameter,
            'periode' => $periode,
            'tanggal_keluar' => $tanggal_keluar,
            'surat_keluar' => $surat_keluar,
        ];

        DB::table('peldata_surat')->where('id', $id)->update($data);

        echo "Berhasil update data";
    }

    //menyimpan data ke db
    function persuratan_add_masuk(Request $request)
    {
        $data = [
            'nomor_surat' => $request->nomor_surat,
            'tanggal' => $request->tanggal,
            'perihal' => $request->perihal,
        ];

        DB::table('persuratan_masuk')->insert($data);

        echo "Berhasil tambah data";
    }

    function persuratan_add_keluar(Request $request)
    {
        $data = [
            'nomor_surat' => $request->nomor_surat,
            'tanggal' => $request->tanggal,
            'perihal' => $request->perihal,
        ];

        DB::table('persuratan_keluar')->insert($data);

        echo "Berhasil tambah data";
    }

    function persuratan_header()
    {
        $header = DB::table('kp_header')
            ->get();

        echo json_encode($header);
    }

    function persuratan_subheader(Request $request)
    {
        $subheader = DB::table('kp_subheader')
            ->where('id_header', '=', $request->id_header)
            ->get();

        echo json_encode($subheader);
    }

    function persuratan_cekSequence(Request $request)
    {
        $jenis = $request->jenis;
        $header = $request->header;
        $subheader = $request->subheader;
        $year = $request->year;
        $month = $request->month;

        if ($jenis == 'KP') {
            $sequence = DB::table('persuratan_keluar')
                ->select('nomor_surat')
                ->whereRaw('`nomor_surat` like "' . $jenis . '.' . $header . '.' . $subheader . '%' . $year . '"')
                ->limit(1)
                ->orderBy('nomor_surat', 'desc')
                ->get();

            if (!$sequence->isEmpty()) {
                $seq = explode("/", $sequence[0]->nomor_surat);
                $seq = (int)$seq[1] + 1;

                if ($seq < 10) {
                    $seq = '00' . $seq;
                } elseif ($seq > 10 && $seq < 100) {
                    $seq = '0' . $seq;
                } elseif ($seq >= 100) {
                    $seq = $seq;
                }

                if ($subheader == null) {
                    $nomor_surat = $jenis . '.' . $header . '/' . $seq . '/KSMDM/' . $month . '/' . $year;
                } else {
                    $nomor_surat = $jenis . '.' . $header . '.' . $subheader . '/' . $seq . '/KSMDM/' . $month . '/' . $year;
                }


                echo json_encode($nomor_surat);
            } else {
                $seq = '001';

                if ($subheader == null) {
                    $nomor_surat = $jenis . '.' . $header . '/' . $seq . '/KSMDM/' . $month . '/' . $year;
                } else {
                    $nomor_surat = $jenis . '.' . $header . '.' . $subheader . '/' . $seq . '/KSMDM/' . $month . '/' . $year;
                }

                echo json_encode($nomor_surat);
            }
        } elseif ($jenis == 'ND') {
            $sequence = DB::table('persuratan_keluar')
                ->select('nomor_surat')
                ->whereRaw('`nomor_surat` like "' . $jenis . '%' . $year . '"')
                ->limit(1)
                ->orderBy('nomor_surat', 'desc')
                ->get();

            if (!$sequence->isEmpty()) {
                $seq = explode("/", $sequence[0]->nomor_surat);
                $seq = (int)$seq[1] + 1;

                if ($seq < 10) {
                    $seq = '00' . $seq;
                } elseif ($seq > 10 && $seq < 100) {
                    $seq = '0' . $seq;
                } elseif ($seq >= 100) {
                    $seq = $seq;
                }

                $nomor_surat = $jenis . '/' . $seq . '/KSMDM/' . $month . '/' . $year;

                echo json_encode($nomor_surat);
            } else {
                $seq = '001';

                $nomor_surat = $jenis . '/' . $seq . '/KSMDM/' . $month . '/' . $year;

                echo json_encode($nomor_surat);
            }
        }
    }

    function persuratan_export(Request $request)
    {

        $jenis_surat = $request->filter_jenis_surat;
        $tanggal = $request->filter_tanggal;

        $filename = date("Ymd") . '-Export-Persuratan-' . ucfirst($jenis_surat) . '.xlsx';

        if ($jenis_surat == 'masuk') {
            $dbname = 'persuratan_masuk';
        } elseif ($jenis_surat == 'keluar') {
            $dbname = 'persuratan_keluar';
        }

        $excel = (new PersuratanExport);

        if ($tanggal !== null) {
            $excel = $excel->whereTanggal($tanggal, $dbname);
        }

        return $excel->download($filename);
    }
}
