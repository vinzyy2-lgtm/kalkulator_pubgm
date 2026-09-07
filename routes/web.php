<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicDashboardController;
use App\Http\Controllers\StandingsController;
use App\Http\Controllers\MostKillsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\PlayerController;
use App\Http\Controllers\Admin\MatchController;
use App\Http\Controllers\Admin\MatchResultController;

// ─────────────────────────────────────────────────────────
// PUBLIC ROUTES — bebas diakses tanpa login
// ─────────────────────────────────────────────────────────
Route::get('/', [PublicDashboardController::class, 'index'])->name('home');
Route::get('/standings', [StandingsController::class, 'index'])->name('standings');
Route::get('/most-kills', [MostKillsController::class, 'index'])->name('mostkills');

// ─────────────────────────────────────────────────────────
// ADMIN LOGIN — tersembunyi di /admin/login
// ─────────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

// ─────────────────────────────────────────────────────────
// ADMIN ONLY — semua butuh session role=admin
// ─────────────────────────────────────────────────────────
Route::middleware('admin.only')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('teams', TeamController::class);
    Route::post('teams/{team}/players', [PlayerController::class, 'update'])->name('teams.players.update');
    Route::get('players', [PlayerController::class, 'index'])->name('players.index');

    Route::resource('matches', MatchController::class);
    Route::post('matches/{match}/results', [MatchResultController::class, 'store'])->name('matches.results.store');
    Route::get('matches/{match}/results/{team}', [MatchResultController::class, 'getResult'])->name('matches.results.get');
});
