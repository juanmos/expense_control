<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AlumnoExport implements FromView
{
    private $id=null;

    public function __construct($id)
    {
        $this->id=$id;
    }
    

    public function view(): View
    {
        $usuarios=User::where('institucion_id', $this->id)->whereHas('roles', function ($query) {
            $query->where('name', 'Alumno');
        })->with(['alumno','tarjetas'])->get();
        return view('alumno.export', compact('usuarios'));
    }
}
