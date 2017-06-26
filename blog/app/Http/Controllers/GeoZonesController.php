<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Zone;
use App\Models\GeoZone;

use App\Http\Requests;
use DB;

class GeoZonesController extends Controller
{
    protected $data = null;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');

		$this->data = new \stdClass();
		$this->country = new Country();
		$this->zone = new Zone();
		$this->geo_zone = new GeoZone();
		$this->data->web_title = 'Geo-Zones';
	}

	public function getZone($country_id, $zone_id) {
		$this->data->country_zones = $this->zone->getZonesByContry($country_id);
		$this->data->zone_id = $zone_id;
		return view('geo_zone.zone_form', ['data' => $this->data]);
	}
}
