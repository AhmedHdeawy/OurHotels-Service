<?php
namespace App\SearchProviders;

class SearchProvider
{

    private AbstractProviderFactory $factory;
    private array $data;

    /**
     * Search Provider Constuctor that Take Provider
     * @param AbstractProviderFactory $factory
     *
     * @return void
     */
    public function __construct(AbstractProviderFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * When we want to Use another Provider
     * @param AbstractProviderFactory $factory
     *
     * @return void
     */
    public function setFactory(AbstractProviderFactory $factory) : void
    {
        $this->factory = $factory;
    }

    /**
     * Base Function to run Search in Used Provider
     *
     * @param array $data
     * @param string $responseType
     *
     * @return mixed $data
     *
     */
    public function search()
    {
        // First, Filter Request Data
        $this->factory->filterRequestData();

        // Call Provider API
        $this->factory->callProviderApi();


        // Return Response
        return $this->factory->getResponse();
    }


}
