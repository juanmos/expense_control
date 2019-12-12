<?php

namespace Tests\Feature\Naturales;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\DocumentoFisico;
use App\Models\Institucion;
use App\Models\User;
use Crypt;

class DocumentoFisicoControllerTest extends TestCase
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
     
    /** @test */
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
    }
    /** @test */
    public function test_api_only_auth_users()
    {
        $response = $this->post('api/naturales/documentos/compra',[

        ]);
        $response->assertUnauthorized();
    }
    /** @test */
    public function test_validar_documento_lleno()
    {
        $this->actingAs(User::first(),'api');
        $token = auth()->guard('api')
            ->login(User::first());
        $response = $this->post('api/naturales/documentos/compra/store',[
            
        ],$this->headers);
        $response->assertSessionHasErrors('documento');
        $response = $this->post('api/naturales/documentos/compra/store',[
            'documento'=>'Compra'
        ],$this->headers);
        $response->assertSessionHasErrors('documento');
    }

    public function test_validar_foto_lleno()
    {
        $this->actingAs(User::first(),'api');
        $token = auth()->guard('api')
            ->login(User::first());
        $response = $this->post('api/naturales/documentos/compra/store',[
            'documento'=>'compra',
            'foto'=>null
        ],$this->headers);
        $response->assertSessionHasErrors('foto');
    }

    public function test_validar_fecha_lleno()
    {
        $this->actingAs(User::first(),'api');
        $token = auth()->guard('api')
            ->login(User::first());
        $response = $this->post('api/naturales/documentos/compra/store',[
            'documento'=>'compra',
            'foto'=>''
        ],$this->headers);
        $response->assertSessionHasErrors('fecha');
    }

    public function test_crear_documentos()
    {
        // $this->withoutExceptionHandling();
        $this->actingAs(User::first(),'api');
        Storage::fake('public/documentos/1/compra/');

        $file = UploadedFile::fake()->image('avatar.jpg');
        $response = $this->post('api/naturales/documentos/compra/store',[
            'documento'=>'compra',
            'foto' => $file,
            'fecha'=>now()->format('d-m-Y')
        ],$this->headers);
        $response->assertStatus(200);
        $documento =DocumentoFisico::first();
        $this->assertCount(1,DocumentoFisico::all());
        $response->assertJsonStructure(['creado']);
        // Storage::disk('public/documentos/1/compra')->assertExists($file->hashName());
    }


    /** @test */
    public function test_obtener_compras_fisicas_mes()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::first(),'api');
        $response=$this->post('api/naturales/documentos/compra',[],$this->headers);
        
        $response->assertOk();
        $json = (array)json_decode(Crypt::decryptString($response->getContent()));
        
        $this->assertArrayHasKey('documentos',$json);
        $this->assertArrayHasKey('ano',$json);
        $this->assertArrayHasKey('mes',$json);
        $this->assertArrayHasKey('dia',$json);
        // $response->assertJsonStructure(['documentos','ano','mes','dia']);
    }
    

    
    
}
