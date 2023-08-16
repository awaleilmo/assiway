<script setup>

import Book from "@/Pages/Home/Book.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import Asset1 from "@/Assets/Asset1.png";
import {onMounted, ref} from "vue";
import {initFlowbite} from "flowbite";

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
        <div class=" w-full flex items-center min-h-screen justify-center text-blue-500 bg-transparent"
             :style="{
                    backgroundImage: 'url(' + Asset1 + ')',
                    backgroundSize: 'cover',
                }"
        >
            <div class="grid grid-rows-2 max-w-7xl w-full">
                <div class=" mt-12 p-6 w-full">
                    <div class="justify-end absolute flex translate-x-16 z-10">
                        <img v-motion
                             :initial="{ opacity: 0, x: -100, duration: 1000 }"
                             :enter="{ opacity: 1, x: 0 }"
                             :visible="{ opacity: 1, x: 0 }"
                             :delay="500"
                             src="@/Assets/Asset2.png" class="object-cover h-[75%]" alt="">
                    </div>
                    <div class="flex items-end w-full">
                        <div class="py-8 px-4 mx-auto max-w-3xl lg:py-16 text-right">
                            <h1 v-motion
                                :initial="{ opacity: 0, y: -100, duration: 1000 }"
                                :enter="{ opacity: 1, y: 0 }"
                                :visible="{ opacity: 1, y: 0 }"
                                :delay="500"
                                class="mb-4 text-3xl font-extrabold tracking-tight leading-none text-white md:text-4xl lg:text-9xl ">
                                UBAYDILLAH</h1>
                            <h1 v-motion
                                :initial="{ opacity: 0, y: -100, duration: 1000 }"
                                :enter="{ opacity: 1, y: 0 }"
                                :visible="{ opacity: 1, y: 0 }"
                                :delay="600"
                                class="mb-6 text-5xl font-extrabold tracking-tight leading-none text-white md:text-6xl lg:text-9xl ">
                                ANWAR</h1>
                            <div class="w-full flex justify-end">
                                <p v-motion
                                   :initial="{ opacity: 0, y: -100, duration: 1000 }"
                                   :enter="{ opacity: 1, y: 0 }"
                                   :visible="{ opacity: 1, y: 0 }"
                                   :delay="600"
                                   class="mb-8 text-lg text-justify font-normal text-gray-500 w-[70%] lg:text-xl ">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                    Ipsum
                                    has been the
                                    industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                    galley of type and
                                    scrambled it to make a type specimen book. It has survived not only five centuries,
                                    but
                                    also the leap into
                                    electronic typesetting, remaining essentially unchanged.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 mt-12 p-6 w-full">
                    <div class=" w-full items-start justify-start">
                        <div class="py-8 px-4 mx-auto lg:py-16">
                            <h1 v-motion
                                :initial="{ opacity: 0, y: -100, duration: 1000 }"
                                :enter="{ opacity: 1, y: 0 }"
                                :visible="{ opacity: 1, y: 0 }"
                                :delay="500"
                                class="mb-4 text-3xl font-extrabold tracking-tight leading-none text-white md:text-4xl lg:text-6xl ">
                                UBAYDILLAH</h1>
                            <h1 v-motion
                                :initial="{ opacity: 0, y: -100, duration: 1000 }"
                                :enter="{ opacity: 1, y: 0 }"
                                :visible="{ opacity: 1, y: 0 }"
                                :delay="600"
                                class="mb-6 text-5xl font-extrabold tracking-tight leading-none text-white md:text-6xl lg:text-6xl ">
                                ANWAR</h1>
                            <div class="w-full flex justify-end">
                                <p v-motion
                                   :initial="{ opacity: 0, y: -100, duration: 1000 }"
                                   :enter="{ opacity: 1, y: 0 }"
                                   :visible="{ opacity: 1, y: 0 }"
                                   :delay="600"
                                   class="mb-8 text-lg text-justify font-normal text-gray-500 lg:text-xl ">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                                    Ipsum
                                    has been the
                                    industry's standard dummy text ever since the 1500s, when an unknown printer took a
                                    galley of type and
                                    scrambled it to make a type specimen book. It has survived not only five centuries,
                                    but
                                    also the leap into
                                    electronic typesetting, remaining essentially unchanged.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <img v-motion
                             :initial="{ opacity: 0, x: -100, duration: 1000 }"
                             :enter="{ opacity: 1, x: 0 }"
                             :visible="{ opacity: 1, x: 0 }"
                             :delay="500"
                             src="@/Assets/Asset3.png" class="object-cover h-[75%]" alt="">
                    </div>
                </div>
            </div>
        </div>
    </user-layout>
</template>

<style scoped>

</style>
