<?php

use Illuminate\Database\Seeder;

class seed_usuarios_provincias extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	\DB::statement("INSERT INTO public.users(name,email,password,created_at,updated_at) values
    		('CABA','caba@caba.com','".bcrypt('caba001')."',now(),now()),
    		('Buenos Aires','buenosaires@buenosaires.com','".bcrypt('buenosaires001')."',now(),now()),
    		('Catamarca','catamarca@catamarca.com','".bcrypt('catamarca001')."',now(),now()),
    		('Cordoba','cordoba@cordoba.com','".bcrypt('cordoba001')."',now(),now()),
    		('Corrientes','corrientes@corrientes.com','".bcrypt('corrientes001')."',now(),now()),
    		('Entre Ríos','entrerios@entrerios.com','".bcrypt('entrerios001')."',now(),now()),
    		('Jujuy','jujuy@jujuy.com','".bcrypt('jujuy001')."',now(),now()),
    		('La Rioja','larioja@larioja.com','".bcrypt('larioja001')."',now(),now()),
    		('Mendoza','mendoza@mendoza.com','".bcrypt('mendoza001')."',now(),now()),
    		('Salta','salta@salta.com','".bcrypt('salta001')."',now(),now()),
    		('San Juan','sanjuan@sanjuan.com','".bcrypt('sanjuan001')."',now(),now()),
    		('San Luis','sanluis@sanluis.com','".bcrypt('sanluis001')."',now(),now()),
    		('Santa Fe','santafe@santafe.com','".bcrypt('santafe001')."',now(),now()),
    		('Santiago del Estero','santiagodelestero@santiagodelestero.com','".bcrypt('santiagodelestero001')."',now(),now()),
    		('Tucumán','tucuman@tucuman.com','".bcrypt('tucuman001')."',now(),now()),
    		('Chaco','chaco@chaco.com','".bcrypt('chaco001')."',now(),now()),
    		('Chubut','chubut@chubut.com','".bcrypt('chubut001')."',now(),now()),
    		('Formosa','formosa@formosa.com','".bcrypt('formosa001')."',now(),now()),
    		('La Pampa','lapampa@lapampa.com','".bcrypt('lapampa001')."',now(),now()),
    		('Misiones','misiones@misiones.com','".bcrypt('misiones001')."',now(),now()),
    		('Neuquen','neuquen@neuquen.com','".bcrypt('neuquen001')."',now(),now()),
    		('Río Negro','rionegro@rionegro.com','".bcrypt('rionegro001')."',now(),now()),
    		('Santa Cruz','santacruz@santacruz.com','".bcrypt('santacruz001')."',now(),now()),
    		('Tierra del Fuego','tierradelfuego@tierradelfuego.com','".bcrypt('tierradelfuego001')."',now(),now()),
    		('UEC','uec@uec.com','".bcrypt('uec001')."',now(),now())");
    }
}
