<script setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {onMounted, ref} from "vue";
import TrafficModel from "@/Model/TrafficModel.js";
import {formatter} from "@/Configuration/sys.js";

const sale = ref(0);
const visitor = ref(0);
const unpaid = ref(0);

const chartOptions = ref({
    chart: {
        type: 'column'
    },

    title: {
        text: 'Grafik Penjualan Buku'
    },
    legend: {
        align: 'right',
        verticalAlign: 'middle',
        layout: 'vertical'
    },
    xAxis: {
        categories: ['BUKU'],
        labels: {
            x: -10
        }
    },
    yAxis: {
        allowDecimals: false,
        title: {
            text: 'Total Penjualan'
        }
    },
    series: [],
});

const startUp = async () => {
    const model = await TrafficModel.statistics()
    const traffic = model.data;
    sale.value = traffic.graphPenjualan.total;
    visitor.value = traffic.graphPengunjung.total;
    unpaid.value = traffic.graphBelumBayar.total;
    console.log(traffic.graphPenjualanPerBook);
    let buku = []
    for(let i = 0; i < traffic.graphPenjualanPerBook.length; i++){
      let obj = {
        name: traffic.graphPenjualanPerBook[i].name,
        data: [traffic.graphPenjualanPerBook[i].data]
      }
      buku.push(obj)
    }
    chartOptions.value.series = buku;
}

onMounted(() => {
    startUp();
})
</script>

<template>
    <AdminLayout>
        <template #header>
            Dashboard
        </template>

        <div class="p-4 sm:ml-64 mt-14">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <div class="px-3 py-2 border-2 bg-gray-100 border-gray-200 border-dashed rounded-lg">
                    <h1 class="text-lg font-medium">
                        Pengunjung
                    </h1>
                    <p class="text-xl font-bold">
                        {{ formatter.format(visitor) }}
                    </p>
                </div>
                <div class="px-3 py-2 border-2 bg-gray-100 border-gray-200 border-dashed rounded-lg">
                    <h1 class="text-lg font-medium">
                        Penjualan
                    </h1>
                    <p class="text-xl font-bold">
                        {{ formatter.format(sale) }}
                    </p>
                </div>
                <div class="px-3 py-2 border-2 bg-gray-100 border-gray-200 border-dashed rounded-lg">
                    <a href="/admin/invoice">
                    <h1 class="text-lg font-medium">
                        Belum Di Bayar
                    </h1>
                    <p class="text-xl font-bold">
                        {{ formatter.format(unpaid) }}
                    </p>
                    </a>
                </div>
            </div>
            <div class="p-4 border-2 bg-gray-100 border-gray-200 border-dashed rounded-lg  mt-5">
                <div class="max-w-[100%] mx-auto sm:px-6 lg:px-8">
                    <charts :options="chartOptions"></charts>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

<style scoped>

</style>
