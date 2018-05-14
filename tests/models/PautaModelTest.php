<?php

namespace Tests\Models;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Pac\Pauta;
use App\Models\Pac\ComponenteCa;

class PautaModelTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /** @test */
    public function pautaPuedeAsociarComponentes()
    {
        factory(Pauta::class)->create();
        $pauta = Pauta::with('componentes')->first();
        $this->assertCount(0, $pauta->componentes);


        $componente = factory(ComponenteCa::class)->create(['nombre' => 'test']);
            $pauta->componentes()->attach([$componente->id_componente_ca]);
        $pauta = Pauta::with('componentes')->first();
        $this->assertCount(1, $pauta->componentes);
        $this->assertEquals('test', $pauta->componentes[0]->nombre);
    }

}
