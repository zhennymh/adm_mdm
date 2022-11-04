<?php

namespace App\Exports;

use App\Models\Pelayanan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class pelayananExport implements FromQuery
{
    use Exportable;

    public function __construct()
    {
        $this->id_jenis_pemohon = null;
        $this->tanggal_masuk = null;
        $this->tanggal_terima = null;
        $this->tanggal_keluar = null;
    }

    public function wherePemohon($id_jenis_pemohon)
    {
        $this->id_jenis_pemohon = $id_jenis_pemohon;

        return $this;
    }

    public function whereMasuk($tanggal_masuk)
    {
        $this->tanggal_masuk = $tanggal_masuk;

        return $this;
    }

    public function whereTerima($tanggal_terima)
    {
        $this->tanggal_terima = $tanggal_terima;

        return $this;
    }

    public function whereKeluar($tanggal_keluar)
    {
        $this->tanggal_keluar = $tanggal_keluar;

        return $this;
    }

    public function query()
    {
        // dd($this->id_alat);

        $query = Pelayanan::getSurat();

        if ($this->id_jenis_pemohon !== null) {
            $query = $query->where('s.id_jenis_pemohon', '=', $this->id_jenis_pemohon);
        }

        if ($this->tanggal_masuk !== null) {
            $masuk = explode(" - ", $this->tanggal_masuk);
            $query->whereRaw('s.tanggal_masuk BETWEEN "' . $masuk[0] . '" AND "' . $masuk[1] . '"');
            // $query = $query->whereRaw('s.tanggal_masuk', '=', $this->tanggal_masuk);
        }

        if ($this->tanggal_terima !== null) {
            $terima = explode(" - ", $this->tangal_terima);
            $query->whereRaw('s.tanggal_terima BETWEEN "' . $terima[0] . '" AND "' . $terima[1] . '"');
            // $query = $query->where('s.tanggal_terima', '=', $this->tanggal_terima);
        }

        if ($this->tanggal_keluar !== null) {
            $keluar = explode(" - ", $this->tanggal_keluar);
            $query->whereRaw('s.tanggal_keluar BETWEEN "' . $keluar[0] . '" AND "' . $keluar[1] . '"');
            // $query = $query->where('s.tanggal_keluar', '=', $this->tanggal_keluar);
        }

        return $query;
    }
}
