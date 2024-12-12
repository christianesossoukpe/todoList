<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Navbar from './Navbar.vue';

const title = ref('');
const description = ref('');
const status = ref('');  // Ajout d'une variable pour le statut
const category = ref('');  // Ajout d'une variable pour la catégorie
const dueDate = ref('');  // Ajout d'une variable pour la date d'échéance

// Fonction pour ajouter une tâche
const addTask = () => {
  if (!title.value || !description.value || !status.value || !category.value || !dueDate.value) {
    alert("Tous les champs doivent être remplis !");
    return;
  }

  Inertia.post('/tasks', {
    title: title.value, 
    description: description.value,
    status: status.value,  // Envoyer le statut avec la requête
    category: category.value,  // Envoyer la catégorie avec la requête
    due_date: dueDate.value,  // Envoyer la date d'échéance avec la requête
  });
  Inertia.visit('/tasks');
};
</script>

<template>
  <div>
    <Navbar />

    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
      <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">Ajouter une tâche</h1>
      
      <!-- Formulaire d'ajout de tâche -->
      <form @submit.prevent="addTask">
        <div class="mb-4">
          <label for="title" class="block text-gray-700 font-medium mb-2">Titre de la tâche</label>
          <input
            v-model="title"
            id="title"
            type="text"
            required
            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>

        <div class="mb-4">
          <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
          <textarea
            v-model="description"
            id="description"
            required
            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            rows="4"
          ></textarea>
        </div>

        <div class="mb-4">
          <label for="status" class="block text-gray-700 font-medium mb-2">Statut</label>
          <select
            v-model="status"
            id="status"
            required
            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="" disabled selected>Choisir un statut</option>
            <option value="in_progress">En cours</option>
            <option value="completed">Terminé</option>
          </select>
        </div>

        <div class="mb-4">
          <label for="category" class="block text-gray-700 font-medium mb-2">Catégorie</label>
          <select
            v-model="category"
            id="category"
            required
            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            <option value="work">Travail</option>
            <option value="personal">Personnel</option>
            <option value="urgent">Urgent</option>
            <option value="low_priority">Priorité faible</option>
          </select>
        </div>

        <div class="mb-4">
          <label for="dueDate" class="block text-gray-700 font-medium mb-2">Date d'échéance</label>
          <input
            v-model="dueDate"
            id="dueDate"
            type="date"
            required
            class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>

        <button
          type="submit"
          class="w-full py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          Ajouter
        </button>
      </form>
    </div>
  </div>
</template>
