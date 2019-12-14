<?php

namespace Tests\Feature\Naturales;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\DocumentoFisico;
use App\Models\Institucion;
use App\Models\User;
use Crypt;

class DocumentoFisicoControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $headers;

    public function setUp():void
    {
        parent::setUp();
        factory(User::class)->create([
            'email'    => 'test@email.com',
            'password' => bcrypt('123456')
        ]);
        factory(Institucion::class)->create();
        $token = auth()->guard('api')
            ->login(User::first());
        $this->headers['Authorization'] = 'Bearer ' . $token;
    }
    
    /** @test */
    public function test_api_only_auth_users()
    {
        $response = $this->post('api/naturales/documentos/compra',[

        ]);
        $response->assertUnauthorized();
    }
    /** @test */
    public function test_validar_documento_lleno()
    {
        $this->actingAs(User::first(),'api');
        $token = auth()->guard('api')
            ->login(User::first());
        $response = $this->post('api/naturales/documentos/compra/store',[
            
        ],$this->headers);
        $response->assertSessionHasErrors('documento');
        $response = $this->post('api/naturales/documentos/compra/store',[
            'documento'=>'Compra'
        ],$this->headers);
        $response->assertSessionHasErrors('documento');
    }

    public function test_validar_foto_lleno()
    {
        $this->actingAs(User::first(),'api');
        $token = auth()->guard('api')
            ->login(User::first());
        $response = $this->post('api/naturales/documentos/compra/store',[
            'documento'=>'compra',
            'foto'=>null
        ],$this->headers);
        $response->assertSessionHasErrors('foto');
    }

    public function test_validar_fecha_lleno()
    {
        $this->actingAs(User::first(),'api');
        $token = auth()->guard('api')
            ->login(User::first());
        $response = $this->post('api/naturales/documentos/compra/store',[
            'documento'=>'compra',
            'foto'=>''
        ],$this->headers);
        $response->assertSessionHasErrors('fecha');
    }

    public function test_crear_documentos()
    {
        $this->actingAs(User::first(),'api');
        Storage::fake('public/documentos/1/compra/');

        $file = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->post('api/naturales/documentos/compra/store',[
            'documento'=>'compra',
            'foto' => $file,
            'fecha'=>now()->format('d-m-Y')
        ],$this->headers);
        $response->assertStatus(200);
        $documento =DocumentoFisico::first();
        $this->assertCount(1,DocumentoFisico::all());
        $response->assertJsonStructure(['creado']);
    }


    /** @test */
    public function test_obtener_compras_fisicas_mes()
    {
        
        $this->actingAs(User::first(),'api');
        $response=$this->post('api/naturales/documentos/compra',[],$this->headers);
        
        $response->assertOk();
        $json = (array)json_decode(Crypt::decryptString($response->getContent()));
        
        $this->assertArrayHasKey('documentos',$json);
        $this->assertArrayHasKey('ano',$json);
        $this->assertArrayHasKey('mes',$json);
        $this->assertArrayHasKey('dia',$json);
        // $response->assertJsonStructure(['documentos','ano','mes','dia']);
    }
    
    public function test_eliminar_documentos()
    {
        $this->actingAs(User::first(),'api');
        Storage::fake('public/documentos/1/compra/');
        $file = UploadedFile::fake()->image('avatar.jpg');
        $this->post('api/naturales/documentos/compra/store',[
            'documento'=>'compra',
            'foto' => $file,
            'fecha'=>now()->format('d-m-Y')
        ],$this->headers);

        $documento =DocumentoFisico::first();
        
        $response=$this->delete('api/naturales/documento/eliminar/compra/'.$documento->id,[],$this->headers);
        $response->assertJsonStructure(['eliminado']);

        $this->assertCount(0,DocumentoFisico::all());
    }

    /** @test */
    public function test_cambiar_categoria_compra()
    {
        $this->actingAs(User::first(),'api');
        Storage::fake('public/documentos/1/compra/');
        $file = UploadedFile::fake()->image('avatar.jpg');
        $this->post('api/naturales/documentos/compra/store',[
            'documento'=>'compra',
            'foto' => $file,
            'fecha'=>now()->format('d-m-Y'),
            'categoria_id'=>1
        ],$this->headers);

        $documento =DocumentoFisico::first();
        $this->assertCount(1, DocumentoFisico::all());
        
        $response =$this->put('api/naturales/documentos/update/'. $documento->id,[
            'categoria_id'=>2
        ],$this->headers);
        $response->assertJsonStructure(['actualizado']);
        $this->assertEquals("2", $documento->fresh()->categoria_id);
    }
    
    
    
}
