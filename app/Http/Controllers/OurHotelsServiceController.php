<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Traits\JsonResponseTrait;
use App\SearchProviders\SearchProvider;
use App\NotificationService\PusherService;
use App\SearchProviders\TopHotels\TopHotelFactory;
use App\SearchProviders\BestHotels\BestHotelFactory;

class OurHotelsServiceController extends Controller
{
    use JsonResponseTrait;

    /**
	 * Search for hotels in many providers
	 *
	 * @return \Illuminate\Http\Response;
	 */
    public function search(Request $request)
    {

        $request->validate([
            'from_date'  =>  'required|date_format:Y-m-d',
            'to_date'  =>  'required|date_format:Y-m-d',
            'city'  =>  'required|string',
            'adults_number' =>  'required|numeric|min:0|max:5'
        ]);

        // Get Request Date
        $data = $request->only(['from_date', 'to_date', 'city', 'adults_number']);


        /**
         * I Used Abstarct Factory Pattern to Allow use Multi Provider
         */

        // Call Best Hotels Provider
        $provider = new SearchProvider(new BestHotelFactory($data));
        $bestHotels = $provider->search();

        // Call Top Hotels Provider
        $provider->setFactory(new TopHotelFactory(($data)));
        $topHotels = $provider->search();

        /**
         * ---------------------------------------------
         * Here we can Use another Provider using [setFactory]
         */

        // Order Hotels By Rate
        $responseOrderedData = $this->orderHotelsByRate($bestHotels, $topHotels);

        // Finally Format Data
        $formatter = new Formatter($responseOrderedData);
        $responseData = $formatter->formatResponse('json');

        // Return Data with JSON
        return $this->jsonResponse(200, 'Data Retrned Successfully', null, $responseData);
    }


    /**
     * Save New Hotel
     *
     * @return \Illuminate\Http\Response;
     */
    public function store(Request $request)
    {
        // Get Request Date
        $data = $request->only(['hotelName', 'fare', 'city', 'amenities']);

        $request->validate([
            'hotelName'  =>  'required',
            'fare'  =>  'required|numeric',
            'city'  =>  'required|string',
            'amenities' =>  'required|array'
        ]);

        // Save the Hotel in DB or whatever

        // Send Notification
        $pusher = new PusherService([
            'PUSHER_APP_ID' =>  'sdksldksldkd',
            'PUSHER_APP_KEY' => 'ieouwoiwueoiwueo',
            'PUSHER_APP_SECRET' =>  '893479827384723',
            'PUSHER_APP_CLUSTER' => 'mt1'
        ]);
        $pusher->send($data);

        // Return Data with JSON
        return $this->jsonResponse(201, 'Data Retrned Successfully', null, $data);
    }

    /**
     * Order Hotels
     *
     * @param array $hotels
     * @return array $hotels
     */
    private function orderHotelsByRate(array $bestHotels, array $topHotels, $flag = SORT_DESC) : array
    {
        // Megre Date from Providers
        $hotels = [$bestHotels, $topHotels];

        $rate = array();
        // Get Rate for each Hotel
        foreach ($hotels as $key => $value) {
            $rate[$key] = $value['rate'];
        }

        // Sort Hotels with rate
        array_multisort($rate, $flag, $hotels);

        return $hotels;
    }


}
