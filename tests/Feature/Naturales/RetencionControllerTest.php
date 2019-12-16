<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Retencion;
use App\Models\Institucion;
use App\Models\User;

class RetencionControllerTest extends TestCase
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
    public function test_only_auth()
    {
        $response = $this->get('naturales/naturales/1/retenciones');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function test_index_page()
    {
        $this->actingAs(User::first());
        $response = $this->get('naturales/naturales/1/retenciones');
        $response->assertOk();
        $response->assertViewIs('retencion.index');
        $response->assertViewHasAll(['institucion', 'institucion_id', 'dia', 'mes', 'ano', 'start', 'end']);
    }

    /** @test */
    public function test_retenciones_electronicas_data()
    {
        $this->actingAs(User::first());
        $response = $this->get('naturales/naturales/1/retenciones/data/table');
        $response->assertOk();

    }

    /** @test */
    public function test_retenciones_fisicas_data()
    {
        // assertions
    }
    
    
    
}
