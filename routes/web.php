<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CampaignController;
use App\Models\Campaign;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

Route::get('/dashboard', function () {
  $campaigns = auth()->user()
    ->campaigns()
    ->with('owner')
    ->get();

  return view('dashboard', compact('campaigns'));
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
  Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
  Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
});

require __DIR__ . '/auth.php';
