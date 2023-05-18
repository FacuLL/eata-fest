<script setup>
    import { useForm } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import DialogModal from '../../Components/DialogModal.vue';
    import InputLabel from '../../Components/InputLabel.vue';
    import TextInput from '../../Components/TextInput.vue';
    import PrimaryButton from '../../Components/PrimaryButton.vue';
    import SecondaryButton from '../../Components/SecondaryButton.vue';
    import DangerButton from '../../Components/DangerButton.vue';


    const gameForm = useForm({
        name: '',
        logo_id: 0
    });
</script>

<script>
export default {
    data() {
        return {
            search: "",
            gameLogo: 0,
            showGameModal: false,
            showMessageModal: false,
            showSuccessModal: true,
            userGameSelection: null,
            gameDeleteModal: null
        };
    },
    methods: {
        changeSearch(text) {
            this.search = text;
        },
        makeRequest() {
            let url = "/admin/dashboard";
            if (this.search.length > 3)
                url += ("?name=" + this.search);
            this.$inertia.get(url);
        },
        userSearch(text) {
            if (text.length <= 3)
                return;
            this.makeRequest();
        },
        createGame(form) {
            this.showGameModal = false;
            form.transform(data => ({
                ...data,
                logo_id: this.gameLogo
            })).post(route('admin-game'));
        },
        handleGameClick(gameid) {
            if (!this.userGameSelection) return this.gameDeleteModal = gameid;
            return this.userGameAttach(gameid);
        },
        userGameAttach(gameid) {
            this.$inertia.post('user-game', { game: gameid, user: this.userGameSelection });
        },
        deleteGameAttach(userid, gameid) {
            this.$inertia.delete(`user-game?user=${userid}&game=${gameid}`);
        },
        deleteGame(gameid) {
            this.gameDeleteModal = null;
            this.$inertia.delete(`game?id=${gameid}`);
        }
    },
    props: {
        users: Array,
        games: Array,
    },
    components: { DialogModal, InputLabel, TextInput, PrimaryButton, SecondaryButton, DangerButton }
}
</script>

