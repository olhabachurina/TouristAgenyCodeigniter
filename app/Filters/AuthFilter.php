<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Логируем содержимое сессии
        log_message('debug', 'Содержимое сессии: ' . json_encode($session->get()));

        // Проверка авторизации
        if (!$session->has('user')) {
            log_message('error', 'Попытка доступа без авторизации.');
            return redirect()->to('/')->with('error', 'Access denied. Please log in.');
        }

        // Проверка роли
        $user = $session->get('user');
        if ($arguments && isset($user['role'])) {
            $requiredRole = $arguments[0]; // Требуемая роль
            if ($user['role'] != $requiredRole) {
                log_message('error', 'Доступ запрещен: роль не соответствует.');
                return redirect()->to('/')->with('error', 'You do not have permission to access this page.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Не используется
    }
}