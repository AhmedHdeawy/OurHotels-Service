<?php

namespace App\Http\Controllers;

use App\Http\Traits\JsonResponseTrait;
use App\NotificationService\PusherService;
use App\SearchProviders\BestHotels\BestHotelFactory;
use App\SearchProviders\SearchProvider;
use App\SearchProviders\TopHotels\TopHotelFactory;
use Illuminate\Http\Request;

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


        // Order Hotels By Rate
        $responseOrderedData = $this->orderHotelsByRate($bestHotels, $topHotels);

        // Finally Format Data
        $formatter = new Formatter($responseOrderedData);
        $responseData = $formatter->formatResponse('json');

        // Return Data with JSON
        $this->jsonResponse(200, 'Data Retrned Successfully', null, $responseData);
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
        $this->jsonResponse(200, 'Data Retrned Successfully', null, $data);
    }

    /**
     * Order Hotels
     *
     * @param array $hotels
     * @return array $hotels
     */
    private function orderHotelsByRate(array $bestHotels, array $topHotels) : array
    {
        // Megre Date from Providers
        $hotels = array_merge($bestHotels, $topHotels);

        $rate = [];
        // Get Rate for each Hotel
        foreach ($hotels as $key => $value) {
            $rate[$key] = $value['rate'];
        }

        // Sort Hotels with rate
        array_multisort($rate, 'SORT_ASC', $hotels);

        return $hotels;
    }


}
