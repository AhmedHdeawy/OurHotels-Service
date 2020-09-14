<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\NotificationService\PusherService;
use App\Http\Controllers\OurHotelsServiceController;

class OurHotelsServiceTest extends TestCase
{

    private array $data = [
        "from_date" => "2020-09-15",
        "to_date" => "2020-09-17",
        "city" => "Abu Dhabi",
        "adults_number" => 2,
    ];

    /**
     * Test Request parameters
     *
     * @return void
     */
    public function test_required_fields_for_search()
    {
        $this->json('GET', 'api/hotels/search', ['Accept' => 'application/json'])
        ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "from_date" => ["The from date field is required."],
                    "to_date" => ["The to date field is required."],
                    "city" => ["The city field is required."],
                    "adults_number" => ["The adults number field is required."],
                ]
            ]);
    }

    /**
     * Test Search Process Passed Suuccessfully
     *
     * @return void
     */
    public function test_successful_search()
    {

        // Note: Each API Was tested in Sperated Test File before full process here, look at them

        $this->json('GET', 'api/hotels/search', $this->data, ['Accept' => 'application/json'])
            ->assertJsonStructure([
                "status",
                "message",
                "errors",
                "data"
            ]);
    }

    /**
     * Test Data was returned in order by rate
     *
     * @return void
     */
    public function test_data_ordered_by_hotel_rate()
    {
        $hotel_one = [ 'rate'  =>  2];
        $hotel_two = [ 'rate'  =>  4];

        // So that Sort Function is Private function in controller, we use Reflection to call function
        $ourHotelsService = new OurHotelsServiceController();
        $reflection = new \ReflectionClass(get_class($ourHotelsService));
        $method = $reflection->getMethod('orderHotelsByRate');
        $method->setAccessible(true);

        // Call Function and Pass arguments
        $response = $method->invokeArgs($ourHotelsService, [$hotel_one, $hotel_two]);

        // Expected, hotel that has [ rate = 4 ] will be the first elementin array
        $topHotelsRate = $response[0]['rate'];

        $this->assertEquals(4, $topHotelsRate);
    }



    /**
     * Test Hotel Has Correct Data to create
     *
     * @return void
     */
    public function test_a_new_hotel_has_correct_data()
    {
        $newHotel = [];

        $this->json('POST', 'api/hotels/create', $newHotel, ['Accept' => 'application/json'])
        ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "hotelName" => ["The hotel name field is required."],
                    "fare" => ["The fare field is required."],
                    "city" => ["The city field is required."],
                    "amenities" => ["The amenities field is required."],
                ]
            ]);
    }


    /**
     * Test Hotel Created Successfully
     *
     * @return void
     */
    public function test_a_new_hotel_created()
    {
        $newHotel = [
            'hotelName' =>  'Main Hotel',
            'fare'  =>  125,
            'city'  =>  "Abu Dhabi",
            "amenities" =>  ['gym', 'cafe']
        ];

        $this->json('POST', 'api/hotels/create', $newHotel, ['Accept' => 'application/json'])
            ->assertJsonStructure([
                "status",
                "message",
                "errors",
                "data"  =>  [
                    "hotelName",
                    "fare",
                    "city",
                    "amenities"
                ]
            ]);
    }


    /**
     * Test Notification Was Sent after Hotel Created
     *
     * @return void
     */
    public function test_a_notification_sent()
    {
        $newHotel = [
            'hotelName' =>  'Main Hotel',
            'fare'  =>  125,
            'city'  =>  "Abu Dhabi",
            "amenities" =>  ['gym', 'cafe']
        ];

        // Send Notification
        $pusher = new PusherService([
            'PUSHER_APP_ID' =>  'sdksldksldkd',
            'PUSHER_APP_KEY' => 'ieouwoiwueoiwueo',
            'PUSHER_APP_SECRET' =>  '893479827384723',
            'PUSHER_APP_CLUSTER' => 'mt1'
        ]);
        $response = $pusher->send($newHotel);


        $this->assertStringContainsString("Notification Sent", $response);

    }
}
