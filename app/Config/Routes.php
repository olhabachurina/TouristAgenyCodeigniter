<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Главная страница
$routes->get('/', 'Home::index');

// Авторизация
$routes->post('/login', 'AuthController::login');
$routes->post('logout', 'AuthController::logout');

// Маршруты для пользователей
$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/tours', 'ToursController::index');
    $routes->get('/hotel/(:num)', 'HotelController::details/$1');
    $routes->get('/comments', 'CommentsController::index');
    $routes->post('/comments/add', 'CommentsController::addComment');
    $routes->get('/comments/list', 'CommentsController::list');
});

// Маршруты для администраторов
$routes->group('admin', ['filter' => 'auth:1'], function ($routes) {
    $routes->get('/', 'AdminController::index');
    // Управление странами
    $routes->post('add-country', 'AdminController::addCountry');
    $routes->post('delete-country', 'AdminController::deleteCountry');

    // Управление городами
    $routes->post('add-city', 'AdminController::addCity');
    $routes->post('delete-city', 'AdminController::deleteCity');

    // Управление отелями
    $routes->post('add-hotel', 'AdminController::addHotel');
    $routes->post('delete-hotel', 'AdminController::deleteHotel');

    // Управление изображениями
    $routes->post('add-image', 'AdminController::addImage');
    $routes->post('delete-image', 'AdminController::deleteImage');

    // Управление администраторами
    $routes->get('manage_admins', 'AdminController::manageAdmins');
    $routes->post('update_admin', 'AdminController::updateAdmin');
});

// Регистрация
$routes->get('/registration', 'RegistrationController::index');
$routes->post('/registration', 'RegistrationController::register');