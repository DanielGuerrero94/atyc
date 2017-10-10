<?php

use Illuminate\Database\Seeder;

class ProvinciasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insert();

        $this->alterSequence();
    }

    /**
     * Migro los datos desde la otra tabla.
     *
     * @return void
     */
    public function insert()
    {
        \DB::statement("INSERT INTO sistema.provincias(id_provincia,nombre) 
            (SELECT sub.id,sub.descripcion FROM dblink('dbname=elearning port=5432 
            host=192.6.0.66 user=postgres password=BernardoCafe008',
            'SELECT id,descripcion FROM g_plannacer.provincias')
            AS sub(id integer,
            descripcion character varying(100)))");
    }

    /**
     * Busco el ultimo id de la tabla migrada para setear start en la sequence de la nueva tabla.
     *
     * @return void
     */
    public function alterSequence()
    {
        $max_id = \DB::connection('g_plannacer')->select("SELECT max(id) FROM g_plannacer.provincias");
        $max_id = $max_id[0]->max;
        $max_id++;

        \DB::statement("ALTER SEQUENCE sistema.provincias_id_provincia_seq START ".strval($max_id));
        \DB::statement("ALTER SEQUENCE sistema.provincias_id_provincia_seq RESTART");
    }
}
