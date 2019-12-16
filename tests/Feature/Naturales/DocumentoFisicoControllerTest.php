<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\DocumentoFisico;
use App\Models\Institucion;
use App\Models\User;

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
        // $json = (array)json_decode(Crypt::decryptString($response->getContent()));
        
        // $this->assertArrayHasKey('documentos',$json);
        // $this->assertArrayHasKey('ano',$json);
        // $this->assertArrayHasKey('mes',$json);
        // $this->assertArrayHasKey('dia',$json);
    }
    
}
