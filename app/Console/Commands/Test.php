<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $string = "2400300001110453,24,10/11/2016,11,2016\n2400300001110687,24,09/11/2016,11,2016\n2400300001110711,24,15/11/2016,11,2016\n  2400300001110729,24,09/11/2016,11,2016\n2400300001110744,24,15/03/2017,3,2017\n   2400300001110751,24,14/11/2016,11,2016\n2400300001112863,24,09/02/2017,2,2017\n   2400300001114162,24,07/04/2017,4,2017\n2400300001114164,24,07/04/2017,4,2017\n2400300001114371,24,12/04/2017,4,2017\n2400400001000345,24,20/08/2015,8,2015\n    2400400001000786,24,25/07/2016,7,2016\n2400400001000900,24,24/07/2015,7,2015\n2499999901002026,24,27/05/2015,5,2015\n";
        preg_match_all('/(^\d+)(?:,\d+,)([\d\/]+)(?:.+)/m', $string, $matches);
        $claves = $matches[1];
        $fecha_prestacion = $matches[2];
        var_dump();
    }
}
