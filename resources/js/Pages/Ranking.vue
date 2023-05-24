<script setup>
import { Head } from '@inertiajs/vue3';
const textColors = ['!text-yellow-300', '!text-gray-100', '!text-orange-400'];
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
                let startingTop = 1;
                let cardHeight = 0.2;
                let topAux = startingTop;
                for (let i = 0; i < ranking.length; i++) {
                    this.top[i] = topAux;
                    topAux+=cardHeight;
                }
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
                else this.ranking[index].points+=res.points;
                let aux = this.ranking;
                aux.sort(sortParticipants);
                this.setHeights(aux);
            });
        }
    }
</script>

<template>
    {{ top }}
    <Head title="Ranking" />

    <div class="dark:bg-gray-800 absolute h-full w-full">
        <h1 class="mt-5 text-3xl text-center dark:text-gray-200">Ranking</h1>
        <div class="mt-5 mx-1 sm:mx-5 md:max-w-screen-lg md:mx-auto">
            <div class="w-full">
                    <div class="transition-all duration-250 relative ranking-item flex justify-between content-center p-2 mt-2 w-full dark:bg-gray-700 bg-gray-300 rounded" :style="`top: ${top[i]}rem`" v-for="(participant, i) in ranking">
                    <h1 class="dark:text-gray-200 text-xl ranking-item-order" :class="i >= 0 && i <= 2 ? textColors[i] : ''">{{ i + 1 }}. {{ participant.name }}</h1>
                    <div class="flex justify-center content-center h-full">
                        <div class="dark:bg-gray-800 rounded p-1 w-10">
                            <h1 class="dark:text-gray-200 text-center">{{ participant.points }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
