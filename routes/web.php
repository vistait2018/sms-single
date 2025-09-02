<?php


use App\Livewire\Admin\Pages\Dashboard;
use App\Livewire\Admin\Pages\Users;
use App\Livewire\Admin\Pages\Schools;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Pages\RolesPermissions;
use App\Livewire\Admin\Pages\School\ClassManager;
use App\Livewire\Admin\Pages\School\Department;
use App\Livewire\Admin\Pages\School\School;
use App\Livewire\Admin\Pages\School\Subject;
use App\Livewire\Admin\Pages\School\DepartmentSubjects;
use App\Livewire\Admin\Pages\School\StudentRegister;
use App\Livewire\Admin\Pages\School\TeacherRegister;
use App\Livewire\Admin\Pages\YearManager;

Route::view('/', 'welcome');
//,'check_internet'
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/admin-users', Users::class)
        ->name('admin-users')
        ->middleware('super_admin');

    Route::get('/admin-schools',Schools::class)
        ->name('admin-schools')
        ->middleware('super_admin');

        Route::get('/admin-roles-permissions',RolesPermissions::class)
        ->name('admin-roles-permissions')
        ->middleware('super_admin');
         Route::get('/admin-session-manager',YearManager::class)
        ->name('admin-session-manager')
        ->middleware('super_admin');
        Route::get('/school-admin-school',School::class)
        ->name('school.admin.school')
        ->middleware('school_admin');
         Route::get('/school/admin/school/department',Department::class)
        ->name('school.admin.school.department')
        ->middleware('school_admin');
          Route::get('/school/admin/subject',Subject::class)
        ->name('school.admin.school.subject')
        ->middleware('school_admin');

          Route::get('/school/admin/department/subjects',DepartmentSubjects::class)
        ->name('school.admin.school.department.subjects')
        ->middleware('school_admin');
           Route::get('/school/admin/school/classes',ClassManager::class)
        ->name('school.admin.school.classes')
        ->middleware('school_admin');
        Route::get('/school/admin/school/teacher/registration',TeacherRegister::class)
        ->name('school.admin.school.teacher.registration')
        ->middleware('school_admin');

         Route::get('/school/admin/school/student/registration',StudentRegister::class)
        ->name('school.admin.school.student.registration')
        ->middleware('school_admin');

    Route::view('profile', 'profile')->name('profile');
});

require __DIR__ . '/auth.php';
