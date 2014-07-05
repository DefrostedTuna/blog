<?php 

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(

				'email' 		=> 'RBennett1106@gmail.com',
				'username' 		=> 'Defrosted Tuna',
				'password' 		=> Hash::make('Mayauru5'),
				'first_name' 	=> 'Rick',
				'last_name' 	=> 'Bennett',
		));
    }

}