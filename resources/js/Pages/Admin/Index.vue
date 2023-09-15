<script setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {ref} from "vue";

const chartOptions = ref({
    chart: {
        type: 'column'
    },

    title: {
        text: 'Born persons, by girls\' name'
    },
    legend: {
        align: 'right',
        verticalAlign: 'middle',
        layout: 'vertical'
    },
    subtitle: {
        text: 'Resize the frame or click buttons to change appearance'
    },
    xAxis: {
        categories: ['2019', '2020', '2021'],
        labels: {
            x: -10
        }
    },
    yAxis: {
        allowDecimals: false,
        title: {
            text: 'Amount'
        }
    },
    series: [
        {
            name: 'Ava',
            data: [38, 51, 34]
        }, {
            name: 'Dina',
            data: [31, 26, 27]
        }, {
            name: 'Malin',
            data: [38, 42, 41]
        }
    ],
});
</script>

<template>
<AdminLayout>
    <template #header>
        Dashboard
    </template>

    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 bg-gray-100 border-gray-200 border-dashed rounded-lg  mt-14">
            <div class="max-w-[100%] mx-auto sm:px-6 lg:px-8">
                <charts :options="chartOptions"></charts>
            </div>
        </div>
    </div>
</AdminLayout>
</template>

<style scoped>

</style>
