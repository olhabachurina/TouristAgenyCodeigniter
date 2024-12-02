<?php

namespace App\Models;

use CodeIgniter\Model;

class HotelsModel extends Model
{
    protected $table = 'hotels'; // Таблица базы данных
    protected $primaryKey = 'id'; // Первичный ключ
    protected $allowedFields = ['hotel', 'countryid', 'cityid', 'cost', 'stars', 'info'];
    public function getHotelsWithCities()
    {
        return $this->select('hotels.id, hotels.hotel, cities.city, countries.country, hotels.stars, hotels.cost')
            ->join('cities', 'hotels.cityid = cities.id')
            ->join('countries', 'cities.countryid = countries.id')
            ->findAll();
    }

}
