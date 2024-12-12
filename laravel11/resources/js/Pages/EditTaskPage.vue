<template>
  <div>
    <Navbar />
 
  <div class="container">

    <h1>Modifier la tâche</h1>

    <!-- Formulaire de modification de la tâche -->
    <form @submit.prevent="submitForm">
      <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
        <input
          type="text"
          id="title"
          v-model="form.title"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
          :class="{'border-red-500': errors.title}"
        />
        <p v-if="errors.title" class="text-red-500 text-sm">{{ errors.title }}</p>
      </div>

      <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea
          id="description"
          v-model="form.description"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
          :class="{'border-red-500': errors.description}"
        ></textarea>
        <p v-if="errors.description" class="text-red-500 text-sm">{{ errors.description }}</p>
      </div>

      <div class="mb-4">
        <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
        <select
          id="status"
          v-model="form.status"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
          :class="{'border-red-500': errors.status}"
        >
          <option value="in_progress">En cours</option>
          <option value="completed">Terminé</option>
        </select>
        <p v-if="errors.status" class="text-red-500 text-sm">{{ errors.status }}</p>
      </div>

      <div class="mb-4">
        <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
        <input
          type="text"
          id="category"
          v-model="form.category"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
          :class="{'border-red-500': errors.category}"
        />
        <p v-if="errors.category" class="text-red-500 text-sm">{{ errors.category }}</p>
      </div>

      <div class="mb-4">
        <label for="due_date" class="block text-sm font-medium text-gray-700">Date d'échéance</label>
        <input
          type="date"
          id="due_date"
          v-model="form.due_date"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
          :class="{'border-red-500': errors.due_date}"
        />
        <p v-if="errors.due_date" class="text-red-500 text-sm">{{ errors.due_date }}</p>
      </div>

      <div class="mb-4">
        <button
          type="submit"
          class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-md shadow-md"
        >
          Mettre à jour
        </button>
      </div>
    </form>
  </div>
</div>
</template>

<script setup>
import { ref } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';
import Navbar from './Navbar.vue';

const { props } = usePage();
const task = props.task;

const form = useForm({
  title: task.title,
  description: task.description,
  status: task.status,
  category: task.category,
  due_date: task.due_date,
});

const errors = ref({});

const submitForm = async () => {
  errors.value = {}; // Réinitialise les erreurs

  try {
    await form.put(`/tasks/${task.id}`); // Envoie les données au backend
    form.reset(); // Réinitialise le formulaire après la soumission réussie
    window.location.href = route('tasks.index'); // Redirige vers la liste des tâches après mise à jour
  } catch (error) {
    if (error.response && error.response.data.errors) {
      errors.value = error.response.data.errors; // Récupère les erreurs de validation
    }
  }
};
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}
</style>