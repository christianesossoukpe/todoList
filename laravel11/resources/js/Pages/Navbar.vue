<script setup>
import { Inertia } from '@inertiajs/inertia';
</script>

<template>
  <nav class="bg-white p-2">
    <div class="container mx-auto flex justify-between items-center">
      <!-- Logo ou titre à gauche -->
      <h1 class="text-dark text-2xl font-semibold">Ma Todo List</h1>

      <!-- Liste des liens de navigation -->
      <ul class="flex space-x-6">
        <li>
          <button
            @click="Inertia.visit('/')"
            class="text-dark hover:text-blue-600 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
       Accueil
          </button>
        </li>
        <li>
          <button
            @click="Inertia.visit('/tasks')"
            class="text-dark hover:text-blue-600 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            Liste des Tâches
          </button>
        </li>
        <li>
          <button
            @click="Inertia.visit('/tasks/create')"
            class="text-dark hover:text-blue-600 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            Ajouter une tâche
          </button>
        </li>
        <li>
          <button
            @click="Inertia.visit('/dashboard')"
            class="text-dark hover:text-blue-600 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
           Dashboard
          </button>
        </li>
        <li>
          <button
            @click="Inertia.visit('/dashboard')"
            class="text-dark hover:text-blue-600 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
           Deconnexion
          </button>
        </li>
      </ul>
    </div>
  </nav>
</template>

<style scoped>
</style>
