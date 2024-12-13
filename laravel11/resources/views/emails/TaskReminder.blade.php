<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rappel de Tâche</title>
    <style>
        @import url('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');
    </style>
</head>
<body>
    <h1>Rappel de votre tâche</h1>
    <p>Bonjour,</p>
    <p>Voici un rappel pour la tâche suivante :</p>
    <p><strong>Titre :</strong> {{ $taskTitle }}</p>
    <p><strong>Date limite :</strong> {{ \Carbon\Carbon::parse($taskDueDate)->format('d/m/Y') }}</p>
    <p>Merci de bien vouloir la compléter avant cette date.</p>
    <p>Cordialement,</p>
    <p>L'équipe Laravel</p>
</body>
</html>
