<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ApplicationLogo from '../../Components/ApplicationLogo.vue';
import DialogModal from '../../Components/DialogModal.vue';

const form = useForm({
    name: '',
    dni: null,
    grade: 1,
});

const submit = () => {
    form.post(route('participant-create'));
};
</script>

<script>
    export default {
        data() { 
            return {
                showCodeModal: false,
                dni: null
            }
        },
        methods: {
            searchCode: function () {
                console.log(this.dni);
                if (!this.dni) return;
                this.$inertia.get('/participant/code' + "?dni=" + this.dni);
            }
        }
    }
</script>

<template>
    <Head title="Register" />

    <DialogModal :show="this.showCodeModal">
        <template #title>
            <div class="flex justify-end">
                <button @click="this.showCodeModal = false">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M18 6l-12 12"></path>
                        <path d="M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <p class="text-lg dark:text-gray-300 text-center">Ingresa tu DNI y revisá tu código en caso de haberlo perdido</p>
        </template>
        <template #content>
            <div class="flex justify-center mt-3">
                <form @submit.prevent="searchCode()" class="w-full">
                    <InputLabel for="dni2" value="DNI" />
                    <TextInput
                        id="dni2"
                        v-model="this.dni"
                        type="text"
                        class="mt-1 block w-full"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <div class="flex w-full justify-center mt-4">
                        <PrimaryButton>Buscar</PrimaryButton>
                    </div>
                </form>
            </div>
        </template>
    </DialogModal>

    <AuthenticationCard>
        <template #logo>
            <div class="flex flex-row items-center">
                <ApplicationLogo class="block h-20 w-auto" />
                <h1 class="ml-5 text-3xl text-gray-800 dark:text-gray-300">Registrate como participante</h1>
            </div>
        </template>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Nombre y apellido" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="dni" value="DNI" />
                <TextInput
                    id="dni"
                    v-model="form.dni"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.dni" />
            </div>

            <div class="mt-4">
                <InputLabel for="grade" value="Año" />
                <select id="grade" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" v-model="form.grade">
                    <option value="1">1ro</option>
                    <option value="2">2do</option>
                    <option value="3">3ro</option>
                    <option value="4">4to</option>
                    <option value="5">5to</option>
                    <option value="6">6to</option>
                    <option value="7">7mo</option>
                </select>
                <InputError class="mt-2" :message="form.errors.grade" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <p @click="this.showCodeModal = true" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    ¿Olvidaste tu número de identificación?
                </p>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrarse
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
