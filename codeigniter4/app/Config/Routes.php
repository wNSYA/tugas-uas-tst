<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route for the home page
$routes->get('/', 'Home::index');

// User Authentication Routes
$routes->group('user', function($routes) {
    $routes->get('register', 'UserController::register');  // Display registration form (HTML form)
    $routes->post('register', 'UserController::save');  // Handle registration (POST request)
    
    $routes->get('login', 'UserController::login');  // Display login form (HTML form)
    $routes->post('login', 'UserController::loginAttempt');  // Handle login attempt (POST request)

    $routes->get('profile', 'UserController::profile');  // Get profile (view in JSON)
    $routes->post('updateProfile', 'UserController::updateProfile');  // Update profile (POST request)
    $routes->get('logout', 'DashboardController::logout');  // Logout endpoint (POST request)
});

// Quiz Routes
$routes->get('/dashboard', 'DashboardController::index');       // Display list of quizzes
$routes->get('/quiz/(:num)', 'QuizController::getQuizDetails/$1');
$routes->get('/quiz/start/(:num)', 'QuizController::startQuiz/$1');
$routes->post('/quiz/submit', 'QuizController::submitQuiz');

// app/Config/Routes.php
$routes->get('quiz/list', 'QuizController::listQuiz');

$routes->post('/quiz/answer', 'QuizController::answerQuiz');


// // API route for quiz
// $routes->get('/api/quiz/(:num)', 'QuizController::getQuizById/$1');
