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
use App\Livewire\VisimisiPage;
use App\Livewire\KontakPage;
use App\Livewire\PengumumanPage;
use App\Livewire\PengaduanPage;
use App\Livewire\GuruPage;

Route::get('/', HomePage::class)->name('home');
Route::get('/about', AboutPage::class)->name('about');
Route::get('/achievement', AchievementPage::class)->name('achievement');
Route::get('/announcement', AnnouncementPage::class)->name('announcement');
Route::get('/contact', ContactPage::class)->name('contact');
Route::get('/gallery', GalleryPage::class)->name('gallery');
Route::get('/news', NewsPage::class)->name('news');
Route::get('/profile', ProfilePage::class)->name('profile');
route::get('/visimisi', VisimisiPage::class)->name('visimisi');
route::get('/kontak', KontakPage::class)->name('kontak');
route::get('/pengumuman', PengumumanPage::class)->name('pengumuman');
route::get('/pengaduan', PengaduanPage::class)->name('pengaduan');
route::get('/guru', GuruPage::class)->name('guru');