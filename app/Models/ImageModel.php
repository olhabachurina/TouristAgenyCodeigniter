<?php

namespace App\Models;

use CodeIgniter\Model;

class ImageModel extends Model
{
    protected $table = 'images';
    protected $primaryKey = 'id';
    protected $allowedFields = ['hotelid', 'imagepath'];

    /**
     * Получение изображений с привязкой к отелям
     *
     * @return array Данные изображений с отелями
     */
    public function getImagesWithHotels()
    {
        return $this->select('images.id, images.imagepath, hotels.hotel')
            ->join('hotels', 'images.hotelid = hotels.id')
            ->findAll();
    }
}