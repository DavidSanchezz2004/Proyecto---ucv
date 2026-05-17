<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SolCredentialController;
use App\Http\Controllers\SolAccessController;
use App\Http\Controllers\AccessLogController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ResearchController;
use Illuminate\Support\Facades\Route;

// Rutas de invitado
Route::middleware('guest')->group(function () {
    Route::get('/',          [AuthController::class,    'showLoginForm'])->name('login');
    Route::post('/login',    [AuthController::class,    'login'])->middleware('throttle:10,1')->name('login.post');
    Route::get('/register',  [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->middleware('throttle:5,1')->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rutas autenticadas
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Solo Administrador: usuarios y credenciales SOL
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
        Route::resource('sol-credentials', SolCredentialController::class)->except(['show']);
    });

    // Empresas: todos crean/ven, autorización granular en el controller
    Route::get ('companies',                [CompanyController::class, 'index'])->name('companies.index');
    Route::get ('companies/create',         [CompanyController::class, 'create'])->name('companies.create');
    Route::post('companies',                [CompanyController::class, 'store'])->name('companies.store');
    Route::get ('companies/{company}/edit',       [CompanyController::class, 'edit'])->name('companies.edit');
    Route::put ('companies/{company}',            [CompanyController::class, 'update'])->name('companies.update');
    Route::delete('companies/{company}',          [CompanyController::class, 'destroy'])->name('companies.destroy');
    Route::post('companies/{company}/credential', [CompanyController::class, 'storeCredential'])->name('companies.storeCredential');
    Route::get ('companies/{company}',            [CompanyController::class, 'show'])->name('companies.show');

    // Logs y eficiencia: todos los autenticados (filtrado por usuario en el controller)
    Route::get('access-logs',        [AccessLogController::class, 'index'])->name('access-logs.index');
    Route::get('reports/efficiency', [ReportController::class, 'efficiency'])->name('reports.efficiency');

    // Resultados encuesta: solo admin/supervisor
    Route::middleware(['role:admin,supervisor'])->group(function () {
        Route::get('survey/results', [SurveyController::class, 'results'])->name('survey.results');
    });

    // Acceso SOL — todos los autenticados
    Route::get ('sol/{company}/launch/{sistema}', [SolAccessController::class, 'launch'])->name('sol.launch');
    Route::post('sol/{company}/access',           [SolAccessController::class, 'initiate'])->name('sol.access');
    Route::post('sol/{log}/complete',             [SolAccessController::class, 'complete'])->name('sol.complete');
    Route::post('sol/{log}/fail',                 [SolAccessController::class, 'fail'])->name('sol.fail');

    Route::get ('survey',        [SurveyController::class, 'index'])->name('survey.index');
    Route::post('survey',        [SurveyController::class, 'store'])->name('survey.store');
    Route::get ('survey/thanks', [SurveyController::class, 'thanks'])->name('survey.thanks');

    // Páginas informativas de investigación
    Route::get('research/about', [ResearchController::class, 'about'])->name('research.about');
    Route::get('research/team',  [ResearchController::class, 'team'])->name('research.team');
});
