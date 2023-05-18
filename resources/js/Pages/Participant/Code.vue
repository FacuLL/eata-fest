<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ApplicationLogo from '../../Components/ApplicationLogo.vue';
</script>

<script>
    export default {
        props: {
            code: String,
            success: Boolean
        }
    }
</script>

<template>
    <Head title="Código" />

    <div class="flex flex-col bg-gray-200 dark:bg-gray-900 h-screen w-screen justify-center">
        <h1 class="mb-2 text-2xl dark:text-gray-400 text-center" v-if="success">Participante creado</h1>
        <h1 class="text-3xl dark:text-gray-200 text-center">Tu código de participante es:</h1> 
        <h2 class="mt-3 text-6xl dark:text-yellow-300 text-center">{{ code }}</h2>
        <div class="mt-5">
                <div class="grid grid-cols-1 gap-6 lg:gap-8">
                    <div class="mx-10 h-32 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex items-center justify-center">
                        <div>
                            <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 stroke-red-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M8 8a3.5 3 0 0 1 3.5 -3h1a3.5 3 0 0 1 3.5 3a3 3 0 0 1 -2 3a3 4 0 0 0 -2 4"></path>
                                    <path d="M12 19l0 .01"></path>
                                </svg>
                            </div>
                        </div>
                        <h2 class="ml-5 text-xl font-semibold text-gray-900 dark:text-white">¿Cómo seguir?</h2>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                        </svg>
                        <p class="text-lg w-1/3 dark:text-gray-200">El día del el evento, recordá o anotá tu código. Cuando ganes puntos en alguna actividad, el encargado te pedirá el código para cargar el puntaje.</p>
                    </div>
                </div>
        </div>
        <div class="flex mt-4 justify-center w-full">
            <PrimaryButton @click="this.$inertia.get('/')">Volver</PrimaryButton>
        </div>
    </div>
</template>
