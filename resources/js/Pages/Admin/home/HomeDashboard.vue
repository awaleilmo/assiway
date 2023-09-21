<script setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";
import Badge from "@/Components/Badge.vue";

const test = (val) => {
    console.log(val)
}
const dashboard = ref([]);
const add = () => {
    dashboard.value.push({
        backgroundColor: "#1F2937",
        column: 4,
        height: "600px"
    })
}
const changeHead = () => {
    console.log(dashboard)
    dashboard.value = dashboard.value
    // dashboard.value[0].column = 4
    // dashboard.value[0].backgroundColor = "#1F2937"
    // dashboard.value[0].height = "600px"
}
</script>

<template>
    <admin-layout>
        <template #header>
            DASHBOARD HOME
        </template>

        <div class="p-4 sm:ml-64 mt-14">
            <div class="p-4 border-2 rounded-lg dark:border-gray-700">
                <div  v-for="(item, index) in dashboard" :key="index" class="mb-2">
                >
                    <div class="rounded bg-white">
                        <div class="p-4 flex gap-4 w-full">
                            <div>
                                <input-label value="Background Color" />
                                <text-input type="color" class="h-8 w-full" @change="changeHead" v-model="item.backgroundColor"/>
                            </div>
                            <div>
                                <input-label value="Column" />
                                <text-input type="number" class="w-full" @change="changeHead" max="5" min="1" v-model="item.column"/>
                            </div>
                            <div>
                                <input-label value="Height" />
                                <text-input type="text" class="w-full" @change="changeHead" v-model="item.height"/>
                            </div>
                        </div>
                        <div class="md:grid p-2 relative justify-center h-[600px] w-full bg-gray-800"
                             :class="'grid-cols-'+item.column"
                             :style="{
                                 'background-color': item.backgroundColor,
                                 'height': item.height
                             }"
                        >
                            <div v-for="(itemCol, indexCol) in parseInt(item.column)"  :key="indexCol" class="flex items-center cursor-pointer justify-center h-full rounded border border-dashed w-full">
                                <p class="text-2xl text-gray-500">
                                    <font-awesome-icon icon="fa-solid fa-plus" class="w-5 h-5"/>
                                </p>
                                <badge v-if="indexCol < (parseInt(item.column) - 1)" class="absolute transform translate-x-[10.5vw]" :color-props="yellow" font-width="base" border-props>Merge</badge>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="flex items-center cursor-pointer justify-center h-24 w-full rounded bg-gray-100" @click="add">
                    <p class="text-2xl text-gray-400">
                        <font-awesome-icon icon="fa-solid fa-plus" class="w-5 h-5"/>
                    </p>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<style scoped>

</style>
