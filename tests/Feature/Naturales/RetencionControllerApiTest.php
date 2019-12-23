<?php

namespace Tests\Feature\Naturales;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Retencion;
use App\Models\Institucion;
use App\Models\User;
use Crypt;

class RetencionControllerApiTest extends TestCase
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
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_api_only_auth_users()
    {
        $response = $this->post('api/naturales/retenciones',[

        ]);
        $response->assertUnauthorized();
    }

    /** @test */
    public function test_obtener_retenciones()
    {
        $response = $this->post('api/naturales/retenciones',[],$this->headers);;
        $response->assertOk();
        $json = (array)json_decode(Crypt::decryptString($response->getContent()));
        
        $this->assertArrayHasKey('retenciones',$json);
        
    }

    /** @test */
    public function test_obtener_retenciones_clientes()
    {
        $response = $this->get('api/naturales/retenciones/cliente/'.base64_encode(1),$this->headers);
        $response->assertOk();
        $json = (array)json_decode(Crypt::decryptString($response->getContent()));
        
        $this->assertArrayHasKey('retenciones',$json);
    }
    
    
}
