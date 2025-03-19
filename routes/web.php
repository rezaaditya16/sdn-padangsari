<?php
// filepath: d:\sdn-padangsari\routes\web.php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\HomePage;
use App\Http\Livewire\AboutPage;
use App\Http\Livewire\AchievementPage;
use App\Http\Livewire\AnnouncementPage;
use App\Http\Livewire\ContactPage;
use App\Http\Livewire\GalleryPage;
use App\Http\Livewire\NewsPage;
use App\Http\Livewire\ProfilePage;

Route::get('/', HomePage::class)->name('home');
Route::get('/about', AboutPage::class)->name('about');
Route::get('/achievement', AchievementPage::class)->name('achievement');
Route::get('/announcement', AnnouncementPage::class)->name('announcement');
Route::get('/contact', ContactPage::class)->name('contact');
Route::get('/gallery', GalleryPage::class)->name('gallery');
Route::get('/news', NewsPage::class)->name('news');
Route::get('/profile', ProfilePage::class)->name('profile');