<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('AddressTableSeeder');
	}

}

class AddressTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('addresses')->delete();
        Address::create(array('email' => 'pirmaspastas@domenas.lt'));
        Address::create(array('email' => 'antraspastas@domenas.lt'));
    }

}
