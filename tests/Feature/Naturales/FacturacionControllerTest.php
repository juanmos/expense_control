<?php

namespace Tests\Feature\Naturales;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;

class FacturacionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp():void
    {
        parent::setUp();
        factory(User::class)->create();
    }
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testImportarFactura()
    {
        $this->actingAs(User::first());
        $response = $this->get('/naturales/facturas/importar');

        $response->assertStatus(200);
        $response->assertViewIs('facturacion.importar');
    }

    /** @test */
    public function testUploadXml()
    {
        $this->actingAs(User::first());
        Storage::fake('photos');

        $response = $this->post('/naturales/facturas/importar', [
            'xml'=>UploadedFile::fake()->image('photo1.jpg')
        ]);
        // $response->dump();

        Storage::disk('photos')->assertExists('photo1.jpg');
    }
}
