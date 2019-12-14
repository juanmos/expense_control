<?php

namespace Tests\Feature\Admin;

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
    public function test_instituciones_solo_logeado()
    {
        $response = $this->get('/admin/institucion');

        $response->assertRedirect('/login');
    }

    public function testAuthUser(){
        $this->actingAs(factory(User::class)->create());
        $response = $this->get('/admin/institucion');
        $response->assertOk();
    }

    /** @test */
    public function test_crear_institucion()
    {
        // $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $response=$this->get('/admin/institucion/create');
        $response->assertOk();

        $response=$this->post('admin/institucion/store',[
            'nombre'=>'Nueva institucion'
        ]);
        $this->assertCount(1,Institucion::all());
        $this->assertCount(1,Configuracion::all());
        $response->assertRedirect('/admin/institucion');
    }

    /** @test */
    public function test_crear_validar_nombre()
    {
        $this->actingAs(factory(User::class)->create());
        $response=$this->post('admin/institucion/store',[
            'nombre'=>''
        ]);
        $response->assertSessionHasErrors('nombre');
    }

    /** @test */
    public function test_ver_institucion_persona()
    {
        // $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $this->post('admin/institucion/store',[
            'nombre'=>'Nueva institucion',
            'tipo_institucion_id'=>2
        ]);
        $institucion = Institucion::first();
        $this->assertEquals(2, $institucion->tipo_institucion_id);
        $response=$this->get('admin/institucion/show/'.$institucion->id);
        $response->assertStatus(302);
        $response->assertRedirect('naturales/persona/'.$institucion->id.'/U');
    }

    public function test_ver_institucion_unidad_educativa()
    {
        // $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $this->post('admin/institucion/store',[
            'nombre'=>'Nueva institucion',
            'tipo_institucion_id'=>1
        ]);
        $institucion = Institucion::first();
        $response=$this->get('admin/institucion/show/'.$institucion->id.'/U');
        $response->assertStatus(302);
        $response->assertRedirect('institucion/institucion/'.$institucion->id.'/U');
    }
    
    /** @test */
    public function test_editar_institucion()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        $this->post('admin/institucion/store',[
            'nombre'=>'Nueva institucion',
            'tipo_institucion_id'=>2
        ]);
        $this->assertCount(1,Institucion::all());
        $institucion=Institucion::first();
        $response =$this->get('admin/institucion/'.$institucion->id.'/edit/');
        $response->assertOk();
        $response=$this->put('admin/institucion/'.$institucion->id.'/update/',[
            'nombre'=>'Institucion 1'
        ]);
        $response->assertRedirect('admin/institucion/');
        $this->assertEquals('Institucion 1', $institucion->fresh()->nombre);
    }
    
}
