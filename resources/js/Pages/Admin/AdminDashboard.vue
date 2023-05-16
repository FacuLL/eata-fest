<script setup>
    import AppLayout from '@/Layouts/AppLayout.vue';

    function userSearch(text) {
        this.search = text;
        if (this.search.length > 3) {

        }
    }
</script>

<script>
export default {
    data() {
    return {
      search: ""
    }
  },
  computed: {
    getsearch: function () {
      return this.search;
    }
  },
    props: {
        user_type: String
    }
}
</script>

<template>
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
                        <input @input="event => userSearch(event.target.value)" type="text" name="user_name" placeholder="Ingrese nombre del organizador" id="user_name" class="rounded-lg dark:bg-gray-800 dark:border-gray-800">
                    </div>
                    <div class="grid grid-cols-1 px-20 mt-5">
                        <h1 class="text-center dark:text-gray-300" v-if="getsearch.length <= 3">Ingrese algunos caractetes</h1>
                    </div>
                </div>
            </div>  
        </div>
    </AppLayout>
</template> 

