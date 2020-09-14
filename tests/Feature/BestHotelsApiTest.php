<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\SearchProviders\SearchProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\SearchProviders\BestHotels\BestHotelFactory;

class BestHotelsApiTest extends TestCase
{
    private array $data = [
        "from_date" => "2020-09-15",
        "to_date" => "2020-09-17",
        "city" => "Abu Dhabi",
        "adults_number" => 2,
    ];

    /**
     * Test that Best Hotels API Fetch Data Successfully
     *
     * @return void
     */
    public function test_fetched_data_from_best_hotels_api_has_provider()
    {
        // Call Best Hotels Provider
        $provider = new SearchProvider(new BestHotelFactory($this->data));
        $bestHotels = $provider->search();

        $this->assertArrayHasKey('provider', $bestHotels);
    }

    /**
     * Test that Best Hotels API Fetch Data Successfully
     *
     * @return void
     */
    public function test_fetched_data_from_best_hotels_api_has_hotel_name()
    {
        // Call Best Hotels Provider
        $provider = new SearchProvider(new BestHotelFactory($this->data));
        $bestHotels = $provider->search();

        $this->assertArrayHasKey('hotelName', $bestHotels);
    }

    /**
     * Test that Best Hotels API Fetch Data Successfully
     *
     * @return void
     */
    public function test_fetched_data_from_best_hotels_api_has_rate()
    {
        // Call Best Hotels Provider
        $provider = new SearchProvider(new BestHotelFactory($this->data));
        $bestHotels = $provider->search();

        $this->assertArrayHasKey('rate', $bestHotels);
    }

    /**
     * Test that Best Hotels API Fetch Data Successfully
     *
     * @return void
     */
    public function test_fetched_data_from_best_hotels_api_has_fare()
    {
        // Call Best Hotels Provider
        $provider = new SearchProvider(new BestHotelFactory($this->data));
        $bestHotels = $provider->search();

        $this->assertArrayHasKey('fare', $bestHotels);
    }

    /**
     * Test that Best Hotels API Fetch Data Successfully
     *
     * @return void
     */
    public function test_fetched_data_from_best_hotels_api_has_amenities()
    {
        // Call Best Hotels Provider
        $provider = new SearchProvider(new BestHotelFactory($this->data));
        $bestHotels = $provider->search();

        $this->assertArrayHasKey('amenities', $bestHotels);
    }
}
