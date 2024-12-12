<?php
 
 namespace App\Http\Controllers;

 use App\Models\Task;
 use Inertia\Inertia;
 use Illuminate\Http\Request;
 
 class TaskController extends Controller
 {
     public function index()
     {
         $tasks = Task::all(); // Récupère toutes les tâches
         return Inertia::render('TaskList', [
             'tasks' => $tasks
         ]);
     }
 
     public function create()
     {
         return Inertia::render('AddTaskPage');
     }
     public function store(Request $request)
     {
         $validated = $request->validate([
             'title' => 'required|string|max:255',
             'description' => 'required|string',
             'status' => 'required|string|in:pending,in_progress,completed', // Validation du statut
             'category' => 'required|string|max:255', // Validation de la catégorie
             'due_date' => 'required|date', // Validation de la date d'échéance
         ]);
     
         Task::create([
             'title' => $validated['title'],
             'description' => $validated['description'],
             'status' => $validated['status'],
             'category' => $validated['category'],
             'due_date' => $validated['due_date'],
         ]);
     
         return redirect()->route('tasks.index');
     }
     
     
     
 }
 