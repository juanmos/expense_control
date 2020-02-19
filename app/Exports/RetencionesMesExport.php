<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\DocumentoFisico;
use App\Models\Institucion;
use App\Models\Retencion;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RetencionesMesExport implements FromView, WithTitle, ShouldAutoSize
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
        $retenciones=$institucion->retenciones()->whereBetween('fecha', [$this->start,$this->end])
                        ->with(['cliente.cliente'])->orderBy('fecha', 'desc')->get();
        $documentos=$institucion->documentos()
                ->where('documento', 'retencion')
                ->whereBetween('fecha', [$this->start,$this->end])
                ->with(['cliente','categoria'])
                ->orderBy('fecha', 'desc')->get();
        return view('exports.retenciones', compact('retenciones', 'documentos'));
    }

    public function title(): string
    {
        return 'Retenciones';
    }
}
