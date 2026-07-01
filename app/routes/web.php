<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\CourseController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'Index'])->name('index');

Route::get('/dashboard', function () {
    return view('frontend.dashboard.main');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
//Admin Role
Route::middleware(['auth', 'roles:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.index');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/reset-password', [AdminController::class, 'AdminResetPassword'])->name('admin.reset.password');
    Route::post('/admin/reset-password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');

        //Category All Route
        Route::controller(CategoryController::class)->group(function(){
            Route::get('/all/category', 'AllCategory')->name('all.category');
            Route::get('/add/category', 'AddCategory')->name('add.category');
            Route::post('/store/category', 'StoreCategory')->name('store.category');
            Route::get('/edit/category/{id}', 'EditCategory')->name('edit.category');
            Route::get('/delete/category/{id}', 'DeleteCategory')->name('delete.category');
        });
        //SubCategory All Route
        Route::controller(CategoryController::class)->group(function(){
            Route::get('/all/subcategory', 'AllSubCategory')->name('all.subcategory');
            Route::get('/add/subcategory', 'AddSubCategory')->name('add.subcategory');
            Route::post('/store/subcategory', 'StoreSubCategory')->name('store.subcategory');
            Route::get('/edit/subcategory/{id}', 'EditSubCategory')->name('edit.subcategory');
            Route::put('/update/subcategory/{id}', 'UpdateSubCategory')->name('update.subcategory');
            Route::get('/delete/subcategory/{id}', 'DeleteSubCategory')->name('delete.subcategory');
        });
        //Instructor Management
        Route::controller(AdminController::class)->group(function(){
            Route::get('/all/instructors', 'AllInstructor')->name('all.instructors');
            Route::post('/update/status', 'UpdateStatus')->name('update.status');
        });
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
});

Route::get('/instructor/register', [InstructorController::class, 'InstructorRegister'])->name('instructor.register');
Route::post('/instructor/register/save', [InstructorController::class, 'InstructorRegisterSave'])->name('instructor.register.save');
Route::get('/instructor/login', [InstructorController::class, 'InstructorLogin'])->name('instructor.login');
//Instructor Role
Route::middleware(['auth', 'roles:instructor'])->group(function () {
    Route::get('/instructor/dashboard', [InstructorController::class, 'InstructorDashboard'])->name('instructor.index');
    Route::get('/instructor/profile', [InstructorController::class, 'InstructorProfile'])->name('instructor.profile');
    Route::post('/instructor/profile/store', [InstructorController::class, 'InstructorProfileStore'])->name('instructor.profile.store');
    Route::get('/instructor/reset-password', [InstructorController::class, 'InstructorResetPassword'])->name('instructor.reset.password');
    Route::post('/instructor/reset-password', [InstructorController::class, 'InstructorUpdatePassword'])->name('instructor.update.password');
    Route::get('/instructor/logout', [InstructorController::class, 'InstructorLogout'])->name('instructor.logout');

    //Course Management
    Route::controller(CourseController::class)->group(function(){
            Route::get('/all/course', 'AllCourse')->name('all.course');
            Route::get('/add/course', 'AddCourse')->name('add.course');
            Route::get('/subcategory/ajax/{category_id}', 'GetSubCategory');
            Route::post('/store/course', 'StoreCourse')->name('store.course');
            Route::get('/edit/course/{id}', 'EditCourse')->name('edit.course');
            Route::put('/update/course/{id}', 'UpdateCourse')->name('update.course');
            Route::get('/delete/course/{id}', 'DeleteCourse')->name('delete.course');
    });

    // Lecture Management
    Route::controller(CourseController::class)->group(function(){
        Route::get('/add/course/lecture/{id}', 'AddCourseLecture')->name('add.course.lecture');
        Route::post('/add/course/section', 'AddCourseSection')->name('add.course.section');
        Route::post('/save-lecture', 'SaveLecture')->name('save-lecture');
        Route::get('/edit/lecture/{id}', 'EditLecture')->name('edit.lecture');
        Route::post('/update-lecture', 'UpdateLecture')->name('update.lecture');
        Route::get('/delete/lecture/{id}', 'DeleteLecture')->name('delete.lecture');
        Route::get('/delete/section/{id}', 'DeleteSection')->name('delete.section');

    });
});

Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'Index'])->name('user.index');
    Route::get('/user/profile', [UserController::class, 'UserProfile'])->name('user.profile');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::post('/user/profile/reset-password', [UserController::class, 'UserUpdatePassword'])->name('user.update.password');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');

});
// User Role


require __DIR__.'/auth.php';
