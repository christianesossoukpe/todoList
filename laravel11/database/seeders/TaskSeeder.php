<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   
     public function run()
     {
         $faker = Faker::create();
 
         // Vérifiez qu'il existe un utilisateur dans la table `users`
         $user = User::first();  // Récupère le premier utilisateur existant dans la table
 
         // Si aucun utilisateur n'existe, créez un utilisateur par défaut
         if (!$user) {
             $user = User::create([
                 'name' => 'Default User',
                 'email' => 'default@example.com',
                 'password' => bcrypt('password'),
             ]);
         }
 
         // Création de 10 tâches associées à l'utilisateur
         foreach (range(1, 10) as $index) {
             Task::create([
                 'title' => $faker->sentence,
                 'description' => $faker->paragraph,
                 'status' => $faker->randomElement(['in_progress', 'completed']),
                 'category' => $faker->randomElement(['work', 'personal', 'urgent', 'low_priority']),
                 'due_date' => $faker->date,
                 'user_id' => $user->id,  // Associe l'utilisateur récupéré ou créé
             ]);
         }
     }
    }
