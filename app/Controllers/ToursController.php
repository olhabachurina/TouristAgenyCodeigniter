<?php

namespace App\Controllers;

use App\Models\CountriesModel;
use App\Models\CitiesModel;
use App\Models\HotelsModel;

class ToursController extends BaseController
{
    public function index()
    {
        // Инициализируем модели
        $countriesModel = new CountriesModel();
        $citiesModel = new CitiesModel();
        $hotelsModel = new HotelsModel();

        // Получаем список стран
        $countries = $countriesModel->orderBy('country', 'ASC')->findAll();

        // Получаем выбранную страну из GET-запроса (если есть)
        $selectedCountryId = $this->request->getGet('country') ?? null;

        // Получаем список городов, если страна выбрана
        $cities = [];
        if ($selectedCountryId) {
            $cities = $citiesModel->where('countryid', $selectedCountryId)->orderBy('city', 'ASC')->findAll();
        }

        // Получаем выбранный город из GET-запроса (если есть)
        $selectedCityId = $this->request->getGet('city') ?? null;

        // Получаем список отелей, если город выбран
        $hotels = [];
        if ($selectedCityId) {
            $hotels = $hotelsModel
                ->select('hotels.id, hotels.hotel, countries.country, cities.city, hotels.cost, hotels.stars')
                ->join('countries', 'countries.id = hotels.countryid')
                ->join('cities', 'cities.id = hotels.cityid')
                ->where('hotels.cityid', $selectedCityId)
                ->orderBy('hotels.hotel', 'ASC')
                ->findAll();
        }

        // Передаем данные во вью
        return view('tours/index', [
            'countries' => $countries,
            'selectedCountryId' => $selectedCountryId,
            'cities' => $cities,
            'selectedCityId' => $selectedCityId,
            'hotels' => $hotels,
        ]);
    }
}