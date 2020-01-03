<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\RetencionesMesExport;
use App\Exports\FacturasMesExport;
use App\Exports\ComprasMesExport;

class DocumentosMesExport implements WithMultipleSheets
{
    use Exportable;

    private $id=null;
    private $start=null;
    private $end=null;

    public function __construct($id, $start, $end)
    {
        $this->id=$id;
        $this->start=$start;
        $this->end=$end;
    }

    public function sheets(): array
    {
        $sheets = [
            new FacturasMesExport($this->id, $this->start, $this->end),
            new ComprasMesExport($this->id, $this->start, $this->end),
            new RetencionesMesExport($this->id, $this->start, $this->end)
        ];
        return $sheets;
    }
}
