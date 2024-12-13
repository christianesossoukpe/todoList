<!DOCTYPE html>
<html>
<head>
    <title>Rappel de Tâche</title>
</head>
<body>
    <h1>Rappel de Tâche</h1>
    <p>Bonjour,</p>
    <p>Vous avez une tâche intitulée "<strong>{{ $task->title }}</strong>" qui est due le <strong>{{ $task->due_date->format('d/m/Y') }}</strong>.</p>
    <p>Merci de la prendre en compte.</p>
</body>
</html>