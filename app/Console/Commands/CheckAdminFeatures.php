<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckAdminFeatures extends Command
{
    protected $signature = 'admin:check-features';
    protected $description = 'Check all admin panel features for errors';

    private $adminRoutes = [
        'admin.dashboard' => 'Dashboard',
        'admin.pengaduan.index' => 'Kelola Pengaduan',
        'admin.categories.index' => 'Kategori',
        'admin.users.index' => 'Users',
        'admin.students.index' => 'Students',
        'admin.teachers.index' => 'Teachers',
        'admin.announcements.index' => 'Announcements',
        'admin.gallery.index' => 'Gallery',
        'admin.classrooms.index' => 'Classrooms',
        'admin.email-settings' => 'Email Settings',
    ];

    public function handle()
    {
        $this->info('🔍 Checking Admin Panel Features...');
        $this->newLine();

        // Login as admin
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            $this->error('❌ No admin user found!');
            return 1;
        }

        Auth::login($admin);
        $this->info("✅ Logged in as: {$admin->name} ({$admin->email})");
        $this->newLine();

        $errors = [];
        $success = 0;
        $total = count($this->adminRoutes);

        foreach ($this->adminRoutes as $routeName => $description) {
            try {
                // Check if route exists
                if (!Route::has($routeName)) {
                    $errors[] = "❌ Route '{$routeName}' ({$description}) - ROUTE NOT FOUND";
                    continue;
                }

                // Try to generate URL
                $url = route($routeName);
                
                // Check for common Livewire components
                $this->checkLivewireComponent($routeName, $description, $errors);
                
                $this->info("✅ {$description} - Route exists: {$url}");
                $success++;
                
            } catch (\Exception $e) {
                $errors[] = "❌ {$description} - ERROR: " . $e->getMessage();
            }
        }

        $this->newLine();
        $this->info("📊 Summary:");
        $this->info("✅ Working features: {$success}/{$total}");
        
        if (count($errors) > 0) {
            $this->error("❌ Issues found: " . count($errors));
            $this->newLine();
            foreach ($errors as $error) {
                $this->error($error);
            }
        } else {
            $this->info("🎉 All admin features are properly configured!");
        }

        return count($errors) > 0 ? 1 : 0;
    }

    private function checkLivewireComponent($routeName, $description, &$errors)
    {
        $livewireComponents = [
            'admin.pengaduan.index' => 'App\Livewire\Admin\PengaduanIndex',
            'admin.categories.index' => 'App\Livewire\Admin\CategoryManagement',
            'admin.users.index' => 'App\Livewire\Admin\UserManagement',
            'admin.students.index' => 'App\Livewire\Admin\StudentManagement',
            'admin.teachers.index' => 'App\Livewire\Admin\TeacherManagement',
            'admin.announcements.index' => 'App\Livewire\Admin\AnnouncementManagement',
            'admin.gallery.index' => 'App\Livewire\Admin\GalleryManagement',
            'admin.classrooms.index' => 'App\Livewire\Admin\ClassroomManagement',
        ];

        if (isset($livewireComponents[$routeName])) {
            $componentClass = $livewireComponents[$routeName];
            if (!class_exists($componentClass)) {
                $errors[] = "⚠️  {$description} - Livewire component '{$componentClass}' not found";
            }
        }
    }
}
