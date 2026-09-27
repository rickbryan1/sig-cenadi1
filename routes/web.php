<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AlertController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// 1. Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2. Panneau Administrateur (KAMGAING TCHOUAMBOU)
Route::get('/admin', [AdminController::class, 'index'])->middleware(['auth', 'role:admin']);
Route::post('/admin/users/{id}/toggle', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle')->middleware(['auth', 'role:admin']);

// 3. Tableau de bord Chef de Projet (KIM HYUNG)
Route::get('/dashboard', [ProjectController::class, 'index'])->middleware(['auth', 'role:chef_projet']);
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store')->middleware(['auth', 'role:chef_projet']);

// 4. Espace Membre (BTS)
Route::get('/tasks', [TaskController::class, 'index'])->middleware(['auth', 'role:member']);
Route::post('/tasks/{id}/update', [TaskController::class, 'update'])->name('tasks.update')->middleware(['auth', 'role:member']);

// 5. Portail Commanditaire / Sponsor (BANGTAN)
Route::get('/sponsor', [SponsorController::class, 'index'])->middleware(['auth', 'role:sponsor']);
Route::get('/sponsor', [SponsorController::class, 'index'])->middleware(['auth']);
Route::post('/sponsor/projects/{id}/validate', [SponsorController::class, 'validateProject'])->name('sponsor.validate')->middleware(['auth']);
Route::post('/sponsor/projects/{id}/reject', [SponsorController::class, 'rejectProject'])->name('sponsor.reject')->middleware(['auth']);
Route::post('/sponsor/projects/{id}/close', [SponsorController::class, 'closeProject'])->name('sponsor.close')->middleware(['auth']);
Route::post('/sponsor/projects/{id}/reject-eval', [SponsorController::class, 'rejectEvaluation'])->name('sponsor.rejectEval')->middleware(['auth']);
// 6. Notifications & Alertes
Route::get('/alerts', fn() => view('alerts'))->middleware(['auth']);

// Routes Administrateur avancées
Route::get('/admin', [AdminController::class, 'index'])->middleware(['auth', 'role:admin']);
Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store')->middleware(['auth', 'role:admin']);
Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update')->middleware(['auth', 'role:admin']);
Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete')->middleware(['auth', 'role:admin']);
Route::post('/admin/users/{id}/toggle', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle')->middleware(['auth', 'role:admin']);
Route::get('/admin/backup', [AdminController::class, 'backupDatabase'])->name('admin.backup')->middleware(['auth', 'role:admin']);

Route::get('/alerts', [AlertController::class, 'index'])->middleware(['auth']);
Route::post('/admin/reset-requests/{id}/resolve', [AdminController::class, 'resolveResetRequest'])->name('admin.reset.resolve')->middleware(['auth', 'role:admin']);
Route::put('/admin/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update')->middleware(['auth', 'role:admin']);
Route::post('/admin/restore', [AdminController::class, 'restoreDatabase'])->name('admin.restore')->middleware(['auth', 'role:admin']);

Route::get('/tasks', [TaskController::class, 'index'])->middleware(['auth']);
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store')->middleware(['auth']);
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update')->middleware(['auth']);
Route::post('/tasks/{id}/upload', [TaskController::class, 'uploadDeliverable'])->name('tasks.upload')->middleware(['auth']);
Route::put('/tasks/{id}/block', [TaskController::class, 'update'])->name('tasks.block')->middleware(['auth']);

Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::post('/profile/update', [App\Http\Controllers\DashboardController::class, 'updateProfile'])->name('profile.update')->middleware('auth');
Route::post('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

Route::post('/projects/{id}/send-to-sponsor', [ProjectController::class, 'sendToSponsor'])->name('projects.sendToSponsor')->middleware('auth');
Route::post('/projects/{id}/submit-evaluation', [ProjectController::class, 'submitEvaluation'])->name('projects.submitEvaluation')->middleware('auth');

// Routes sécurisées pour le téléchargement des livrables et des rapports
Route::get('/tasks/{id}/download', [TaskController::class, 'downloadDeliverable'])->name('tasks.download')->middleware(['auth']);
Route::get('/projects/{id}/download-evaluation', [TaskController::class, 'downloadEvaluationReport'])->name('projects.downloadEvaluation')->middleware(['auth']);

// Routes sécurisées pour le téléchargement des livrables et des rapports
Route::get('/tasks/{id}/download', [TaskController::class, 'downloadDeliverable'])->name('tasks.download')->middleware(['auth']);
Route::get('/projects/{id}/download-evaluation', [TaskController::class, 'downloadEvaluationReport'])->name('projects.downloadEvaluation')->middleware(['auth']);
