<?php

namespace App\Imports;

use App\Models\Cliente;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClienteImport implements ToModel, WithProgressBar, WithChunkReading, WithBatchInserts, WithCustomCsvSettings,WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // if(Cliente::where('ruc',$row['numero_ruc'])->first()!=null){
        //     return null;
        // }
        $razon=(strlen($row['razon_social'])<190)?$row['razon_social']:substr($row['razon_social'],0,190);
        return new Cliente([
            'ruc'=>$row['numero_ruc'],
            'razon_social'=>$razon,
            'nombre_comercial'=>($row['nombre_comercial']!=null)?(strlen($row['nombre_comercial'])<190)?$row['nombre_comercial']:substr($row['nombre_comercial'],0,190):$razon,
            'direccion'=>$row['calle'].' '.$row['numero'].' '.$row['interseccion']
        ]);
    }

    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'ISO-8859-1',
            'delimiter'=>"\t",
            'enclosure'=> '"',
        ];
    }

    public function batchSize(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 2000;
    }
}
