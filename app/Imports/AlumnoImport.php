<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AlumnoImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    private $data;

    public function __construct($data){
        $this->data=$data;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $alumno = User::create([
            'nombre'=>$row['est_nombres'],
            'apellido'=>$row['est_apellidos'],
            'cedula'=>$row['est_identificacion'],
            'password'=>bcrypt(random_bytes(10)),
            'institucion_id'=>$this->data['institucion_id']
        ]);
        $alumno->alumno()->create([
            'curso'=>$this->data['curso'],
            'ano_lectivo'=>$this->data['ano_lectivo']
        ]);
        $alumno->assignRole('Alumno');
    }

    public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
    
}
