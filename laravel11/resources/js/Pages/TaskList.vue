<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Navbar from './Navbar.vue';

const { tasks } = usePage().props;

const notifications = ref([]);
const showDeleteConfirmation = ref(false);
const taskToDelete = ref(null);

const showNotification = (message, type = 'success') => {
  notifications.value.push({ message, type });
  setTimeout(() => {
    notifications.value.shift();
  }, 5000);
};

const confirmDeleteTask = (task) => {
  showDeleteConfirmation.value = true;
  taskToDelete.value = task;
};

const deleteTask = () => {
  if (taskToDelete.value) {
    Inertia.delete(`/tasks/${taskToDelete.value.id}`).then(() => {
      showNotification('Tâche supprimée avec succès!', 'success');
      showDeleteConfirmation.value = false;
    }).catch(() => {
      showNotification('Erreur lors de la suppression de la tâche.', 'error');
      showDeleteConfirmation.value = false;
    });
  }
};

const cancelDelete = () => {
  showDeleteConfirmation.value = false;
  taskToDelete.value = null;
};

const editTask = (id) => {
  Inertia.get(`/tasks/${id}/edit`);
};
</script>

<template>
  <div class="p-6 bg-gray-100 rounded-lg">
    <Navbar />

    <div v-if="notifications.length > 0" class="fixed top-5 right-5 z-50">
      <div 
        v-for="(notification, index) in notifications" 
        :key="index" 
        :class="['p-4 rounded shadow-md', notification.type === 'error' ? 'bg-red-500 text-white' : 'bg-green-500 text-white']"
      >
        {{ notification.message }}
      </div>
    </div>

    <div v-if="showDeleteConfirmation" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white p-6 rounded shadow-lg text-center">
        <p>Êtes-vous sûr de vouloir supprimer cette tâche ?</p>
        <div class="mt-4">
          <button @click="deleteTask" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Oui</button>
          <button @click="cancelDelete" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Non</button>
        </div>
      </div>
    </div>

    <h1 class="text-2xl font-bold mb-4">Liste des Tâches</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <div 
        v-for="task in tasks" 
        :key="task.id" 
        class="bg-white p-4 rounded-lg shadow-md"
      >
        <div class="text-gray-600">ID: {{ task.id }}</div>
        <div class="font-bold">Titre: {{ task.title }}</div>
        <div class="text-gray-700 mt-1">Description: {{ task.description }}</div>
        <div class="mt-2">
          <strong>Statut:</strong>
          <span :class="task.status === 'completed' ? 'text-green-500 font-bold' : 'text-orange-500 font-bold'">
            {{ task.status }}
          </span>
        </div>
        <div class="mt-2">
          <strong>Date limite:</strong> {{ task.due_date }}
        </div>
        <div class="mt-4 flex justify-between">
          <button @click="editTask(task.id)" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Modifier</button>
          <button @click="confirmDeleteTask(task)" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Supprimer</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* You can remove the scoped styles since we are using Tailwind CSS */
</style>