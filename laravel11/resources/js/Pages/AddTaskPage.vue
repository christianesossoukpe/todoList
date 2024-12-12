<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Navbar from './Navbar.vue';

const title = ref('');
const description = ref('');
const status = ref('');
const category = ref('');
const dueDate = ref('');
const notifications = ref([]); // Variable pour les notifications

// Fonction pour afficher des notifications
const showNotification = (message, type = 'success') => {
  notifications.value.push({ message, type });
  setTimeout(() => {
    notifications.value.shift(); // Supprimer la notification après 5 secondes
  }, 5000);
};

// Fonction pour ajouter une tâche
const addTask = () => {
  if (!title.value || !description.value || !status.value || !category.value || !dueDate.value) {
    showNotification("Tous les champs doivent être remplis !", 'error');
    return;
  }

  Inertia.post('/tasks', {
    title: title.value,
    description: description.value,
    status: status.value,
    category: category.value,
    due_date: dueDate.value,
  }).then(() => {
    showNotification("Tâche ajoutée avec succès !");
  }).catch(() => {
    showNotification("Erreur lors de l'ajout de la tâche.", 'error');
  });
};
</script>

<template>
  <div class="min-h-screen bg-gradient-to-r from-sky-300 to-indigo-500"> <!-- Fond bleu clair pour toute la page -->
    <Navbar />

    <div class="max-w-md mx-auto p-6 bg-white shadow-md rounded-lg mt-14">
      <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">Ajouter une tâche</h1>

      <!-- Notifications -->
      <div v-if="notifications.length > 0" class="fixed top-5 right-5 z-50">
        <div 
          v-for="(notification, index) in notifications" 
          :key="index" 
          :class="['p-4 rounded shadow-md', notification.type === 'error' ? 'bg-red-500 text-white' : 'bg-green-500 text-white']"
        >
          {{ notification.message }}
        </div>
      </div>

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

<style scoped>
.fixed {
  position: fixed;
}
</style>
