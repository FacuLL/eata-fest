<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '../Components/TextInput.vue';
import InputLabel from '../Components/InputLabel.vue';
import InputError from '../Components/InputError.vue';
import PrimaryButton from '../Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    points: '0'
});

function addPoints(game, participant) {
    form.transform(data => ({
        ...data,
        game: game.id,
        participant: participant.id
    })).post(`/dashboard/transaction`, {});
}

</script>

<script>
    export default {
    data() {
        return {
            participantid: null,
            points: 0,
        };
    },
    props: {
        game: Object,
        participant: Object,
        error: String
    },
    methods: {
        searchUser: function () {
            this.$inertia.get(`/dashboard/game?id=${this.game.id}&participant=${this.participantid}`);
        }
    },
    components: { TextInput, InputLabel, InputError, PrimaryButton }
}
</script>

<template>
    <AppLayout title="Game"  user_type="{{ $page.props.user_type }}">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="text-gray-500 text-center text-xl">Juego:</h2>
                <h1 class="text-3xl text-center dark:text-gray-200">{{ this.game.name }}</h1>
                <div class="dark:bg-gray-800 rounded p-3 mt-3">
                    <h3 class="text-gray-500 text-xl text-center mb-3">Sumar puntos</h3>
                    <div class="w-full sm:px-10 px-0">
                        <form @submit.prevent="searchUser()" class="w-full">
                            <InputLabel for="userid" value="Código del participante" />
                            <div class="flex items-center">
                                <TextInput
                                    id="userid"
                                    v-model="this.participantid"
                                    type="number"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                />
                                <PrimaryButton class="ml-3 h-10" @click="searchUser()">Buscar</PrimaryButton>
                            </div>
                            <InputError class="mt-2" :message="error" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" v-if="participant">
                <div class="dark:bg-gray-800 rounded p-3 mt-5">
                    <h3 class="dark:text-gray-200 text-xl text-center mb-3"><span class="text-red-400">{{ participant.name }}</span> - Código: <span class="text-yellow-500">{{ participant.id }}</span></h3>
                    <div class="w-full sm:px-10 px-0">
                        <form @submit.prevent="addPoints(game, participant)" class="w-full">
                            <InputLabel for="points" value="Cantidad de puntos" />
                            <div class="flex items-center">
                                <TextInput
                                    id="points"
                                    v-model="form.points"
                                    type="number"
                                    class="mt-1 block w-full"
                                    required
                                    autofocus
                                />
                                <PrimaryButton class="ml-3 h-10 !bg-blue-400" @click="addPoints(game, participant)">Sumar</PrimaryButton>
                            </div>
                            <InputError class="mt-2" :message="form.errors.points" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="flex w-full justify-center">
                <div class="max-w-6xl mx-auto sm:mx-6 sm:px-6 lg:px-8 mt-5 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex md:flex-row flex-col items-center justify-center">
                <div>
                    <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 stroke-red-500" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M8 8a3.5 3 0 0 1 3.5 -3h1a3.5 3 0 0 1 3.5 3a3 3 0 0 1 -2 3a3 4 0 0 0 -2 4"></path>
                            <path d="M12 19l0 .01"></path>
                        </svg>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6 md:inline-block hidden">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                </svg>
                <p class="text-lg md:w-1/3 md:mt-0 mt-4 dark:text-gray-200">Ingresá el código del participante para sumarle puntos en este juego</p>
            </div>
            </div>
        </div>
    </AppLayout>
</template> 