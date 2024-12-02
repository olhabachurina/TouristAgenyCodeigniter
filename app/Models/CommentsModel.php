<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentsModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['hotel_id', 'user', 'comment', 'created_at'];

    public function getCommentsWithHotelNames()
    {
        return $this->select('comments.id, comments.user, comments.comment, comments.created_at, hotels.hotel')
            ->join('hotels', 'hotels.id = comments.hotel_id', 'left')
            ->orderBy('comments.created_at', 'DESC')
            ->findAll();
    }
}