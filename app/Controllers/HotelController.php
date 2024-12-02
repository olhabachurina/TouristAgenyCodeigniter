<?php

namespace App\Controllers;

use App\Models\HotelsModel;
use App\Models\CommentsModel;
use App\Models\ImageModel;
class HotelController extends BaseController
{
    public function details($id)
    {
        $hotelModel = new HotelsModel();
        $commentModel = new CommentsModel();
        $imageModel = new ImageModel();

        $hotel = $hotelModel->find($id);
        if (!$hotel) {
            return redirect()->to('/')->with('error', 'Hotel not found.');
        }

        $comments = $commentModel->where('hotel_id', $id)->findAll();
        $images = $imageModel->where('hotelid', $id)->findAll();

        return view('hotel/details', [
            'hotel' => $hotel,
            'comments' => $comments,
            'images' => $images,
        ]);
    }
}