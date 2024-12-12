<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Navbar from './Navbar.vue';

const { tasks } = usePage().props;

const notifications = ref([]);
const showDeleteConfirmation = ref(false);
const taskToDelete = ref(null);
const showEditConfirmation = ref(false);
const taskToEdit = ref(null);
const currentPage = ref(1);
const itemsPerPage = 8; // Nombre de tâches par page

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
      taskToDelete.value = null;
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
  showEditConfirmation.value = true;
  taskToEdit.value = id;
};

const confirmEditTask = () => {
  if (taskToEdit.value) {
    Inertia.get(`/tasks/${taskToEdit.value}/edit`).then(() => {
      showNotification('Tâche modifiée avec succès!', 'success');
      showEditConfirmation.value = false;
      taskToEdit.value = null;
    }).catch(() => {
      showNotification('Erreur lors de la modification de la tâche.', 'error');
      showEditConfirmation.value = false;
    });
  }
};

const paginatedTasks = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage;
  return tasks.slice(startIndex, startIndex + itemsPerPage);
});

const totalPages = computed(() => Math.ceil(tasks.length / itemsPerPage));

const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};
</script>

<template>
  <div class="p-6 bg-gray-100 rounded-lg">
    <Navbar />

    <div v-if="notifications.length > 0" class="fixed top-5 right-5 z-50">
      <div 
        v-for="(notification, index) in notifications" 
        :key="index" 
        :class="['p-4 rounded shadow-md', notification.type === 'error' ? 'bg-red-500 text-white' : notification.type === 'info' ? 'bg-blue-500 text-white' : 'bg-green-500 text-white']"
      >
        {{ notification.message }}
      </div>
    </div>

    <h1 class="text-2xl font-bold mb-4 text-center">Liste des Tâches</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6
    w-[1400px]  h-[700px] ml-[200px] mr-[100px] ">
      <div 
        v-for="task in paginatedTasks" 
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
          <strong>Catégorie:</strong> {{ task.category }} <!-- Ajout de la catégorie ici -->
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

    <div class="mt-6 flex justify-center space-x-4">
      <button @click="previousPage" :disabled="currentPage === 1" 
      class="bg-gray-300 text-gray-700 px-4 py-2 rounded
       hover:bg-gray-400 mt-4 disabled:opacity-50">Précédent</button>
      <span class="mt-6">Page {{ currentPage }} sur {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" 
      class="bg-gray-300 text-gray-700 px-4
       py-2 rounded hover:bg-gray-400 mt-4 disabled:opacity-50">Suivant</button>
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

    <div v-if="showEditConfirmation" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white p-6 rounded shadow-lg text-center">
        <p>Êtes-vous sûr de vouloir modifier cette tâche ?</p>
        <div class="mt-4">
          <button @click="confirmEditTask" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Oui</button>
          <button @click="() => showEditConfirmation.value = false" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Non</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
</style>
