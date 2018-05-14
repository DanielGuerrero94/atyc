<?php

use Illuminate\Database\Seeder;
use App\Models\Pac\ComponenteCa;
use App\Models\Pac\Pauta;

class PautasComponentesCaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seed_2018();
    }

    public function seed_2018()
    {
        $anio = 2018;

        $ca_6 = ComponenteCa::where('item', 6)->where('anio_vigencia', $anio)->first();

        //Pautas 1
        $pac = Pauta::where('nombre', '1.1')->where('vigencia', $anio)->get();
        $pac->componentes()->attach($ca_6);
        $pac = Pauta::where('nombre', '1.2')->where('vigencia', $anio)->get();
        $pac->componentes()->attach($ca_6);
        $pac = Pauta::where('nombre', '1.3')->where('vigencia', $anio)->get();
        $pac->componentes()->attach($ca_6);
        $pac = Pauta::where('nombre', '1.4')->where('vigencia', $anio)->get();
        $pac->componentes()->attach($ca_6);
        $pac = Pauta::where('nombre', '1.5')->where('vigencia', $anio)->get();
        $pac->componentes()->attach($ca_6);
        $pac = Pauta::where('nombre', '1.6')->where('vigencia', $anio)->get();
        $pac->componentes()->attach($ca_6);

        //Pautas 4
        $pac = Pauta::where('nombre', '4.1')->where('vigencia', $anio)->get();
        $pac->componentes()->attach($ca_6);
        $pac = Pauta::where('nombre', '4.2')->where('vigencia', $anio)->get();
        $pac->componentes()->attach($ca_6);

       
        //Pautas 5
        $pac = Pauta::where('nombre', '5.1')->where('vigencia', $anio)->get();
        $pac->componentes()->attach($ca_6);

        //Pautas 7
        $pac = Pauta::where('nombre', '7.1')->where('vigencia', $anio)->get();
        $pac->componentes()->attach($ca_6);

    }
}
