<?php

use App\Http\Controllers\AdminCourseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ContentTypeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardStatsController;
use App\Http\Controllers\PublicCourseController;
use App\Http\Controllers\RegistrationCourseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentClasseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return json_encode('Welcome to LumenIF API.');
});

// Rotas ADMIN
Route::middleware(['auth:sanctum', 'role:ADMIN'])->prefix('admin')->group(function () {
    // Rotas para gerenciamento de usuários
    Route::prefix('users')->group(function () {
        Route::get('', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    Route::get('/courses-approved', [AdminCourseController::class, 'getAllApproved']);
    Route::get('/courses-pending', [AdminCourseController::class, 'getAllPending']);
    Route::get('/courses', [AdminCourseController::class, 'index']);
    Route::put('/courses/{course:public_id}/approve', [AdminCourseController::class, 'approve']);
    Route::put('/courses/{course:public_id}/reject', [AdminCourseController::class, 'reject']);

    // Rota para gerenciamento de roles
    Route::prefix('roles')->group(function () {
        Route::get('', [RoleController::class, 'index']);
    });
});

// CREATOR
Route::middleware(['auth:sanctum', 'role:CREATOR'])->prefix('creator')->group(function () {
    // Rotas para Cursos
    Route::prefix('courses')->group(function () {
       Route::get('', [CourseController::class, 'index']);
       Route::get('/{id}', [CourseController::class, 'show']);
       Route::post('', [CourseController::class, 'store']);
       Route::put('/{id}', [CourseController::class, 'update']);
       Route::delete('/{id}', [CourseController::class, 'destroy']);

       // Rotas para Módulos de um Curso
       Route::prefix('modules')->group(function () {
           Route::get('', [ModuleController::class, 'index']);
           Route::post('', [ModuleController::class, 'store']);
           Route::put('/{id}', [ModuleController::class, 'update']);
           Route::delete('/{id}', [ModuleController::class, 'destroy']);

           // Rotas para Aulas de um Módulo
           Route::prefix('classes')->group(function () {
               Route::get('', [ClasseController::class, 'index']);
               Route::post('', [ClasseController::class, 'store']);
               Route::put('/{id}', [ClasseController::class, 'update']);
               Route::delete('/{id}', [ClasseController::class, 'destroy']);
           });
       });
   });

    Route::get('/content-types', [ContentTypeController::class, 'index']);

    Route::get('/stats/kpis', [DashboardStatsController::class, 'mainDashboardStats']);
    Route::get('/stats/course-status', [DashboardStatsController::class, 'courseStatusStats']);
    Route::get('/stats/top-courses', [DashboardStatsController::class, 'topCoursesByStudents']);

});

// Rotas com Autenticação necessária
Route::middleware(['auth:sanctum'])->group(function () {
    // Rota LOGOUT
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/courses', [PublicCourseController::class, 'index']);
    Route::get('/courses/{id}', [PublicCourseController::class, 'show']);

    // Rotas ALUNO
    Route::middleware('role:STUDENT')->group(function () {
        Route::get('courses/{course:public_id}/registration', [RegistrationCourseController::class, 'show']);
        // Inscrever-se num Curso
        Route::post('courses/{course:public_id}/registration', [RegistrationCourseController::class, 'store']);

        Route::prefix('student')->group(function () {
            Route::get('/registrations', [RegistrationCourseController::class, 'index']);
            Route::post('/classes/{classe_id}/completed', [StudentClasseController::class, 'completed']);
        });
    });
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

