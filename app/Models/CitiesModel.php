<?php

namespace App\Models;

use CodeIgniter\Model;

class CitiesModel extends Model
{
    protected $table = 'cities';
    protected $primaryKey = 'id';
    protected $allowedFields = ['city', 'countryid'];

    // Получение городов с привязкой к стране
    // public function getCitiesByCountry($countryId)
    // {
    //    return $this->where('countryid', $countryId)->findAll();
    // }
    public function getCitiesWithCountries()
    {
        return $this->select('cities.id, cities.city, countries.country')
            ->join('countries', 'cities.countryid = countries.id')
            ->findAll();
    }
}
