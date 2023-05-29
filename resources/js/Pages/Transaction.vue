<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '../Components/TextInput.vue';
import InputLabel from '../Components/InputLabel.vue';
import InputError from '../Components/InputError.vue';
import PrimaryButton from '../Components/PrimaryButton.vue';

</script>

<script>
    export default {
    data() {
        return {
        };
    },
    props: {
        transaction: Object,
        success: Boolean,
    },
    methods: {
        goBack: function () {
            window.history.back();
        }
    },
    components: { TextInput, InputLabel, InputError, PrimaryButton }
}
</script>

<template>
    <AppLayout title="Transaction"  user_type="{{ $page.props.user_type }}">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 v-if="success" class="mb-2 text-gray-500 text-center text-xl">Transacción creada con éxito</h1>
                <h1 class="dark:text-gray-200 text-center text-3xl">Transacción N°{{ transaction.id }}</h1>
                <div class="flex w-full h-10 justify-center items-center mt-5">
                    <img class="dark:invert h-full mr-3" :src="'/logos/'+transaction.game.logo_id+'.svg'">
                    <h1 class="dark:text-gray-200 text-center text-2xl text-ellipsis overflow-hidden"> {{ transaction.game.name }} </h1>
                </div>
                <h1 class="mt-2 dark:text-gray-200 text-center text-2xl">Organizador: <span class="text-red-400">{{ transaction.user.name }}</span></h1>
                <h1 class="mt-2 dark:text-gray-200 text-center text-2xl">Participante: <span class="text-green-400">{{ transaction.participant.name }}</span> ({{ transaction.participant.id }})</h1>
                <h1 class="mt-2 dark:text-gray-200 text-center text-2xl">Puntos sumados: <span class="text-yellow-400">{{ transaction.points }}</span></h1>
                <h1 class="mt-2 dark:text-gray-200 text-center text-2xl">Puntos totales: <span class="text-orange-400">{{ transaction.participant.points }}</span></h1>
                <div class="flex w-full justify-center mt-4">
                    <PrimaryButton @click="goBack()">Volver</PrimaryButton>
                </div>
            </div>
        </div>
    </AppLayout>
</template> 