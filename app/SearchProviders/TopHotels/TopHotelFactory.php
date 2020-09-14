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
        $this->response = $this->dummyData();
    }

    /**
     * Structure Dummy Data
     *
     * @return array
     */
    public function dummyData(): array
    {
        return [
            'hotelName' =>  "Top Hotel Name",
            'rate'      =>  4,
            'price'      =>  200.3,
            'discount'      =>  0,
            'amenities' =>  ["gym", "cafe"],
        ];
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
            'discount'      =>  $this->response['discount'],
            'amenities' =>  $this->response['amenities'],
        ];

        return $response;
    }
}
