<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Trip;
use App\Models\Order;
use Jenssegers\Date\Date;
use App\Models\Recipient;
use App\Models\Shipment;
use App\Models\ShipmentCategory;

/**
 * Class OrdersSeeder
 */
class OrdersSeeder extends Seeder
{
	/**
	 * Default date format
	 */
	const DATE_FORMAT = 'Y-m_d H:i:s';

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		$trips = Trip::all();

		User\Customer::all()->each(function ($customer) use ($trips) {

			$trip = $trips->random();
			$recipient = factory(Recipient::class)->create();
			$shipment = factory(Shipment::class)->create([
				'category_id' => ShipmentCategory::all()->random()->id
			]);

			$data = [
				'customer_id' => $customer->id,
				'trip_id' => $trip->id,
				'recipient_id' => $recipient->id,
				'shipment_id' => $shipment->id,
				'payment_id' => null,
			];

			$order = factory(Order::class)->create($data);

			if (!is_null($order->validationErrors) && !empty($order->validationErrors)) {
				foreach ($order->validationErrors['messages'] as $messages) {
					foreach ($messages as $column => $errors) {
						foreach ($errors as $error) {
							throw new \Exception($column . ': ' . $error, 1);
						}
					}
				}
			}


		});
	}
}
