<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'en'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [AppointmentController::class, 'dashboard'])->name('dashboard');
    Route::get('appointments/search', [AppointmentController::class, 'search'])->name('appointments.search');
    Route::resource('appointments', AppointmentController::class);

    // Routes admin
    Route::get('admin/doctors', [AdminController::class, 'doctors'])->name('admin.doctors');
    Route::get('admin/doctors/search', [AdminController::class, 'searchDoctors'])->name('admin.doctors.search');
    Route::get('admin/doctors/create', [AdminController::class, 'createDoctor'])->name('admin.doctors.create');
    Route::post('admin/doctors', [AdminController::class, 'storeDoctor'])->name('admin.doctors.store');
    Route::delete('admin/doctors/{user}', [AdminController::class, 'destroyDoctor'])->name('admin.doctors.destroy');
    Route::get('admin/patients', [AdminController::class, 'patients'])->name('admin.patients');
    Route::get('admin/patients/search', [AdminController::class, 'searchPatients'])->name('admin.patients.search');
    Route::get('admin/patients/{user}', [AdminController::class, 'patientHistory'])->name('admin.patients.history');
});