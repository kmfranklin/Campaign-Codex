<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\ItemController as PublicItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

Route::middleware(['auth'])->group(function () {
  // Dashboard
  Route::get('/dashboard', function () {
    $campaigns = auth()->user()
      ->campaigns()
      ->with('owner')
      ->get();

    return view('dashboard', compact('campaigns'));
  })->name('dashboard');

  // Profile
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  // Campaigns
  Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
  Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');

  // Campaign joining
  Route::get('/campaigns/join', [CampaignController::class, 'showJoinForm'])->name('campaigns.join.form');
  Route::post('/campaigns/lookup', [CampaignController::class, 'lookup'])->name('campaigns.join.lookup');
  Route::get('/campaigns/join/confirm', [CampaignController::class, 'confirm'])->name('campaigns.join.confirm');
  Route::post('/campaigns/join/confirm', [CampaignController::class, 'join'])->name('campaigns.join');
});

// Public Item Reference
Route::prefix('items')->name('items.')->group(function () {
  Route::get('/', [PublicItemController::class, 'index'])->name('index');
  Route::get('{key}', [PublicItemController::class, 'show'])->name('show');
});

// Auth scaffolding (login, register, etc.)
require __DIR__ . '/auth.php';
