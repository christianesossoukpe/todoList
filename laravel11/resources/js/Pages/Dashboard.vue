<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from './Navbar.vue'; // Importation du composant Navbar
import { Inertia } from '@inertiajs/inertia'; // Utilisation d'Inertia pour gérer la navigation
</script>

<template>
    <!-- <Head title="Dashboard" /> -->

    <!-- Section principale avec fond de couleur et centrage -->
    <div class="min-h-screen bg-gradient-to-r from-sky-300 to-indigo-500 flex items-center justify-center">
        <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto text-center">
            <h1 class="text-3xl font-bold text-black">Bienvenue sur votre espace de tâche !</h1>
            <p class="mt-2 text-lg text-black">
                Ici, vous pouvez gérer vos tâches, consulter vos statistiques, et accéder à toutes les fonctionnalités de l'application.
            </p>
            <p class="mt-4 text-md text-black">
                Profitez de votre expérience et n'hésitez pas à explorer toutes les options disponibles pour vous aider dans votre travail.
            </p>

            <!-- Bouton pour aller vers la page des tâches avec Inertia.js -->
            <button 
                @click="Inertia.visit('/tasks')" 
                class="mt-6 px-6 py-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                Accéder à la page des tâches
            </button>
        </div>
    </div>
</template>
