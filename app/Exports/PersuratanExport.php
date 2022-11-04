<?php

namespace App\Exports;

use App\Models\Persuratan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class persuratanExport implements FromQuery
{
    use Exportable;

    public function __construct()
    {
        $this->tanggal = null;
        $this->dbname = null;
    }

    public function whereTanggal($tanggal, $dbname)
    {
        $this->tanggal = $tanggal;
        $this->dbname = $dbname;

        return $this;
    }

    public function query()
    {
        // dd($this->id_alat);



        if ($this->tanggal !== null && $this->dbname) {
            if ($this->dbname == 'persuratan_masuk') {
                $query = Persuratan::getSuratMasuk();
            } elseif ($this->dbname == 'persuratan_keluar') {
                $query = Persuratan::getSuratKeluar();
            }

            $tanggal = explode(" - ", $this->tanggal);
            $query->whereRaw('tanggal BETWEEN "' . $tanggal[0] . '" AND "' . $tanggal[1] . '"');
        }

        return $query;
    }
}
