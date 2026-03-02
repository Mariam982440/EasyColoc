<?php

use App\Http\Controllers\ColocationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    
    Route::get('/dashboard',function(){
        $user = Auth::user();
        $colocation = $user->currentColocation();
        return view('/dashboard',compact('colocation','user'));
        })->name('dashboard');

    Route::get('/colocation',[ColocationController::class,'index'])->name('colocations.index');
    Route::get('/colocations/create', [ColocationController::class, 'create'])->name('colocations.create');
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');
    Route::get('/colocations/{colocation}', [ColocationController::class, 'show'])->name('colocations.show');
    Route::delete('/colocations/{colocation}', [ColocationController::class, 'destroy'])->name('colocations.destroy');
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::get('/join/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');


    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');

    // PATCH car on modifie juste une colonne (is_paid)
    Route::patch('/payments/{payment}/mark-as-paid', [PaymentController::class, 'markAsPaid'])->name('payments.markAsPaid');
    
    });