<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'Home::index');
$routes->get('/test', 'Home::test');

// =========================================================================
// Admin Routes
// =========================================================================
$routes->group('admin', static function ($routes) {

    // --- Guest Routes ---
    $routes->get('login', 'Auth\LoginController::index', ['as' => 'admin.login']);
    $routes->post('login', 'Auth\LoginController::login', ['as' => 'admin.login.submit']);

    // --- Protected Routes ---
    $routes->group('', ['filter' => 'adminauth'], static function ($routes) {

        // Dashboard & Auth
        $routes->get('dashboard', 'Admin\DashboardController::index', ['as' => 'admin.dashboard']);
        $routes->get('logout', 'Auth\LoginController::logout', ['as' => 'admin.logout']);

        // --- Category Module Routes ---
        $routes->group('categories', static function ($routes) {

            // 1. Static Endpoints First
            $routes->get('/', 'Admin\CategoryController::index', ['as' => 'admin.categories.index']);
            $routes->get('create', 'Admin\CategoryController::create', ['as' => 'admin.categories.create']);
            $routes->post('/', 'Admin\CategoryController::store', ['as' => 'admin.categories.store']);
            $routes->get('trash', 'Admin\CategoryController::trash', ['as' => 'admin.categories.trash']);

            // 2. Dynamic/Parameterized Endpoints Last
            $routes->get('(:num)/edit', 'Admin\CategoryController::edit/$1', ['as' => 'admin.categories.edit']);
            $routes->put('(:num)', 'Admin\CategoryController::update/$1', ['as' => 'admin.categories.update']);
            $routes->delete('(:num)', 'Admin\CategoryController::delete/$1', ['as' => 'admin.categories.delete']);
            $routes->patch('(:num)/restore', 'Admin\CategoryController::restore/$1', ['as' => 'admin.categories.restore']);
            $routes->delete('(:num)/force', 'Admin\CategoryController::forceDelete/$1', ['as' => 'admin.categories.forceDelete']);
        });

        // --- Subject Module Routes ---
        $routes->group('subjects', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
            // Subject Routes
            $routes->get('/', 'SubjectController::index', ['as' => 'admin.subjects.index']);
            $routes->get('trash', 'SubjectController::trash', ['as' => 'admin.subjects.trash']);
            $routes->get('create', 'SubjectController::create', ['as' => 'admin.subjects.create']);
            $routes->post('/', 'SubjectController::store', ['as' => 'admin.subjects.store']);
            $routes->get('(:num)/edit', 'SubjectController::edit/$1', ['as' => 'admin.subjects.edit']);
            $routes->post('(:num)', 'SubjectController::update/$1', ['as' => 'admin.subjects.update']);
            $routes->delete('(:num)', 'SubjectController::delete/$1', ['as' => 'admin.subjects.delete']);
            $routes->patch('(:num)/restore', 'SubjectController::restore/$1', ['as' => 'admin.subjects.restore']);
            $routes->delete('(:num)/force-delete', 'SubjectController::forceDelete/$1', ['as' => 'admin.subjects.forceDelete']);
        });

        // --- Exam Module Routes ---
        $routes->group('exams', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
            // Exam Routes
            $routes->get('/', 'ExamController::index', ['as' => 'admin.exams.index']);
            $routes->get('trash', 'ExamController::trash', ['as' => 'admin.exams.trash']);
            $routes->get('create', 'ExamController::create', ['as' => 'admin.exams.create']);
            $routes->post('/', 'ExamController::store', ['as' => 'admin.exams.store']);
            $routes->get('(:num)/edit', 'ExamController::edit/$1', ['as' => 'admin.exams.edit']);
            $routes->post('(:num)', 'ExamController::update/$1', ['as' => 'admin.exams.update']);
            $routes->delete('(:num)', 'ExamController::delete/$1', ['as' => 'admin.exams.delete']);
            $routes->patch('(:num)/restore', 'ExamController::restore/$1', ['as' => 'admin.exams.restore']);
            $routes->delete('(:num)/force-delete', 'ExamController::forceDelete/$1', ['as' => 'admin.exams.forceDelete']);
        });


        // --- Question Module Routes ---
        $routes->group('questions', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
            // Question Bank Routes
            $routes->get('/', 'QuestionController::index', ['as' => 'admin.questions.index']);
            $routes->get('trash', 'QuestionController::trash', ['as' => 'admin.questions.trash']);
            $routes->get('create', 'QuestionController::create', ['as' => 'admin.questions.create']);
            $routes->post('/', 'QuestionController::store', ['as' => 'admin.questions.store']);
            $routes->get('(:num)/edit', 'QuestionController::edit/$1', ['as' => 'admin.questions.edit']);
            $routes->post('(:num)', 'QuestionController::update/$1', ['as' => 'admin.questions.update']);
            $routes->delete('(:num)', 'QuestionController::delete/$1', ['as' => 'admin.questions.delete']);
            $routes->patch('(:num)/restore', 'QuestionController::restore/$1', ['as' => 'admin.questions.restore']);
            $routes->delete('(:num)/force-delete', 'QuestionController::forceDelete/$1', ['as' => 'admin.questions.forceDelete']);
        });


        // --- Options Module Routes ---
        $routes->group('options', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
            // Options Routes
            $routes->get('/', 'OptionController::index', ['as' => 'admin.options.index']);
            $routes->get('trash', 'OptionController::trash', ['as' => 'admin.options.trash']);
            $routes->get('create', 'OptionController::create', ['as' => 'admin.options.create']);
            $routes->get('create-single', 'OptionController::createSingle', ['as' => 'admin.options.createSingle']);
            $routes->post('/', 'OptionController::store', ['as' => 'admin.options.store']);

            // Single Option Routes
            $routes->get('(:num)/edit', 'OptionController::editSingle/$1', ['as' => 'admin.options.edit']);
            $routes->post('(:num)', 'OptionController::update/$1', ['as' => 'admin.options.update']);

            // Batch Options Routes
            $routes->get('question/(:num)/edit', 'OptionController::editBatch/$1', ['as' => 'admin.options.editBatch']);
            $routes->post('question/(:num)', 'OptionController::updateBatch/$1', ['as' => 'admin.options.updateBatch']);

            // $routes->get('(:num)/edit', 'OptionController::edit/$1', ['as' => 'admin.options.edit']);
            // $routes->post('(:num)', 'OptionController::update/$1', ['as' => 'admin.options.update']);
            $routes->delete('(:num)', 'OptionController::delete/$1', ['as' => 'admin.options.delete']);
            $routes->patch('(:num)/restore', 'OptionController::restore/$1', ['as' => 'admin.options.restore']);
            $routes->delete('(:num)/force-delete', 'OptionController::forceDelete/$1', ['as' => 'admin.options.forceDelete']);
        });
    });
});

// Shield Routes Registration
service('auth')->routes($routes);
