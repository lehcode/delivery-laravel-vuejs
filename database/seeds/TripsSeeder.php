<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Trip;
use Faker\Factory as Faker;
use Webpatser\Uuid\Uuid;

class TripsSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker::create('en_GB');

		$customers = User::all()->filter(function ($item) {
			if ($item->roles()->first()->name == User::ROLE_CARRIER) {
				return $item;
			}
		});

		$customers->each(function ($u) use ($faker) {

			$user = $u->carrier()->first();

			for ($i = 0; $i < rand(3, 9); $i++) {
				$user->trips()
					->save(factory(Trip::class)->make([
						'id' => Uuid::generate(4),
						'carrier_id' => $u->id,
						'time_length' => $faker->randomElement([3600, 5400, 7200, 9000, 10800, 14400, 28800])
					]));
			}

		});
	}
}
