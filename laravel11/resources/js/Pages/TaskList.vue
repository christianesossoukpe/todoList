<script setup>
import { usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import Navbar from './Navbar.vue';
const { tasks } = usePage().props; // Récupère les tâches depuis Inertia
</script>

<template>
  <div>
    <Navbar /> <!-- Navbar pour la navigation -->

    <div class="task-list">
      <h1>Liste des Tâches</h1>
      <ul>
        <li v-for="task in tasks" :key="task.id" class="task-item">
          <div class="task-id">ID: {{ task.id }}</div>
          <div class="task-title"><strong>Titre:</strong> {{ task.name }}</div>
          <div class="task-description"><strong>Description:</strong> {{ task.description }}</div>
          <div class="task-status">
            <strong>Statut:</strong> 
            <span :class="task.status === 'completed' ? 'completed' : 'pending'">
              {{ task.status }}
            </span>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped>
.task-list {
  padding: 20px;
  background-color: #f4f7fa;
  border-radius: 8px;
}

h1 {
  font-size: 2rem;
  color: #333;
  margin-bottom: 20px;
}

.task-item {
  background-color: #fff;
  padding: 15px;
  margin-bottom: 10px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.task-id {
  font-size: 1rem;
  color: #888;
}

.task-title {
  font-size: 1.2rem;
  color: #333;
}

.task-description {
  font-size: 1rem;
  color: #555;
  margin-top: 5px;
}

.task-status {
  font-size: 1rem;
  margin-top: 10px;
}

.task-status .completed {
  color: green;
  font-weight: bold;
}

.task-status .pending {
  color: orange;
  font-weight: bold;
}

.task-item:hover {
  background-color: #f9f9f9;
  cursor: pointer;
}
</style>
