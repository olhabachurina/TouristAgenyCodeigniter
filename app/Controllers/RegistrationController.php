<?php

namespace App\Controllers;

use App\Models\UserModel;

class RegistrationController extends BaseController
{
    /**
     * Отображение страницы регистрации
     */
    public function index()
    {
        return view('registration/index'); // Убедитесь, что файл registration/index.php существует
    }

    /**
     * Регистрация пользователя
     */
    public function register()
    {
        $validation = \Config\Services::validation();

        // Правила валидации
        $validation->setRules([
            'login'    => 'required|alpha_numeric|min_length[3]|is_unique[users.login]', // Убедитесь, что таблица называется users
            'password' => 'required|min_length[6]',
            'email'    => 'required|valid_email|is_unique[users.email]',
        ], [
            'login' => [
                'required' => 'The login field is required.',
                'alpha_numeric' => 'Login must contain only letters and numbers.',
                'min_length' => 'Login must be at least 3 characters long.',
                'is_unique' => 'This login is already taken.',
            ],
            'password' => [
                'required' => 'The password field is required.',
                'min_length' => 'Password must be at least 6 characters long.',
            ],
            'email' => [
                'required' => 'The email field is required.',
                'valid_email' => 'Please provide a valid email address.',
                'is_unique' => 'This email is already registered.',
            ],
        ]);

        // Если валидация не прошла
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Сохраняем пользователя в базе данных
        $userModel = new UserModel();
        $userModel->save([
            'login'    => $this->request->getPost('login'),
            'pass'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Хешируем пароль
            'email'    => $this->request->getPost('email'),
            'roleid'   => 2, // По умолчанию роль пользователя
        ]);

        // Редирект с успешным сообщением
        return redirect()->to('/')->with('success', 'Registration successful! You can now log in.');
    }
}