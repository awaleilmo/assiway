<script setup>

import UserLayout from "@/Layouts/UserLayout.vue";
import Book from "./Book.vue";
import {onMounted, ref} from "vue";
import Self from "./Self.vue";
import WorkUs from "./WorkUs.vue";
import {initFlowbite} from 'flowbite'

const props = defineProps({
    dataBooks: {
        type: Object
    }
})

const loading = ref(true);

onMounted(() => {
    initFlowbite();
    setTimeout(() => {
        loading.value = false
    }, 500)
})
</script>

<template>
    <user-layout :loading="loading">
        <div class="grid md:grid-rows-2">
            <div v-if="dataBooks.length > 0" class="w-full min-h-screen flex justify-center text-blue-500 bg-transparent">
                <book :items="dataBooks" v-show="!loading"/>
            </div>
            <div class="w-full bg-black flex justify-center items-center text-blue-500">
                <self v-show="!loading"/>
            </div>
            <div class="w-full bg-black flex justify-center items-center text-blue-500">
                <work-us v-show="!loading"/>
            </div>
        </div>
    </user-layout>
</template>

<style scoped>

</style>
