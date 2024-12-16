<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskReminder;
use App\Models\Task;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
 
 
// Protéger les routes des tâches avec le middleware 'auth'
Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store']);
});

Route::get('/tasks/create', [TaskController::class, 'create']);
// Route::post('/tasks', [TaskController::class, 'store']);
Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');

 
// Route::get('/send-test-email', function () {
//     Mail::raw('This is a test email', function ($message) {
//         $message->to('christdebo68@gmail.com')
//                 ->subject('Test Email');
//     });
//     return 'Test email sent!';
// });


Route::get('send/{taskId}', function ($taskId) {
    $task = Task::findOrFail($taskId);
    
    // Envoi de l'email via Mailtrap
    Mail::to('christianesossoukpe@gmail.com')->send(new TaskReminder($task));


    return 'Email de rappel envoyé!';
});
require __DIR__.'/auth.php';
