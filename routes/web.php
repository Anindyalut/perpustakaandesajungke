<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Admin\ReportController;

/*
|--------------------------------------------------------------------------
| MEMBER CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Member\HomeController as MemberHomeController;
use App\Http\Controllers\Member\BookController as MemberBookController;
use App\Http\Controllers\Member\TransactionController as MemberTransactionController;
use App\Http\Controllers\Member\ProfileController as MemberProfileController;
use App\Http\Controllers\Admin\FpGrowthController;


/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => redirect()->route('login'));

/*
|--------------------------------------------------------------------------
| REDIRECT AFTER LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return auth()->user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('member.home');
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // CRUD
        Route::resource('books', BookController::class);
        Route::resource('members', MemberController::class);

        // Transactions
        Route::get('/transactions', [AdminTransactionController::class, 'index'])
            ->name('transactions.index');

        Route::patch('/transactions/{transaction}/pinjam',
            [AdminTransactionController::class, 'setBorrowed'])
            ->name('transactions.borrow');

        Route::patch('/transactions/{transaction}/selesai',
            [AdminTransactionController::class, 'setReturned'])
            ->name('transactions.return');

        // Reports transaksi
        Route::get('/laporan', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/laporan/pdf', [ReportController::class, 'exportPdf'])
            ->name('reports.pdf');

        // Export buku PDF
        Route::get('/books-export/pdf', [BookController::class, 'exportPdf'])
            ->name('books.pdf');

        // FP-Growth (Rekomendasi Buku)
        Route::get('/rekomendasi', [FpGrowthController::class, 'index'])
            ->name('fpgrowth.index');

        Route::get('/parameter-rekomendasi', [FpGrowthController::class, 'parameter'])
            ->name('fpgrowth.parameter');

        Route::post('/parameter-rekomendasi', [FpGrowthController::class, 'saveParameter'])
            ->name('fpgrowth.parameter.save');


    });


/*
|--------------------------------------------------------------------------
| MEMBER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('member')
    ->name('member.')
    ->group(function () {

        // Home
        Route::get('/home', [MemberHomeController::class, 'index'])
            ->name('home');

        // Book detail
        Route::get('/books/{book}', [MemberBookController::class, 'show'])
            ->name('books.show');

        // Transactions
        Route::post('/transactions/{book}', [MemberTransactionController::class, 'store'])
            ->name('transactions.store');

        Route::get('/transactions', [MemberTransactionController::class, 'index'])
            ->name('transactions.index');

        // Profile
        Route::get('/profile', [MemberProfileController::class, 'edit'])
            ->name('profile');

        Route::put('/profile', [MemberProfileController::class, 'update'])
            ->name('profile.update');
    });

/*
|--------------------------------------------------------------------------
| DEFAULT PROFILE (BREEZE)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});



/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
