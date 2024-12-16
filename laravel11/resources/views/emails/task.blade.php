<!DOCTYPE html>
<html>
<head>
    <title>Nouvelle tâche créée</title>
</head>
<body>
    <h1>Une nouvelle tâche a été créée</h1>
    <p>Titre : {{ $task->title }}</p>
    <p>Description : {{ $task->description }}</p>
    <p>Statut : {{ $task->status }}</p>
    <p>Catégorie : {{ $task->category }}</p>
    <p>Date d'échéance : {{ $task->due_date }}</p>
    <p>Veuillez terminé cette tâche avant la date d'échéance!
</body>
</html>
