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
     
     public function destroy($id)
     {
         // Logique pour supprimer la tâche
         Task::destroy($id);
     
         // Redirection avec un message flash
         return redirect()->route('tasks.index')->with('message', 'Tâche supprimée avec succès!');
     }
      
     public function edit($id)
     {
         $task = Task::findOrFail($id); // Récupère la tâche à modifier
         return Inertia::render('EditTaskPage', [
             'task' => $task
         ]);
     }

         // Méthode pour mettre à jour la tâche
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:pending,in_progress,completed', // Validation du statut
            'category' => 'required|string|max:255', // Validation de la catégorie
            'due_date' => 'required|date', // Validation de la date d'échéance
        ]);

        $task = Task::findOrFail($id); // Récupère la tâche à mettre à jour
        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'category' => $validated['category'],
            'due_date' => $validated['due_date'],
        ]);

        return redirect()->route('tasks.index');
    }
 }
 