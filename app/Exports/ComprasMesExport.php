<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\DocumentoFisico;
use App\Models\Institucion;
use App\Models\Compra;

class ComprasMesExport implements FromView, WithTitle
{
    private $id=null;
    private $start=null;
    private $end=null;

    public function __construct($id, $start, $end)
    {
        $this->id=$id;
        $this->start=$start;
        $this->end=$end;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $institucion = Institucion::find($this->id);
        $compras=$institucion->compras()->whereBetween('fecha', [$this->start,$this->end])
                        ->with(['cliente.cliente','categoria'])->orderBy('fecha', 'desc')->get();
        $documentos=$institucion->documentos()
                ->where('documento', 'compra')
                ->whereBetween('fecha', [$this->start,$this->end])
                ->with(['cliente','categoria'])
                ->orderBy('fecha', 'desc')->get();
        return view('exports.compras', compact('compras', 'documentos'));
    }

    public function title(): string
    {
        return 'Compras';
    }
}