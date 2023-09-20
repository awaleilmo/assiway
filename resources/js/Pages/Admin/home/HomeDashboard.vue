<script setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";

const test = (val) => {
    console.log(val)
}
const dashboard = ref([]);
const add = () => {
    dashboard.value.push({

    })
}
</script>

<template>
    <admin-layout>
        <template #header>
            DASHBOARD HOME
        </template>

        <div class="p-4 sm:ml-64 mt-14">
            <div class="p-4 border-2 rounded-lg dark:border-gray-700">
                <div class="grid grid-cols-3 gap-4 mb-2">
                    <div v-for="(item, index) in dashboard" :key="index" class="rounded bg-white">
                        <div class="p-4 flex gap-4 w-full">
                            <div>
                                <input-label value="Background Color" />
                                <text-input type="color" class="h-8 w-full" value="#1F2937" model-value=""/>
                            </div>
                            <div>
                                <input-label value="Column" />
                                <text-input type="number" class="w-full" value="3" max="5" min="1" model-value=""/>
                            </div>
                            <div>
                                <input-label value="Height" />
                                <text-input type="text" class="w-full" value="600px" model-value=""/>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 p-2 justify-center h-[600px] bg-gray-800">
                            <div class="flex items-center cursor-pointer justify-center h-24 rounded border border-dashed w-full">
                                <p class="text-2xl text-gray-500">
                                    <font-awesome-icon icon="fa-solid fa-plus" class="w-5 h-5"/>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center cursor-pointer justify-center h-24 rounded bg-gray-50 dark:bg-gray-800">
                        <p class="text-2xl text-gray-400 dark:text-gray-500">
                            <font-awesome-icon icon="fa-solid fa-plus" class="w-5 h-5"/>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<style scoped>

</style>
