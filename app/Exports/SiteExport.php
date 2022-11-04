<?php

namespace App\Exports;

use App\Models\Site;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class siteExport implements FromQuery
{
    use Exportable;

    public function __construct()
    {
        $this->id_alat = null;
        $this->id_provinsi = null;
        $this->id_kabupaten = null;
        $this->id_kecamatan = null;
        $this->date_start = null;
        $this->date_end = null;
    }

    public function whereAlat($id_alat)
    {
        $this->id_alat = $id_alat;

        return $this;
    }

    public function whereProvinsi($id_provinsi)
    {
        $this->id_provinsi = $id_provinsi;

        return $this;
    }

    public function whereKabupaten($id_kabupaten)
    {
        $this->id_kabupaten = $id_kabupaten;

        return $this;
    }

    public function whereKecamatan($id_kecamatan)
    {
        $this->id_kecamatan = $id_kecamatan;

        return $this;
    }

    public function whereDate($date_start, $date_end)
    {
        $this->date_start = $date_start;
        $this->date_end = $date_end;

        return $this;
    }

    public function query()
    {
        // dd($this->id_alat);

        $query = Site::getSite();

        if ($this->id_alat !== null) {
            $query = $query->where('s.id_alat', '=', $this->id_alat);
        }

        if ($this->id_provinsi !== null) {
            $query = $query->where('s.id_provinsi', '=', $this->id_provinsi);
        }

        if ($this->id_kabupaten !== null) {
            $query = $query->where('s.id_kabupaten', '=', $this->id_kabupaten);
        }

        if ($this->id_kecamatan !== null) {
            $query = $query->where('s.id_kecamatan', '=', $this->id_kecamatan);
        }

        if ($this->date_start !== null && $this->date_end !== null) {
            $query->whereRaw('DATE(s.date_created) BETWEEN "' . $this->date_start . '" AND "' . $this->date_end . '"');
        }

        return $query;
    }
}
