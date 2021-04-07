<?php

use Illuminate\Database\Seeder;
use App\Models\Pac\Pac;
use Illuminate\Support\Facades\DB;

class OneTimePautasManyToOnePac extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pacs = Pac::whereHas('pautas')->get();

        foreach ($pacs as $pac) {
            DB::beginTransaction();

            try {
                $pac->id_pauta = $pac->pautas()->first()->id_pauta;
                $pac->save();

                DB::commit();
                Log::debug("Actualiza $pac->id_pac Pauta $pac->id_pauta");
            } catch (Exception $e) {
                DB::rollBack();
                Log::warning("Error Pauta pac migracion\n" . $e->getMessage());
                continue;
            }
        }
    }
}
