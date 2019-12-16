<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\DocumentoFisico;
use App\Models\Institucion;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class DocumentoFisicoControllerTest extends TestCase
{
    use RefreshDatabase;
    public function setUp():void
    {
        parent::setUp();
        factory(User::class)->create();
        factory(Institucion::class)->create();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_only_login_users()
    {
        $response = $this->get('naturales/naturales/1/retenciones');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function test_obtener_documentos_fisicos_tipo()
    {
        $this->actingAs(User::first());
        $response = $this->get('naturales/naturales/documentos/factura');
        $response->assertOk();
    }

    public function test_crear_nueva_documento_fisica()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::first());
        factory(Cliente::class)->create([
            'razon_social'=>'Juan Mosocso',
            'ruc'=>'1234567890001'
        ]);
        $response =$this->get('naturales/naturales/1/documento/retencion/create');
        $response->assertOk();
        $response->assertViewIs('retencion.form');
        $response->assertViewHasAll(['documento','tipo','id','categorias']);
        Storage::fake('public/documentos/1/compra/');

        $file = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->post('naturales/naturales/1/documento/store',[
            'documento'=>'retencion',
            'cliente_id'=>1,
            'cliente_nombre'=>'Juan Moscoso',            
            'ret_iva'=>10,
            'ret_renta'=>25,
            'foto'=>$file,
            'fecha'=>now()->format('d-m-Y')
        ]);
        
        $this->assertCount(1,DocumentoFisico::all());
        $response->assertRedirect('naturales/naturales/1/retenciones');
        
    }

    public function test_crear_nueva_documento_fisico_validaciones()
    {
        $this->actingAs(User::first());
        factory(Cliente::class)->create([
            'razon_social'=>'Juan Mosocso',
            'ruc'=>'1234567890001'
        ]);
        
        $response = $this->post('naturales/naturales/1/documento/store',[]);
        $response->assertSessionHasErrors(['documento','foto','fecha']);
    }
    
}
