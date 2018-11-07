<?php

namespace Carl\Weather;

use GuzzleHttp\Client;
use Carl\Weather\Exceptions\HttpException;
use Carl\Weather\Exceptions\InvalidArgumentException;

class Weather
{
    protected $key;
    protected $guzzleOptions = [];

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    public function setGuzzleOptions(array $options){
        $this->guzzleOptions = $options;
    }

    public function getWeather($city, string $type = 'base', string $format = 'json')
    {
        $url = 'https://restapi.amap.com/v3/weather/weatherInfo';

        if(!\in_array(\strtolower($format), ['xml', 'json'])){
            throw new InvalidArgumentException('Invalid response format: '.$format);
        }

        if(!\in_array(\strtolower($type), ['base', 'all'])){
            throw new InvalidArgumentException('Invalid type value(base/all): '.$type);
        }

        $query = array_filter([
            'key' => $this->key,
            'city' => $city,
            'output' => strtolower($format),
            'extensions' => strtolower($type),
        ]);

        try {
            $response = $this->getHttpClient()->get( $url, [
                'query' => $query,
            ] )->getBody()->getContents();

            return $response;
        } catch (\Exception $e){
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getLiveWeather($city, $format = 'json')
    {
        return $this->getWeather($city, 'base', $format);
    }

    public function getForecastsWeather($city, $format = 'json')
    {
        return $this->getWeather($city, 'all', $format);
    }
}