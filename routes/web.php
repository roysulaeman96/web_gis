<?php

use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/dashboard', function () {
        $user = request()->user()->loadMissing(['kelompok']);
        $apiToken = session('api_token');

        if (! $apiToken) {
            $user->tokens()->delete();
            $apiToken = $user->createToken('web-gis-token')->plainTextToken;
            session(['api_token' => $apiToken]);
        }

        return view('dashboard', [
            'apiToken' => $apiToken,
            'user' => $user,
        ]);
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('/petugas/tracking', function () {
        $user = request()->user()->loadMissing(['kelompok']);
        $apiToken = session('api_token');

        if (! $apiToken) {
            $user->tokens()->delete();
            $apiToken = $user->createToken('web-gis-token')->plainTextToken;
            session(['api_token' => $apiToken]);
        }

        return view('petugas.tracking', [
            'apiToken' => $apiToken,
            'user' => $user,
        ]);
    })->name('petugas.tracking');

    Route::get('/petugas/tracking/pdf', [ReportController::class, 'petugasTrackingPdf'])
        ->name('petugas.tracking.pdf');

    Route::get('/petugas/tracking/pdf-download', [ReportController::class, 'petugasTrackingPdfDownload'])
        ->name('petugas.tracking.pdf-download');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/tracking', function () {
        $user = request()->user()->loadMissing(['kelompok']);
        $apiToken = session('api_token');

        if (! $apiToken) {
            $user->tokens()->delete();
            $apiToken = $user->createToken('web-gis-token')->plainTextToken;
            session(['api_token' => $apiToken]);
        }

        $petugas = User::query()
            ->with(['kelompok'])
            ->select(['id', 'name', 'username', 'email', 'kelompok_id'])
            ->where('role', 'petugas')
            ->orderBy('name')
            ->get();

        return view('admin.tracking', [
            'apiToken' => $apiToken,
            'user' => $user,
            'petugas' => $petugas,
        ]);
    })->name('admin.tracking');

    Route::get('/admin/tracking/pdf', [ReportController::class, 'adminTrackingPdf'])
        ->name('admin.tracking.pdf');

    Route::get('/admin/tracking/pdf-download', [ReportController::class, 'adminTrackingPdfDownload'])
        ->name('admin.tracking.pdf-download');

    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users');
    Route::post('/admin/users', [UserManagementController::class, 'store'])->name('admin.users.store');
    Route::put('/admin/users/{targetUser}', [UserManagementController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/bulk-delete', [UserManagementController::class, 'bulkDelete'])->name('admin.users.bulk-delete');
});
