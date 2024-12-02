<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $session = session();

        $data = [
            'user' => $session->get('user'), // Передаем данные пользователя в представление
        ];

        return view('home/index', $data);
    }
}