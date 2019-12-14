<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Ayuda;

class AyudaControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testOnlyAuthUsers()
    {
        $response = $this->get('/ayuda');

        $response->assertRedirect('/login');
    }

    public function testAuthUser(){
        $this->actingAs(factory(User::class)->create());
        $response = $this->get('/ayuda');
        $response->assertStatus(200);
    }

    /** @test */
    public function test_ir_a_crear()
    {
        $this->actingAs(factory(User::class)->create());
        $response=$this->get('ayuda/create');
        $response->assertOk();
    }
    
    /** @test */
    public function test_create_ayuda()
    {
        $this->actingAs(factory(User::class)->create());
        $response = $this->post('/ayuda',[
            'titulo'=>'Nuevo titulo'
        ]);
        $this->assertCount(1,Ayuda::all());
        $response->assertRedirect('/ayuda');
    }

    /** @test */
    public function test_titulo_es_obligatorio()
    {
        $this->actingAs(factory(User::class)->create());
        $response = $this->post('/ayuda',[
            'titulo'=>''
        ]);
        $response->assertSessionHasErrors('titulo');
    }

    public function test_editar_ayuda(){
        $this->actingAs(factory(User::class)->create());
        $this->post('/ayuda',[
            'titulo'=>'Nuevo titulo'
        ]);
        $this->assertCount(1,Ayuda::all());

        $ayuda = Ayuda::first();
        $response = $this->get('/ayuda/'.$ayuda->id);
        $response->assertOk();
        $response = $this->put('ayuda/'.$ayuda->id,[
            'titulo'=>'otro titulo'
        ]);
        $response->assertRedirect('/ayuda');
        $this->assertEquals('otro titulo', $ayuda->fresh()->titulo);
    }

    /** @test */
    public function test_eliminar_ayuda()
    {
        $this->actingAs(factory(User::class)->create());
        $this->post('/ayuda',[
            'titulo'=>'Nuevo titulo'
        ]);
        $this->assertCount(1,Ayuda::all());

        $ayuda = Ayuda::first();
        $response = $this->delete('ayuda/'.$ayuda->id);

        $this->assertCount(0, Ayuda::all());
        $response->assertSessionHas('mensaje','La ayuda ha sido eliminada');
        // $response->assertRedirect('/ayuda');
    }
    
    
    
    
    
}
