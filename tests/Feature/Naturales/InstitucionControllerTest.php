<?php

namespace Tests\Feature\Naturales;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

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
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        try {
            $response=$this->get('naturales/naturales/create');
        } catch (\Throwable $e) {
        }
        
        $this->assertEquals(
            404,
            $e->getStatusCode()
        );
    }

    public function test_no_metodo_store(){
        $this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());
        try {
            $this->post('naturales/naturales');
        } catch (\Throwable $e) {
            // dd($e->getStatusCode());
        }
        $this->assertEquals(
            404,
            $e->getStatusCode()
        );
    }
    
}
