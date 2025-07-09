<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuleController;
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
    // Rota para gerenciamento de roles
    Route::prefix('roles')->group(function () {
        Route::get('', [RoleController::class, 'index']);
    });
});


// CREATOR
Route::middleware(['auth:sanctum', 'role:CRIADOR'])->prefix('creator')->group(function () {
    // Rotas para Cursos
    Route::prefix('courses')->group(function () {
       Route::get('', [CourseController::class, 'index']);
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
});

// Rota LOGOUT
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

