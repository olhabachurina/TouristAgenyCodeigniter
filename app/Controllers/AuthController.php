<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    /**
     * Авторизация пользователя
     */
    public function login()
    {
        $session = session();
        $userModel = new UserModel();

        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        // Логируем полученные данные
        log_message('debug', "Параметры логина: Login - {$login}, Password - {$password}");

        // Проверяем, что поля заполнены
        if (empty($login) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Логин и пароль обязательны.');
        }

        // Находим пользователя по логину
        $user = $userModel->where('login', $login)->first();
        log_message('debug', 'Данные пользователя из базы: ' . json_encode($user));

        if ($user && password_verify($password, $user['pass'])) {
            // Сохраняем данные в сессии
            $session->set('user', [
                'id' => $user['id'],
                'login' => $user['login'],
                'role' => $user['roleid'],
            ]);

            log_message('info', "Пользователь успешно авторизован: {$login}");

            return redirect()->to('/')->with('success', "Добро пожаловать, {$user['login']}!");
        }

        log_message('error', "Неудачная попытка логина: {$login}");

        return redirect()->to('/')->with('error', 'Неверный логин или пароль.');
    }

    /**
     * Выход из системы
     */
    public function logout()
    {
        $session = session();
        $session->destroy();

        return redirect()->to('/')->with('success', 'You have been logged out successfully.');
    }
}