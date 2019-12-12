<?php

namespace Tests\Feature\Naturales;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Cliente;
use App\Models\Institucion;
use App\Models\User;
use Crypt;
class ClienteControllerTest extends TestCase
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
    public function test_will_log_a_user_in()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::first(),'api');
        $response = $this->get('api/naturales/clientes',$this->headers);
        $response->assertOk();
    }
    /** @test */
    public function test_api_only_auth_users()
    {
        $response = $this->get('api/naturales/clientes');
        $response->assertUnauthorized();
    }

    /** @test */
    public function test_find_cliente_by_cedula_validacion()
    {
        $response=$this->post('api/naturales/cliente/by/cedula',[

        ],$this->headers);
        $response->assertSessionHasErrors('ruc');
    }
    
    public function test_find_cliente_by_cedula()
    {
        factory(Cliente::class, 13)->create();
        factory(Cliente::class)->create([
            'razon_social'=>'Juan Mosocso',
            'ruc'=>'1234567890001'
        ]);
        $this->assertCount(14,Cliente::all());
        $response=$this->post('api/naturales/cliente/by/cedula',[
            'ruc'=>base64_encode('1234567890001')
        ],$this->headers);
        $json = json_decode(Crypt::decryptString($response->getContent()));
        
        $this->assertCount(1, $json->clientes);
        
    }
}
