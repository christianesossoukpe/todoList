<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

import TaskList from './TaskList.vue';
</script>

<template>
    <Head />
   

    <div class="bg-gradient-to-r from-sky-300 to-indigo-500 text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
         
            <div class="flex flex-col items-center">
                        <h1 class="text-3xl font-bold   text-white">Welcome to our application!</h1>
                        <p class="mt-2 text-lg   text-white">
                            Get started by signing up or logging in to access exclusive features.
                        </p>
                    

            <div class="relative w-full max-w-2xl px-6 ml-80 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-center lg:justify-end"> <!-- Centrer sur mobile -->
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-3 py-2 mr-8
                             bg-[violet] text-white  ring-1 ring-transparent transition hover:text-black/70 hover:bg-gray-200 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:hover:bg-gray-700 dark:focus-visible:ring-white"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2  mr-8 bg-slate-500
                                 text-white ring-1 ring-transparent transition
                                  hover:text-black/70 hover:bg-gray-200 focus:outline-none
                                   focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:hover:bg-gray-700 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 bg-slate-500 text-black ring-1 ring-transparent transition hover:text-black/70 hover:bg-gray-200 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:hover:bg-gray-700 dark:focus-visible:ring-white"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-10 text-center"> <!-- Centré le contenu -->
                    
                     
                </main>
            </div>
        </div>
        </div>
    </div>
</template>