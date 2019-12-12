<?php

namespace Tests\Feature\Naturales;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DocumentoFisicoControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ir_a_documentos_fisicos()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
