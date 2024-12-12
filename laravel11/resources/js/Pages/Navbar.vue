<script setup>
import { Inertia } from '@inertiajs/inertia';
</script>

<template>
  <nav class="bg-blue-600 p-4">
    <div class="container mx-auto flex justify-between items-center">
      <!-- Logo ou titre à gauche -->
      <h1 class="text-white text-2xl font-semibold">Ma Todo List</h1>

      <!-- Liste des liens de navigation -->
      <ul class="flex space-x-6">
        <li>
          <button
            @click="Inertia.visit('/tasks')"
            class="text-white hover:text-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            Liste des Tâches
          </button>
        </li>
        <li>
          <button
            @click="Inertia.visit('/tasks/create')"
            class="text-white hover:text-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            Ajouter une tâche
          </button>
        </li>
      </ul>
    </div>
  </nav>
</template>

<style scoped>
/* Vous pouvez ajouter des styles personnalisés ici si nécessaire */
</style>
