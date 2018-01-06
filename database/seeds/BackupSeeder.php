<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Finder\Finder;

class BackupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	//Para levantar el backup      
	$this->restore(); 
    }

    public function restore()
    {
        $files = (new Finder())->files()->in(database_path('/backups'));
	foreach ($files as $file) {
	    $sql = $file->getRealPath();
	    system("psql -U daniel atyc_testing -f {$sql}");     
	}
    }
}
