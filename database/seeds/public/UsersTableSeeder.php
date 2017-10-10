<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();

        \DB::statement("INSERT INTO public.users(title,name,id_provincia,email,password,created_at,updated_at) values
            ('CABA','caba',1,'caba@caba.com','".bcrypt('caba001')."',now(),now()),
            ('Buenos Aires','buenosaires',2,'buenosaires@buenosaires.com','".bcrypt('buenosaires001')."',now(),now()),
            ('Catamarca','catamarca',3,'catamarca@catamarca.com','".bcrypt('catamarca001')."',now(),now()),
            ('Cordoba','cordoba',4,'cordoba@cordoba.com','".bcrypt('cordoba001')."',now(),now()),
            ('Corrientes','corrientes',5,'corrientes@corrientes.com','".bcrypt('corrientes001')."',now(),now()),
            ('Entre Ríos','entrerios',6,'entrerios@entrerios.com','".bcrypt('entrerios001')."',now(),now()),
            ('Jujuy','jujuy',7,'jujuy@jujuy.com','".bcrypt('jujuy001')."',now(),now()),
            ('La Rioja','larioja',8,'larioja@larioja.com','".bcrypt('larioja001')."',now(),now()),
            ('Mendoza','mendoza',9,'mendoza@mendoza.com','".bcrypt('mendoza001')."',now(),now()),
            ('Salta','salta',10,'salta@salta.com','".bcrypt('salta001')."',now(),now()),
            ('San Juan','sanjuan',11,'sanjuan@sanjuan.com','".bcrypt('sanjuan001')."',now(),now()),
            ('San Luis','sanluis',12,'sanluis@sanluis.com','".bcrypt('sanluis001')."',now(),now()),
            ('Santa Fe','santafe',13,'santafe@santafe.com','".bcrypt('santafe001')."',now(),now()),
            ('Santiago del Estero','santiagodelestero',14,'santiagodelestero@santiagodelestero.com','".
            bcrypt('santiagodelestero001')."',now(),now()),
            ('Tucumán','tucuman',15,'tucuman@tucuman.com','".bcrypt('tucuman001')."',now(),now()),
            ('Chaco','chaco',16,'chaco@chaco.com','".bcrypt('chaco001')."',now(),now()),
            ('Chubut','chubut',17,'chubut@chubut.com','".bcrypt('chubut001')."',now(),now()),
            ('Formosa','formosa',18,'formosa@formosa.com','".bcrypt('formosa001')."',now(),now()),
            ('La Pampa','lapampa',19,'lapampa@lapampa.com','".bcrypt('lapampa001')."',now(),now()),
            ('Misiones','misiones',20,'misiones@misiones.com','".bcrypt('misiones001')."',now(),now()),
            ('Neuquen','neuquen',21,'neuquen@neuquen.com','".bcrypt('neuquen001')."',now(),now()),
            ('Río Negro','rionegro',22,'rionegro@rionegro.com','".bcrypt('rionegro001')."',now(),now()),
            ('Santa Cruz','santacruz',23,'santacruz@santacruz.com','".bcrypt('santacruz001')."',now(),now()),
            ('Tierra del Fuego','tierradelfuego',24,'tierradelfuego@tierradelfuego.com','".bcrypt('tierradelfuego001').
            "',now(),now()),
            ('UEC','uec',25,'uec@uec.com','".bcrypt('uec001')."',now(),now()),
            ('Paola','paola',25,'paola@paola.com','".bcrypt('paola007')."',now(),now())");
    }
}
