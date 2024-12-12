<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Afficher toutes les tâches
    public function index()
    {
        $tasks = Task::all(); // Récupère toutes les tâches
        return Inertia::render('TaskList', [
            'tasks' => $tasks
        ]);
    }

    // Afficher la page de création de tâche
    public function create()
    {
        return Inertia::render('AddTaskPage');
    }

    // Enregistrer une nouvelle tâche
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:in_progress,completed', // Validation du statut
            'category' => 'required|in:work,personal,urgent,low_priority',  // Validation des catégories
            'due_date' => 'required|date', // Validation de la date d'échéance
        ]);
    
        Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'category' => $validated['category'],
            'due_date' => $validated['due_date'],
        ]);
    
        // Retour à la page des tâches après l'ajout
        return redirect()->route('tasks.index');
    }

    // Supprimer une tâche
    public function destroy($id)
    {
        Task::destroy($id);
        return redirect()->route('tasks.index')->with('message', 'Tâche supprimée avec succès!');
    }

    // Afficher la page d'édition
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return Inertia::render('EditTaskPage', [
            'task' => $task
        ]);
    }

    // Mettre à jour une tâche
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|in:in_progress,completed', 
            'category' => 'required|string|max:255',
            'due_date' => 'required|date',
        ]);

        $task = Task::findOrFail($id);
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
