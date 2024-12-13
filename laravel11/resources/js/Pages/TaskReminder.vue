<template>
    <div>
      <h1>Rappel de Tâche</h1>
      <p>Bonjour,</p>
      <p>
        Vous avez une tâche intitulée "<strong>{{ task.title }}</strong>" qui est due le 
        <strong>{{ formatDate(task.due_date) }}</strong>.
      </p>
      <p>Merci de la prendre en compte.</p>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const props = defineProps({
    task: Object
  });
  
  const formatDate = (date) => {
    return new Date(date).toLocaleDateString('fr-FR', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric'
    });
  };
  </script>
  
  <style scoped>
  h1 {
    color: #4A90E2;
  }
  </style>