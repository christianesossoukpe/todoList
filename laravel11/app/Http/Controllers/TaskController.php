<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers;

use App\Console\Commands\SendTaskReminders;
use App\Mail\TaskCreated;
use App\Mail\TaskReminder;
use App\Models\Task;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importation de la façade Auth
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskCreated as TaskCreatedMail;

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
    // Vérification de l'authentification
    if (!Auth::check()) {
        return redirect()->route('login')->withErrors('Vous devez être connecté pour créer une tâche.');
    }

    // Validation des données
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|string|in:in_progress,completed',
        'category' => 'required|in:work,personal,urgent,low_priority',
        'due_date' => 'required|date',
    ]);

    // Création de la tâche avec l'ID de l'utilisateur authentifié
    $task = Task::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'status' => $validated['status'],
        'category' => $validated['category'],
        'due_date' => $validated['due_date'],
        'user_id' => Auth::id(),
    ]);

    // Déclencher l'événement
    event(new TaskCreated($task));

    // Envoyer l'e-mail
    Mail::to(Auth::user()->email)->send(new TaskCreatedMail($task));

    // Retour à la page des tâches après l'ajout avec message de succès
    return redirect()->route('tasks.index')->with('message', 'Tâche créée avec succès!');
}
    // Supprimer une tâche

    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        // Vérification que l'utilisateur authentifié est celui qui a créé la tâche
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->withErrors('Vous n\'êtes pas autorisé à supprimer cette tâche.');
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('message', 'Tâche supprimée avec succès!');
    }

    // Afficher la page d'édition
    public function edit($id)
    {
        $task = Task::findOrFail($id);
    
        // Vérification que l'utilisateur authentifié est celui qui a créé la tâche
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->withErrors('Vous n\'êtes pas autorisé à modifier cette tâche.');
        }
    
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
    
        // Vérification que l'utilisateur authentifié est celui qui a créé la tâche
        if ($task->user_id !== Auth::id()) {
            return redirect()->route('tasks.index')->withErrors('Vous n\'êtes pas autorisé à modifier cette tâche.');
        }
    
        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'category' => $validated['category'],
            'due_date' => $validated['due_date'],
        ]);
    
        return redirect()->route('tasks.index')->with('message', 'Tâche mise à jour avec succès!');
    }
 

  
    public function sendReminder($taskId)
    {
        // Exemple d'envoi d'un email avec Mailtrap
        $task = Task::find($taskId);
        
        // Envoi du mail
        Mail::to('recipient@example.com')->send(new TaskReminder($task));

        return response()->json(['message' => 'Rappel envoyé!']);
    }
    

}