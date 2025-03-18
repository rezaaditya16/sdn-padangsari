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

Route::get('/about', function () {
    return Livewire::mount(AboutPage::class);
});

Route::get('/achievement', function () {
    return Livewire::mount(AchievementPage::class);
});

Route::get('/announcement', function () {
    return Livewire::mount(AnnouncementPage::class);
});

Route::get('/contact', function () {
    return Livewire::mount(ContactPage::class);
});

Route::get('/gallery', function () {
    return Livewire::mount(GalleryPage::class);
});

Route::get('/home', function () {
    return Livewire::mount(HomePage::class);
});

Route::get('/news', function () {
    return Livewire::mount(NewsPage::class);
});

Route::get('/profile', function () {
    return Livewire::mount(ProfilePage::class);
});

