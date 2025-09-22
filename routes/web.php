<?php


use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Pages\{
    Dashboard,
    Users,
    Schools,
    RolesPermissions,
    YearManager,
};
use App\Livewire\Admin\Pages\School\{
    Affective,
    AttendanceRegister,
    ClassManager,
    Department,
    DepartmentSubjects,
    Grade,
    GradeKeys,
    MakeClassTeacher,
    ManageWeeks,
    ResultEntry,
      School,
      ResultSettingsManager,
    SetWeeks,
    StudentRegister,
    TeacherLessonNote,
    TeacherPayments,
    TeacherRegister,
    TeacherSalary,
    TeacherSubjects,
   Subject,
   PhyscomotorDomain,
   StudentResultInfo
};


// Public
Route::view('/', 'welcome');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // Super Admin
    Route::middleware('super_admin')->group(function () {
        Route::get('/admin-users', Users::class)->name('admin-users');
        Route::get('/admin-schools', Schools::class)->name('admin-schools');
        Route::get('/admin-roles-permissions', RolesPermissions::class)->name('admin-roles-permissions');
        Route::get('/admin-session-manager', YearManager::class)->name('admin-session-manager');
    });

    // School Admin
    Route::prefix('school/admin/school')->middleware('school_admin')->group(function () {
        Route::get('/', School::class)->name('school.admin.school');
        Route::get('/department', Department::class)->name('school.admin.school.department');
        Route::get('/subject', Subject::class)->name('school.admin.school.subject');
        Route::get('/department/subjects', DepartmentSubjects::class)->name('school.admin.school.department.subjects');
        Route::get('/classes', ClassManager::class)->name('school.admin.school.classes');
        Route::get('/results', ResultEntry::class)->name('school.admin.school.results');
        Route::get('/results-settings', ResultSettingsManager::class)->name('school.admin.school.results-settings');
        Route::get('/school-grades', Grade::class)->name('school.admin.school.grades');
        Route::get('/school-grades-keys', GradeKeys::class)->name('school.admin.school.grades-keys');
        Route::get('/school-affective', Affective::class)->name('school.admin.school.affective');
        Route::get('/school-psychomotor', PhyscomotorDomain::class)->name('school.admin.school.psychomotor');
        Route::get('/school-result-info', StudentResultInfo::class)->name('school.admin.school.result-info');
        // Teachers
        Route::prefix('teacher')->group(function () {
            Route::get('/registration', TeacherRegister::class)->name('school.admin.school.teacher.registration');
            Route::get('/class-teacher', MakeClassTeacher::class)->name('school.admin.school.teacher.class');
            Route::get('/salary', TeacherSalary::class)->name('school.admin.school.teacher.salary');
            Route::get('/payment', TeacherPayments::class)->name('school.admin.school.teacher.payment');
            Route::get('/lesson-note', TeacherLessonNote::class)->name('school.admin.school.teacher.lesson-note');
            Route::get('/subjects', TeacherSubjects::class)->name('school.admin.school.teacher.subjects');
            Route::get('/results', ResultEntry::class)->name('school.admin.school.teacher.results');
            Route::get('/results-settings', ResultSettingsManager::class)->name('school.admin.school.teacher.results-settings');
        });

        // Students
        Route::prefix('student')->group(function () {
            Route::get('/registration', StudentRegister::class)->name('school.admin.school.student.registration');
            Route::get('/register', StudentRegister::class)->name('school.admin.school.student.register');
            Route::get('/attendance', AttendanceRegister::class)
                ->name('school.admin.school.student.attendance')
                ->middleware('school_admin_or_teacher');
        });


        //Class-teacher
          Route::prefix('class-teacher')->group(function () {
                  Route::get('/school-class-teacher-result-info', StudentResultInfo::class)->name('school.admin.school.class.teacher.result-info');
            Route::get('/attendance', AttendanceRegister::class)
                  ->name('school.admin.school.class.teacher.attendance')
                  ->middleware('class_teacher');
          });

        // Weeks
        Route::get('/manage-weeks', ManageWeeks::class)->name('school.admin.school.manage-weeks');
        Route::get('/weeks', SetWeeks::class)->name('school.admin.school.weeks');


    });






    // Profile
    Route::view('profile', 'profile')->name('profile');
});

require __DIR__ . '/auth.php';
