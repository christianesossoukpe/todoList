<script setup>
// Importation des modules nécessaires
import { usePage } from '@inertiajs/vue3'; // Pour accéder aux données de la page
import { ref, computed } from 'vue'; // Importation des hooks de Vue
import { Inertia } from '@inertiajs/inertia'; // Pour gérer les requêtes Inertia
import Navbar from './Navbar.vue'; // Importation du composant Navbar

// Récupération des tâches depuis les props de la page
const { tasks } = usePage().props;

// États réactifs
const notifications = ref([]); // Pour gérer les notifications
const showDeleteConfirmation = ref(false); // Pour afficher la confirmation de suppression
const taskToDelete = ref(null); // Pour stocker la tâche à supprimer
const showEditConfirmation = ref(false); // Pour afficher la confirmation de modification
const taskToEdit = ref(null); // Pour stocker la tâche à modifier
const currentPage = ref(1); // Pour gérer la page courante
const itemsPerPage = ref(6); // Nombre de tâches par page

// États pour la recherche et le filtrage
const searchQuery = ref(''); // Pour la recherche par titre ou description
const selectedStatus = ref('all'); // Pour le filtrage par statut
const filterDueDate = ref(''); // Pour le filtrage par date limite

const showNotification = (message, type) => {
  if (type === 'success') {
    toastr.success(message, 'Succès', {
      closeButton: true,
      progressBar: true,
      positionClass: 'toast-top-right', // Positionne la notification en haut à droite
      timeOut: 5000, // Durée de la notification
    });
  } else if (type === 'error') {
    toastr.error(message, 'Erreur', {
      closeButton: true,
      progressBar: true,
      positionClass: 'toast-top-right',
      timeOut: 5000,
    });
  }
};

// Fonction pour confirmer la suppression d'une tâche
const confirmDeleteTask = (task) => {
  showDeleteConfirmation.value = true; // Affichage de la confirmation
  taskToDelete.value = task; // Stockage de la tâche à supprimer
};

// Fonction pour supprimer une tâche
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

// Fonction pour annuler la suppression
const cancelDelete = () => {
  showDeleteConfirmation.value = false;
  taskToDelete.value = null;
};

// Fonction pour éditer une tâche
const editTask = (id) => {
  showEditConfirmation.value = true;
  taskToEdit.value = id;
};

// Fonction pour confirmer l'édition d'une tâche
const confirmEditTask = () => {
  if (taskToEdit.value) {
    Inertia.get(`/tasks/${taskToEdit.value}/edit`)
      .then(() => {
        showNotification('Tâche modifiée avec succès!', 'success');
        showEditConfirmation.value = false;
        taskToEdit.value = null;
      })
      .catch(() => {
        showNotification('Erreur lors de la modification de la tâche.', 'error');
        showEditConfirmation.value = false;
      });
  }
};

// Propriété calculée pour filtrer les tâches
const filteredTasks = computed(() => {
  let filtered = tasks;

  // Filtrage par recherche
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered.filter(task =>
      task.title.toLowerCase().includes(query) ||
      task.description.toLowerCase().includes(query) ||
      task.category.toLowerCase().includes(query)
    );
  }

  // Filtrage par statut
  if (selectedStatus.value !== 'all') {
    filtered = filtered.filter(task => task.status === selectedStatus.value);
  }

  // Filtrage par date limite
  if (filterDueDate.value) {
    filtered = filtered.filter(task => task.due_date === filterDueDate.value);
  }

  // Tri des tâches de la plus récente à la plus ancienne
  filtered = filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

  return filtered;
});


// Propriété calculée pour les tâches paginées
const paginatedTasks = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value;
  return filteredTasks.value.slice(startIndex, startIndex + itemsPerPage.value);
});

// Propriété calculée pour le nombre total de pages
const totalPages = computed(() => Math.ceil(filteredTasks.value.length / itemsPerPage.value));

// Fonction pour passer à la page suivante
const nextPage = () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
  }
};

// Fonction pour revenir à la page précédente
const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};
</script>

<template>
  <div class="bg-gray-100">
    <Navbar />  
    
    <TaskReminder v-if="task" :task="task" />
    <div class="bg-gradient-to-r from-sky-300 to-indigo-500">

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

      <!-- Barre de recherche et filtres -->
      <div class="mb-4 flex flex-wrap
       items-start justify-center gap-4">
        <input
          type="text"
          v-model="searchQuery"
          class="border rounded p-2 w-full sm:w-[300px]"
          placeholder="Rechercher par titre, description ou catégorie"
        />

        <select v-model="selectedStatus" class="border rounded p-2 w-full sm:w-[300px]">
          <option value="all">Tous les statuts</option>
          <option value="in_progress">En cours</option>
          <option value="completed">Terminé</option>
        </select>

        <input
          type="date"
          v-model="filterDueDate"
          class="border rounded p-2 w-full sm:w-[300px]"
        />
      </div>

      <!-- Affichage des tâches paginées -->
      <div class="flex justify-center p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl">
          <div 
            v-for="task in paginatedTasks" 
            :key="task.id" 
            class="bg-white p-3 rounded-lg shadow-md w-72"
          >
            <!-- <div class="text-gray-600">Tâche: {{ task.id }}</div> -->
            <div class="font-bold text-lg">Titre: {{ task.title }}</div>
            <div class="text-gray-700 mt-1 text-sm">Description: {{ task.description }}</div>
            <div class="mt-2">
              <strong>Statut:</strong>
              <span :class="task.status === 'completed' ? 'text-green-500 font-bold' : 'text-orange-500 font-bold'">
                {{ task.status }}
              </span>
            </div>
            <div class="mt-2">
              <strong>Catégorie:</strong> {{ task.category }}
            </div>
            <div class="mt-2">
              <strong>Date limite:</strong> {{ task.due_date }}
            </div>
            <div class="mt-4 flex justify-between">
              <button @click="editTask(task.id)" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Modifier</button>
              <button @click="confirmDeleteTask(task)" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Supprimer</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Navigation de pagination -->
      <div class="mt-6 flex justify-center space-x-4">
        <button @click="previousPage" :disabled="currentPage === 1" 
          class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 mt-4 disabled:opacity-50">Précédent</button>
        <span class="mt-6">Page {{ currentPage }} sur {{ totalPages }}</span>
        <button @click="nextPage" :disabled="currentPage === totalPages" 
          class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 mt-4 disabled:opacity-50">Suivant</button>
      </div>

      <!-- Confirmation de suppression -->
      <div v-if="showDeleteConfirmation" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded shadow-lg text-center">
          <p>Êtes-vous sûr de vouloir supprimer cette tâche ?</p>
          <div class="mt-4">
            <button @click="deleteTask" class="bg-green-500 mr-8 text-white px-4 py-2 rounded hover:bg-green-600">Oui</button>
            <button @click="cancelDelete" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Non</button>
          </div>
        </div>
      </div>

      <!-- Confirmation de modification -->
      <div v-if="showEditConfirmation" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded shadow-lg text-center">
          <p>Êtes-vous sûr de vouloir modifier cette tâche ?</p>
          <div class="mt-4">
            <button @click="confirmEditTask" class="bg-green-500 mr-8 text-white px-4 py-2 rounded hover:bg-green-600">Oui</button>
            <button @click="() => showEditConfirmation.value = false" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Non</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
</style>
 