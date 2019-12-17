<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Institucion;
use App\Models\User;
use UsuarioSeeder;
use Event;

class APIAuthControllerTest extends TestCase
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
        $this->seed(UsuarioSeeder::class);
        Event::fake();
    }

    public function test_will_log_a_user_in()
    {
        $this->actingAs(User::first(),'api');
        $response = $this->post('api/login', [
            'email'    => 'test@email.com',
            'password' => '123456'
        ]);
        $response->assertJsonStructure([
            'token',
            'token_type'
        ]);
        $this->assertAuthenticated('api');
    }

    public function test_login_no_user()
    {
        $this->actingAs(User::first(),'api');
        $response = $this->post('api/login', [
            'email'    => 'tet@email.com',
            'password' => '123456'
        ]);
        $response->assertJsonStructure([
            'success',
            'error'
        ]);
        $response->assertJsonFragment(['success'=>false]);
        $response->assertJsonFragment(['error'=>'No hemos encontrado tus credenciales de usuario. Por favor contacte al administrador.']);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_registrar_usuario_existente()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('/api/register',[
            'nombre'    =>  "Juan",
            'apellido'  =>  'Moscoso',
            'email'     =>  'test@email.com',
            'password'  =>  '123456'
        ]);

        $response->assertJsonFragment(['created'=>false]);
        $response->assertJsonFragment(['error'=>'Usuario ya existe']);
    }

    public function test_registrar_usuario_validar_nombre()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('/api/register',[
            'nombre'    =>  "",
            'apellido'  =>  'Moscoso',
            'email'     =>  'juan@email.com',
            'password'  =>  '123456'
        ]);


        $response->assertSessionHasErrors('nombre');
        $response->assertJsonFragment(['created'=>false]);
        $response->assertJsonFragment(['error'=>'Usuario ya existe']);
    }
}
