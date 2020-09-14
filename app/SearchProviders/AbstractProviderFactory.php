<?php
namespace App\SearchProviders;

interface AbstractProviderFactory
{
    /**
     * Filter given Request Data
     *
     *
     * @return void $data
     */
    public function filterRequestData() : void;

    /**
     * Call Provider API
     *
     * @return void $response
     */
    public function callProviderApi();

    /**
     * Structure Dummy Data
     *
     * @return array
     */
    public function dummyData() : array;


    /**
     * Get Response after Format
     *
     * @return mixed $jsonData
     */
    public function getResponse();
}
