<?php
namespace App\SearchProviders\TopHotels;

use App\SearchProviders\AbstractProviderFactory;

class TopHotelFactory implements AbstractProviderFactory
{
    private array $data;
    private string $provider = 'TopHotels';
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
        $url = "http://www.topHotel.com?from={$this->data['from_date']}&to={$this->data['to_date']}&city={$this->data['city']}&adultsCount={$this->data['adults_number']}";

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
            'hotelName' =>  $this->response['hotelName'],
            'rate'      =>  $this->response['rate'],
            'fare'      =>  $this->response['price'],
            'amenities' =>  $this->response['amenities'],
        ];

        return $response;
    }
}