<template>
    <DialogModal :show="this.gameDeleteModal">
        <template #title>
            <h1 class="text-center dark:text-gray-200 mt-3">¿Seguro/a que querés borrar el juego?</h1>
            <div class="mt-5 flex justify-center">
                <DangerButton class="mr-3" @click="deleteGame(this.gameDeleteModal)">Borrar</DangerButton>
                <PrimaryButton @click="this.gameDeleteModal = null">Cancelar</PrimaryButton>
            </div>
        </template>
    </DialogModal>
    <DialogModal :show="$page.props.flash.success && this.showSuccessModal">
        <template #title>
            <div class="flex justify-end">
                <button @click="this.showSuccessModal = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M18 6l-12 12"></path>
                        <path d="M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <h1 class="text-center dark:text-gray-200">{{ $page.props.flash.success }}</h1>
            <div class="flex justify-center mt-3">
                <PrimaryButton @click="this.showSuccessModal = null">Ok</PrimaryButton>
            </div>
        </template>
    </DialogModal>
    <DialogModal :show="this.showGameModal">
        <template #title>
            <div class="flex justify-end">
                <button @click="this.showGameModal = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M18 6l-12 12"></path>
                        <path d="M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="flex justify-center content-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-1 mr-3 scale-150" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M2 6m0 2a2 2 0 0 1 2 -2h16a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-16a2 2 0 0 1 -2 -2z"></path>
                    <path d="M6 12h4m-2 -2v4"></path>
                    <path d="M15 11l0 .01"></path>
                    <path d="M18 13l0 .01"></path>
                </svg>
                <h1 class="dark:text-gray-200 text-2xl inline-block">Crear juego</h1>
            </div>
        </template>
        <template #content>
            <form @submit.prevent="createGame(gameForm)">
                <div>
                    <InputLabel for="name" value="Nombre" />
                    <TextInput
                        id="name"
                        v-model="gameForm.name"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="game-name"
                    />
                </div>
                <div class="grid sm:grid-cols-5 gap-4 mt-4 grid-cols-4">
                    <div @click="this.gameLogo = index-1" :class="gameLogo == (index-1) ? 'outline outline-2 outline-red-500' : ''" class="dark:bg-gray-700 bg-gray-300 sm:h-20 h-14 flex justify-center content-center rounded-lg" v-for="index in 38" :key="index">
                        <img class="dark:invert" :src="'/logos/'+(index-1)+'.svg'" />
                    </div>
                </div>
                <div class="flex justify-center mt-4">
                    <PrimaryButton :class="{ 'opacity-25': gameForm.processing }" :disabled="gameForm.processing">Crear juego</PrimaryButton>
                </div>
            </form>
        </template>
    </DialogModal>
    <AppLayout title="Dashboard" user_type="{{ $page.props.user_type  }}">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Administración
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-gray-300 dark:bg-gray-700 p-5 rounded-lg">
                    <h2 class="text-2xl dark:text-gray-200">Buscar organizadores</h2>
                    <div class="grid grid-cols-1 mt-3">
                        <input @keydown.enter="userSearch(this.search)" @input="event => changeSearch(event.target.value)" type="text" name="user_name" placeholder="Ingrese nombre del organizador" id="user_name" class="rounded-lg dark:bg-gray-800 dark:border-gray-800">
                    </div>
                    <div class="grid grid-cols-1 px-20 mt-5" v-if="users.length <= 0">
                        <h1 class="text-center dark:text-gray-300" v-if="search.length <= 3">Ingrese algunos caractetes</h1>
                        <h1 class="text-center dark:text-gray-300" v-if="search.length > 3">Presione "Enter" para buscar</h1>
                    </div>
                    <div class="grid grid-cols-1 px-10 mt-5">
                        <div on-click="" class="bg-gray-400 dark:bg-gray-800 w-full rounded p-3" v-for="user in users"> 
                            <h1 class="dark:text-gray-200 text-center text-ellipsis overflow-hidden"> {{ user.name }} - {{ user.email }} </h1>
                            <div class="flex w-full items-center justify-center">
                                <h2 v-if="this.userGameSelection" class="dark:text-gray-400 text-xl block w-fill inline-block">Selecciona un juego abajo</h2>
                                <h2 v-else-if="user.games.length > 0" class="dark:text-gray-300 text-xl block w-fill inline-block">Juegos que organiza:</h2>
                                <h2 v-else="" class="dark:text-gray-400 text-xl block w-fill inline-block">No pertenece a ningún juego</h2>
                                <svg @click="this.userGameSelection = (this.userGameSelection == user.id) ? null : user.id" xmlns="http://www.w3.org/2000/svg" :class="this.userGameSelection ? 'rotate-45 stroke-red-700' : ''" class="ml-1 mt-0.5 stroke-violet-700 inline-block flex content-center cursor-pointer scale-100 motion-safe:hover:scale-[1.03] transition-all duration-250" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M9 12h6" />
                                    <path d="M12 9v6" />
                                    <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                                </svg>
                            </div>
                            <div class="mt-3 grid md:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-3" v-if="user.games.length > 0">
                                <div @click="$event => deleteGameAttach(user.id, game.id)" class="bg-gray-300 dark:bg-gray-700 rounded p-2 flex justify-center cursor-pointer hover:outline hover:outline-red-700 transition-all duration-250" v-for="game in user.games">
                                    <h2 class="dark:text-gray-200 text-ellipsis overflow-hidden">{{ game.name }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 bg-gray-300 dark:bg-gray-700 p-5 rounded-lg">
                    <div class="flex content-center items-center">
                        <h2 class="text-2xl dark:text-gray-200 inline-block">Juegos</h2>
                        <svg @click="this.showGameModal = true" xmlns="http://www.w3.org/2000/svg" class="ml-2 mt-0.5 stroke-violet-700 inline-block flex content-center cursor-pointer scale-100 motion-safe:hover:scale-[1.03] transition-all duration-250" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M9 12h6" />
                            <path d="M12 9v6" />
                            <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                        </svg>
                    </div>
                    <div class="grid grid-cols-1 px-20 mt-5" v-if="games?.length <= 0 || !games">
                        <h1 class="text-center dark:text-gray-300">No hay juegos</h1>
                    </div>
                    <div class="grid lg:grid-cols-5 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 px-10 mt-5 gap-3">
                        <div @click="handleGameClick(game.id)" class="group bg-gray-400 dark:bg-gray-800 rounded-lg p-4 scale-100 transition-all duration-250 motion-safe:hover:scale-[1.03] hover:outline cursor-pointer" :class="this.userGameSelection ? 'hover:outline-violet-700' : 'hover:outline-red-700'" v-for="game in games"> 
                            <h1 class="dark:text-gray-200 text-center text-2xl text-ellipsis overflow-hidden"> {{ game.name }} </h1>
                            <div class="flex w-full mt-3 h-16 items-start content-center justify-center transition-all duration-250" :class="!this.userGameSelection ? 'group-hover:ml-[-30px]' : ''">
                                <img class="h-full dark:invert" :src="'/logos/'+game.logo_id+'.svg'">
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="dark:invert scale-150 transition-all duration-250 opacity-0 absolute top-[55%] right-1/2" :class="!this.userGameSelection ? 'group-hover:right-1/4 group-hover:opacity-100' : ''"  width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
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
        </div>
    </AppLayout>
</template> 

