<script setup>
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '../Components/PrimaryButton.vue';
const textColors = ['!text-yellow-300', '!text-white', '!text-orange-400'];
</script>

<script>
    export default {
        props: {
            participants: Array
        },
        data() {
            return {
                ranking: null,
                top: []
            }
        },
        methods: {
            setHeights: function (ranking) {
                for (let i = 0; i < ranking.length; i++) {
                    let index = this.ranking.findIndex((part) => part.id == ranking[i].id);
                    if (index != -1) this.top[index] = (i-index) * 116.6;
                }
            },
            goBack: function () {
                window.history.back();
            }
        },
        mounted() {
            let sortParticipants = (x, y) => {
                return y.points - x.points;
            }
            this.ranking = this.participants;
            this.setHeights(this.ranking);
            Echo.channel('ranking').listen('.new_entry', (res) => {
                let index = this.participants.findIndex((part) => part.id == res.id);
                if (index == -1) this.ranking.push(res);
                let aux = Object.create(this.ranking);
                if (index != -1) aux[index].points+=res.points;
                aux.sort(sortParticipants);
                this.setHeights(aux);
                setTimeout(() => {
                    this.ranking.sort(sortParticipants);
                    this.setHeights(this.ranking);
                }, 250);
            });
        }
    }
</script>

<template>
    <Head title="Ranking" />

    <div class="dark:bg-gray-800 absolute h-full w-full">
        <h1 class="mt-5 text-3xl text-center dark:text-gray-200">Ranking</h1>
        <div class="mt-5 mx-1 sm:mx-5 md:max-w-screen-lg md:mx-auto">
            <div class="w-full px-2">
                    <div class="relative ranking-item flex justify-between content-center p-2 mt-2 w-full dark:bg-gray-700 bg-gray-300 rounded" :style="top[i] && `transition: all 250ms; transform: translateY(${top[i]}%)`" v-for="(participant, i) in ranking">
                    <h1 class="text-ellipsis overflow-hidden dark:text-gray-200 text-xl ranking-item-order" :class="i >= 0 && i <= 2 ? textColors[i] : ''">{{ i + 1 }}. {{ participant.name }}</h1>
                    <div class="flex justify-center content-center h-full">
                        <div class="dark:bg-gray-800 rounded p-1 w-12">
                            <h1 class="dark:text-gray-200 text-center">{{ participant.points }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex w-full justify-center mt-4">
            <PrimaryButton @click="goBack()">Volver</PrimaryButton>
        </div>
    </div>
</template>
