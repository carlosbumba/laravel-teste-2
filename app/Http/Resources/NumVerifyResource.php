<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NumVerifyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'valid' => $this['valid'],
            'number' => $this['number'],
            'local_format' => $this['local_format'],
            'international_format' => $this['international_format'],
            'country_prefix' => $this['country_prefix'],
            'country_code' => $this['country_code'],
            'country_name' => $this['country_name'],
            'location' => $this['location'],
            'carrier' => $this['carrier'],
            'line_type' => $this['line_type'],
        ];
    }
}
