<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<script>
    export default {
        props: {
            games: Array
        }
    }
</script>

<template>
    <AppLayout title="Dashboard"  user_type="{{ $page.props.user_type }}">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Panel de control
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <h1 class="text-3xl text-center dark:text-gray-200">Tus juegos</h1>
                    <div class="p-3 grid lg:grid-cols-5 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-3 mt-4">
                        <div @click="$inertia.get('dashboard/game?id='+game.id)" class="group bg-gray-400 dark:bg-gray-800 rounded-lg p-4 scale-100 transition-all duration-250 motion-safe:hover:scale-[1.03] hover:outline cursor-pointer hover:outline-violet-700" v-for="game in games"> 
                            <h1 class="dark:text-gray-200 text-center text-2xl text-ellipsis overflow-hidden"> {{ game.name }} </h1>
                            <div class="flex w-full mt-3 h-16 items-start content-center justify-center transition-all duration-250">
                                <img class="h-full dark:invert" :src="'/logos/'+game.logo_id+'.svg'">
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="dark:invert scale-150 transition-all duration-250 opacity-0 absolute top-[55%] right-1/2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M4 7h16"></path>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                <path d="M10 12l4 4m0 -4l-4 4"></path>
                            </svg>
                        </div>
                    </div>
            </div>
        </div>
    </AppLayout>
</template> 
