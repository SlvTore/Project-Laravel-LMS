<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\CategoryController;
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
