<?php

namespace App\DTO;

use InvalidArgumentException;

class WeatherDto
{
    /**
    * @var array<string, array<string, mixed>> $fields
     */
    private array $fields = [
        'location.name' => [
            'type' => 'string',
            'default' => '',
            'required' => true,
        ],
        'location.country' => [
            'type' => 'string',
            'default' => '',
            'required' => true,
        ],
        'location.localtime' => [
            'type' => 'string',
            'default' => '',
            'required' => true,
        ],
        'location.localtime_epoch' => [
            'type' => 'integer',
            'default' => '',
            'required' => true,
        ],
        'current.temperature' => [
            'type' => 'integer',
            'default' => 0,
            'required' => true,
        ],
        'current.weather_icons' => [
            'type' => 'array',
            'default' => [],
            'required' => true,
        ],
        'current.weather_descriptions' => [
            'type' => 'array',
            'default' => [],
            'required' => true,
        ],
        'current.wind_speed' => [
            'type' => 'integer',
            'default' => 0,
            'required' => true,
        ],
        'current.wind_dir' => [
            'type' => 'string',
            'default' => '',
            'required' => true,
        ],
        'current.humidity' => [
            'type' => 'integer',
            'default' => 0,
            'required' => true,
        ],
    ];

    private bool $softmode = true;

    /**
     * @var array<string, mixed>
     */
    private array $data = [];
    
    public function __construct()
    {
        //
    }

    public function fromJson(string $json) : self|false
    {
        try {
            $array = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            $array = [];
        }
        return $this->fromArray($array);
    }

    /**
     * @param array<string, mixed> $array
     * 
     * @return WeatherDto
     * @throws InvalidArgumentException
     */
    public function fromArray(array $array) : self|false
    {
        try {
            $this->validate($array);
        } catch (\InvalidArgumentException $e) {
            if(env('APP_DEBUG') === true) {
                throw new \InvalidArgumentException ($e->getMessage());
            } else {
                return false;
            }
        }

        return $this;
    }
    
    /**
     * @param array<string, mixed> $array
     */
    private function validate(array $array): void
    {
        foreach ($this->fields as $field => $info) {
            $fieldParts = explode('.', $field);

            $value = $array;
    
            foreach ($fieldParts as $part) {
                if (is_array($value) && array_key_exists($part, $value)) {
                    $value = $value[$part];
                } else {
                    $value = null;
            
                    break;
                }
            }
    
            if ($value === null) {
                if ($this->softmode) {
                    $this->data[$field] = $info['default'];
                } else {
                    throw new \InvalidArgumentException("Field $field is required.");
                }
            } elseif (gettype($value) !== $info['type']) {
                if ($this->softmode) {
                    $this->data[$field] = $info['default'];
                } else {
                    throw new \InvalidArgumentException("Field $field is not of type {$info['type']}.");
                }
            } else {
                $this->data[$field] = $value;
            }
        }

        $this->data = $this->arrayDotToNested($this->data);
    }

    public function __get(string $name) : mixed
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        } else {
            return null;
            // throw new \InvalidArgumentException("Field $name does not exist.");
        }
    }

    public function get(string $name) : mixed
    {
        $keys = explode('.', $name);

        $data = $this->data;

        foreach ($keys as $key) {
            if (is_array($data) && array_key_exists($key, $data)) {
                $data = $data[$key];
            } else {
                return null;
            }
        }

        return $data;
    }

    public function getLocationNameCountry() : string
    {
        return sprintf('%s, %s', $this->get('location.name'), $this->get('location.country'));
    }

    /**
     * function: toArray
     * 
     * @return array<string, mixed>
     */
    public function toArray() : array
    {
        return $this->data;
    }

    /**
     * 
     * 
     * function: arrayDotToNested
     * 
     * @param array<mixed> $array
     * 
     * @return array<mixed>
     */
    private function arrayDotToNested(array $array) : array
    {
        $result = [];
        
        foreach ($array as $key => $value) {
            $this->arraySet($result, $key, $value);
        }

        return $result;
    }
    
    /**
     * function: arraySet
     * 
     * @param array<mixed> $array
     * @param mixed $key
     * @param mixed $value
     * 
     * @return array<string, mixed>
     */
    private function arraySet(&$array, $key, $value) : array
    {
        if (is_null($key)) {
            return $array = $value;
        }
    
        $keys = explode('.', $key);
    
        while (count($keys) > 1) {
            $key = array_shift($keys);
    
            if (!isset($array[$key]) || !is_array($array[$key])) {
                $array[$key] = [];
            }
    
            $array = &$array[$key];
        }
    
        $array[array_shift($keys)] = $value;
    
        return $array;
    }
}
