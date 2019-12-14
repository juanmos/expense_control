<?php

namespace Tests\Feature\Naturales;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Institucion;
use App\Models\Configuracion;

class InstitucionControllerTest extends TestCase
{
    use RefreshDatabase;

    
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testOnlyAuthUsers()
    {
        $response = $this->get('/home');

        $response->assertRedirect('/login');
    }

    public function testAuthUser(){
        $this->actingAs(factory(User::class)->create());
        $response = $this->get('/naturales/naturales');
        $response->assertStatus(302);
        $response->assertRedirect('/naturales/persona/1');
    }

    /** @test */
    public function test_no_metodo_crear()
    {
        $this->actingAs(factory(User::class)->create());
        $response=$this->get('naturales/naturales/create');
        $response->assertNotFound();
    }

    public function test_no_metodo_store(){
        $this->actingAs(factory(User::class)->create());
        $response=$this->post('naturales/naturales');
        $response->assertNotFound();
    }

    /** @test */
    public function test_editar_institucion()
    {
        $this->actingAs(factory(User::class)->create());
        $this->post('admin/institucion/store',[
            'nombre'=>'Nueva institucion',
            'tipo_institucion_id'=>2
        ]);
        $this->assertCount(1,Institucion::all());
        $institucion=Institucion::first();
        $response =$this->get('naturales/naturales/'.$institucion->id.'/edit/');
        $response->assertOk();
        $response=$this->put('naturales/naturales/'.$institucion->id,[
            'nombre'=>'Institucion'
        ]);
        $this->assertEquals('Institucion', $institucion->fresh()->nombre);
        $response->assertRedirect('naturales/persona/'.$institucion->id);
    }

    /** @test */
    public function test_configuraciones()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $this->post('admin/institucion/store',[
            'nombre'=>'Nueva institucion',
            'tipo_institucion_id'=>1
        ]);
        $this->assertCount(1,Institucion::all());

        $response= $this->get('institucion/configuracion/editar');
        $response->assertOk();
        
        $configuracion=Configuracion::first();
        $response=$this->put('institucion/configuracion/update/'.$configuracion->id,[
            'establecimiento'=>'001',
            'punto'=>'001',
            'secuencia'=>1,
            'clave_sri'=>'Institucion'
        ]);
        $this->assertEquals('001', $configuracion->fresh()->configuraciones['establecimiento']);
    }
    
    
    
}
