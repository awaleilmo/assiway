<script setup>

import UserLayout from "@/Layouts/userLayout.vue";
import Book from "./book.vue";
import {onMounted, ref} from "vue";
import Self from "./self.vue";
import WorkUs from "./workUs.vue";
import { initFlowbite } from 'flowbite'

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
      <div class="w-full min-h-screen flex justify-center text-blue-500 bg-transparent">
        <book v-show="!loading"/>
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
