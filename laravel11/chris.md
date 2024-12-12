Projet : Gestion des tâches pour un utilisateur individuel

Une application simple qui permet à un utilisateur de gérer ses tâches quotidiennes.


---

Fonctionnalités clés

1. Authentification :

Mise en place de l'inscription et de la connexion (Laravel Breeze).



2. CRUD des tâches :

Ajouter, modifier, supprimer et afficher des tâches.

Chaque tâche contient :

Un titre

Une description

Un statut (en cours, terminé)

Une date limite




3. Filtrage :

Filtrer les tâches par statut (en cours, terminé) ou par date limite.



4. Recherche :

Barre de recherche permettant de retrouver une tâche par mot-clé (titre ou description).



5. Gestion des mails :

Envoi d’un email de rappel lorsque la date limite d’une tâche approche (par exemple, un jour avant).





---

Plan sur deux jours

Jour 1 : Mise en place de l’application et fonctionnalités principales

1. Matin :

Créer le projet Laravel.

Configurer l'authentification avec Laravel Breeze.

Configurer la base de données avec une table tasks.

Implémenter le CRUD des tâches (modèle, contrôleur, routes, et vues Blade basiques).



2. Après-midi :

Ajouter la validation des formulaires pour les champs des tâches.

Tester les opérations CRUD avec des données factices.

Préparer l’interface utilisateur avec une liste des tâches paginée.





---

Jour 2 : Fonctionnalités avancées et finalisation

1. Matin :

Ajouter une barre de recherche fonctionnelle (titre ou description).

Implémenter le filtrage des tâches par statut ou par date limite.

Personnaliser les messages de feedback (par exemple, "Tâche ajoutée avec succès").



2. Après-midi :

Ajouter l’envoi d’emails :

Configurer Mailtrap pour les tests.

Implémenter un rappel automatique (command artisan ou notifications Laravel).


Finaliser le design avec Tailwind CSS ou Bootstrap.

Effectuer des tests pour valider l’ensemble des fonctionnalités.





---

Technologies utilisées

Base de données : MySQL ou SQLite.

Authentification : Laravel Breeze.

Interface utilisateur : Blade avec Tailwind CSS ou Bootstrap.

Gestion des mails : Mailtrap pour le test local.


Ce projet est idéal pour un développeur, peut être complété en deux jours, et permet de pratiquer plusieurs aspects essentiels de Laravel. Prêt à démarrer ?

