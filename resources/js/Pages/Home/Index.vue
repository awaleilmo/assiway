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
        <div class="w-full flex justify-center bg-black">
            <div class="grid md:grid-rows-2 max-w-7xl">
                <div v-if="dataBooks.length > 0" class="w-full flex justify-center text-blue-500 bg-transparent">
                    <book :items="dataBooks" v-show="!loading"/>
                </div>
                <div class="w-full bg-black flex justify-center items-center text-blue-500">
                    <self v-show="!loading"/>
                </div>
                <div class="w-full bg-black flex justify-center items-center text-blue-500">
                    <work-us v-show="!loading"/>
                </div>
                <div class="w-full bg-black p-6 flex justify-center items-center text-blue-500">
                    <div class="md:grid md:grid-cols-3 gap-4 p-6 w-full grid-flow-col">
                        <div v-for="item in 3" >
                            <div class="justify-end flex">
                                <img v-motion
                                     :initial="{ opacity: 0, x: -100, duration: 1000 }"
                                     :enter="{ opacity: 1, x: 0 }"
                                     :visible="{ opacity: 1, x: 0 }"
                                     :delay="600" src="../../assets/work1.webp" class="object-cover rounded-lg" width="1733" height="1155" alt="">
                            </div>
                            <div class="flex items-center">
                                <div class="py-8 px-4 w-full mx-auto max-w-screen-xl lg:py-16">
                                    <h1 v-motion
                                        :initial="{ opacity: 0, y: -100, duration: 1000 }"
                                        :enter="{ opacity: 1, y: 0 }"
                                        :visible="{ opacity: 1, y: 0 }"
                                        :delay="500"
                                        class="mb-4 text-3xl font-extrabold tracking-tight leading-none text-white md:text-4xl lg:text-5xl ">
                                        KEMBANGKAN</h1>
                                    <h1 v-motion
                                        :initial="{ opacity: 0, y: -100, duration: 1000 }"
                                        :enter="{ opacity: 1, y: 0 }"
                                        :visible="{ opacity: 1, y: 0 }"
                                        :delay="600"
                                        class="mb-6 text-5xl font-extrabold tracking-tight leading-none text-white md:text-6xl lg:text-7xl ">
                                        SOFT SKILLS</h1>
                                    <p v-motion
                                       :initial="{ opacity: 0, y: -100, duration: 1000 }"
                                       :enter="{ opacity: 1, y: 0 }"
                                       :visible="{ opacity: 1, y: 0 }"
                                       :delay="600" class="mb-8 text-lg font-normal text-gray-500 lg:text-xl ">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                                        industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                                        scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into
                                        electronic typesetting, remaining essentially unchanged.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </user-layout>
</template>

<style scoped>

</style>
