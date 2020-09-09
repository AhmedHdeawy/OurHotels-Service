<?php
namespace App\Http\Controllers;

class Formatter
{
    private array $data;
    private $formatedData;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Format Reponse as JOSN
     *
     * @param string $type
     *
     * @return mixed $formatedData
     */
    public function formatResponse(string $type)
    {
        if ($this->type == 'json') {
            $this->formatedData = $this->formatResponseToJson();
        }

        return $this->formatedData;
    }

    /**
     * Format Reponse as JOSN
     *
     * @return string
     */
    public function formatResponseToJson(): string
    {
        // Convert Reponse to JSON
        return json_encode($this->data);
    }

}
