<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\AboutPage;
use App\Http\Livewire\AchievementPage;
use App\Http\Livewire\AnnouncementPage;
use App\Http\Livewire\ContactPage;
use App\Http\Livewire\GalleryPage;
use App\Http\Livewire\HomePage;
use App\Http\Livewire\NewsPage;
use App\Http\Livewire\ProfilePage;

Route::get('/about', AboutPage::class);
Route::get('/achievement', AchievementPage::class);
Route::get('/announcement', AnnouncementPage::class);
Route::get('/contact', ContactPage::class);
Route::get('/gallery', GalleryPage::class);
Route::get('/home', HomePage::class);
Route::get('/news', NewsPage::class);
Route::get('/profile', ProfilePage::class);

