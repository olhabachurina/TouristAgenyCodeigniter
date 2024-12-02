<?php

namespace App\Controllers;

use App\Models\CommentsModel;
use App\Models\HotelsModel;

class CommentsController extends BaseController
{
    public function index()
    {
        $commentsModel = new CommentsModel();
        $hotelsModel = new HotelsModel();

        try {
            // Получаем комментарии с именами отелей
            $data['comments'] = $commentsModel
                ->join('hotels', 'comments.hotel_id = hotels.id', 'left')
                ->select('comments.*, hotels.hotel')
                ->orderBy('comments.created_at', 'DESC')
                ->findAll();

            // Получаем список отелей
            $data['hotels'] = $hotelsModel->findAll();

            // Передаем данные во view
            return view('comments/index', $data);
        } catch (\Exception $e) {
            log_message('error', '[ERROR] Loading comments failed: ' . $e->getMessage());
            return redirect()->to('/')->with('error', 'Не удалось загрузить данные. Попробуйте позже.');
        }
    }

    public function addComment()
    {
        $session = session();

        // Проверяем, авторизован ли пользователь
        if (!$session->has('user')) {
            log_message('error', 'Попытка добавления комментария неавторизованным пользователем.');
            return redirect()->back()->with('error', 'Вы должны быть авторизованы для добавления комментария.');
        }

        // Получаем данные из сессии и запроса
        $user = $session->get('user');
        $hotelId = $this->request->getPost('hotel_id');
        $comment = $this->request->getPost('comment');

        // Проверяем, заполнены ли обязательные поля
        if (empty($hotelId) || empty($comment)) {
            return redirect()->back()->with('error', 'Поля "Отель" и "Комментарий" обязательны.');
        }

        // Сохраняем комментарий в базу данных
        $commentsModel = new CommentsModel();
        $data = [
            'hotel_id'   => $hotelId,
            'user'       => $user['login'], // Используем логин из сессии
            'comment'    => $comment,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if ($commentsModel->insert($data)) {
            return redirect()->to('/comments')->with('success', 'Комментарий успешно добавлен!');
        }

        return redirect()->back()->with('error', 'Не удалось добавить комментарий.');
    }
}