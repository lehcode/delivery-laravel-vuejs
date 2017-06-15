<?php
/**
 * Created by Antony Repin
 * Date: 05.06.2017
 * Time: 16:57
 */

namespace App\Http\Controllers;


use App\Services\Responder\ResponderService;
use App\Services\Shipment\ShipmentService;
use Illuminate\Http\Request;

/**
 * Class ShipmentController
 * @package App\Http\Controllers
 */
class ShipmentController extends Controller
{
	/**
	 * @var ShipmentService
	 */
	protected $shipmentService;

	/**
	 * ShipmentController constructor.
	 *
	 * @param ShipmentService  $shipmentService
	 * @param ResponderService $responderService
	 */
	public function __construct(
		ShipmentService $shipmentService,
		ResponderService $responderService
) {
	
		$this->shipmentService = $shipmentService;
		$this->responderService = $responderService;
	}

	/**
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function categories()
	{
		return $this->responderService->response($this->shipmentService->getCategories());
	}

	/**
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function createShipment(Request $request)
	{
		$data = $request->except('XDEBUG_SESSION_START');
		return $this->responderService->response($this->shipmentService->create($data));
	}
}
