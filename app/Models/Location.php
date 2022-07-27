<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Location extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'pincode',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
    ];

    public static function fetch($pincode)
    {
        if (empty($pincode))
            return null;
        $location = self::query()->where('pincode', $pincode)->first();
        if ($location)
            return $location;
        $url = "https://thezipcodes.com/api/v1/search?zipCode=$pincode&countryCode=IN&apiKey=".config('app.zipcodes_api_key');
        $response = Http::get($url);
        if ($response->successful() && $response->json('success') && !empty($response->json('location'))) {
            $data = $response->json('location')[0];
            if ($data && isset($data['latitude'])) {
                $location = self::query()->create([
                    'pincode' => $data['zipCode'],
                    'latitude' => $data['latitude'],
                    'longitude' => $data['longitude']
                ]);
            }
        }
        return $location;
    }
}
