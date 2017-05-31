<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Trip;
use App\Models\Order;
use Jenssegers\Date\Date;
use App\Models\Recipient;
use App\Models\Shipment;
use App\Models\ShipmentCategory;
use App\Models\Route;

class OrdersSeeder extends Seeder
{
	const DATE_FORMAT = 'Y-m_d H:i:s';

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		$trips = Trip::all();
		$customers = User::all()->filter(function ($item) {
			if ($item->roles()->first()->name == User::ROLE_CUSTOMER) {
				return $item;
			}
		});

		$customers->each(function ($u) use ($trips) {

			$trip = $trips->random();
			$recipient = factory(Recipient::class)->create();
			$shipment = factory(Shipment::class)->create([
				'category_id' => ShipmentCategory::all()->random()->id
			]);
			$route = factory(Route::class)->create();
			$customer = $u->customer()->first();

			$data = [
				'customer_id' => $customer->id,
				'trip_id' => $trip->id,
				'recipient_id' => $recipient->id,
				'shipment_id' => $shipment->id,
				'route_id' => $route->id,
				'payment_id' => null,
			];

			$order = factory(Order::class)->create($data);

			if (!is_null($order->validationErrors) && count($order->validationErrors)) {
				foreach ($order->validationErrors as $error) {
					foreach ($error->messages as $param => $message) {
						throw new \Exception($message);
					}
				}
			}


		});
	}
}
