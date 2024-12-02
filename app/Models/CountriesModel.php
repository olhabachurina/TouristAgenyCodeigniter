<?php

namespace App\Models;

use CodeIgniter\Model;

class CountriesModel extends Model
{
    protected $table = 'countries';
    protected $primaryKey = 'id';
    protected $allowedFields = ['country'];
}
