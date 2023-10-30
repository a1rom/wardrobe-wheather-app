<?php

namespace App\DTO;

use InvalidArgumentException;

/**
 * @property string $location_name
 * @property string $location_country
 * @property string $location_time
 * @property int $current_temperature
 * @property array $current_weather_icons
 * @property array $current_weather_descriptions
 * @property int $current_wind_speed
 */

class WeatherDto
{
    /**
    * @var array<string, array<string, mixed>> $fields
     */
    private array $fields = [
        'location_name' => [
            'type' => 'string',
            'default' => '',
            'required' => true,
        ],
        'location_country' => [
            'type' => 'string',
            'default' => '',
            'required' => true,
        ],
        'location_time' => [
            'type' => 'string',
            'default' => '',
            'required' => true,
        ],
        'current_temperature' => [
            'type' => 'integer',
            'default' => 0,
            'required' => true,
        ],
        'current_weather_icons' => [
            'type' => 'array',
            'default' => [],
            'required' => true,
        ],
        'current_weather_descriptions' => [
            'type' => 'array',
            'default' => [],
            'required' => true,
        ],
        'current_wind_speed' => [
            'type' => 'integer',
            'default' => 0,
            'required' => true,
        ],
    ];

    private bool $softmode = true;

    /**
     * @var array<string, string|integer|bool>
     */
    private array $data = [];
    
    public function __construct()
    {
        //
    }

    public function fromJson(string $json) : self
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
    public function fromArray(array $array) : self
    {
        $this->validate($array);
        return $this;
    }
    
    /**
     * @param array<string, mixed> $array
     */
    private function validate(array $array): void
    {
        foreach ($this->fields as $field => $info) {
            $fieldParts = explode('_', $field);
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
}
