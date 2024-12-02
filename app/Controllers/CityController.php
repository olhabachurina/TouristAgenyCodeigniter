<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CityController extends BaseController
{
    public function getCities()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(405)->setJSON(['error' => 'Method not allowed']);
        }

        $countryId = $this->request->getPost('country_id');
        if (empty($countryId) || !is_numeric($countryId)) {
            return $this->response->setJSON(['error' => 'Invalid country ID']);
        }

        $db = \Config\Database::connect();
        $builder = $db->table('cities');
        $builder->select('id, city');
        $builder->where('countryid', $countryId);
        $query = $builder->get();

        $cities = $query->getResultArray();

        if (empty($cities)) {
            return $this->response->setJSON(['message' => 'No cities found']);
        }

        return $this->response->setJSON($cities);
    }
}