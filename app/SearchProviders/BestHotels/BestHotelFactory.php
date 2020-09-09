<?php
namespace App\SearchProviders\BestHotels;

use App\SearchProviders\AbstractProviderFactory;

class BestHotelFactory implements AbstractProviderFactory
{
    private array $data;
    private string $provider = 'BestHotels';
    private array $response;

    public function __construct(array $data)
    {
        $this->data = $data;
    }


	/**
	 * Filter given Request Data
	 *
	 * @return void
	 */
    public function filterRequestData(): void
    {
        //  Filter Given Data From Request
	}

	/**
	 * Call Provider API
	 *
	 *
	 * @return void $response
	 */
	public function callProviderApi() {

        // Call BestHotel API with these data
        $url = "http://www.bestHotel.com?fromDate={$this->data['from_date']}&toDate={$this->data['to_date']}&city={$this->data['city']}&numberOfAdults={$this->data['adults_number']}";

        // Get Response from API
        $this->response = $url;
    }

    /**
     * Get Response after Format
     *
     * @return mixed $jsonData
     */
    public function getResponse()
    {
        $response = [
            'provider'  =>  $this->provider,
            'hotelName' =>  $this->response['hotel'],
            'rate'      =>  $this->response['hotelRate'],
            'fare'      =>  $this->response['hotelFare'],
            'amenities' =>  $this->response['roomAmenities'],
        ];

        return $response;
    }
}
