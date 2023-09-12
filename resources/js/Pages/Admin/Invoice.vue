<script setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import {formatter} from "@/Configuration/sys.js";
import Notification from "@/Components/Notification.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import AkuTable from "@/Components/AkuTable.vue";
import Badge from "@/Components/Badge.vue";
import Loading from "@/Components/Loading.vue";
import InvoiceModel from "@/Model/InvoiceModel.js";

const props = defineProps({
    dataInvoice:{
        type:Object
    }
})
const url = usePage().props.dataInvoice .path
const title = 'Invoices'
const columns = [
    {label: 'No Invoice', field: 'noInvoice', search: true, sortable: false, width: '150px'},
    {label: 'Name User', field: 'user_name', search: true, sortable: true, width: '150px'},
    {label: 'Book', field: 'book_name', search: true, sortable: true, width: '150px'},
    {label: 'Price', field: 'price', search: true, sortable: true, width: '150px'},
    {label: 'Status', field: 'status', search: true, sortable: true, width: '150px'},
]
const datatable = ref(null)
const progressLoading = ref(false)
const popForm = useForm({
    status: false,
    title: ''
})
const alerts = ref({
    color: 'bg-red-50 text-red-600',
    status: false,
    message: '',
})
const sudahBayar = async (statusVal) => {
    progressLoading.value = true
    let rawData = datatable.value.$refs.datatab.selectedRows
    if (rawData.length === 0) {
        alerts.value.status = true
        alerts.value.message = 'Please select at least one menu'
        alerts.value.color = 'bg-red-50 text-red-600 border border-red-400'
        return;
    }
    let data = rawData
    for (let i = 0; i < data.length; i++) {
        let form = {
            id: data[i].id,
            status: statusVal
        }
        await InvoiceModel.setStatus(form)
    }
    location.reload()
}

</script>

<template>
    <AdminLayout>
        <template #header>
            MENU INVOICE
        </template>

        <div class="p-4 sm:ml-64">
            <div class="p-4 border-2 bg-gray-100 border-gray-200 border-dashed rounded-lg  mt-14">
                <div class="max-w-[100%] mx-auto sm:px-6 lg:px-8">
                    <!-- notification -->
                    <Notification :alerts="alerts"/>
                    <!--  button  -->
                    <div class="px-3 py-4 flex justify-end">
                        <primary-button class="mx-1 pl-3 pr-3" @click="sudahBayar(1)">
                            <font-awesome-icon icon="fa-solid fa-clipboard-check" class="mx-1"/>
                            Sudah Bayar
                        </primary-button>
                        <danger-button class="mx-1 pl-3 pr-3" @click="sudahBayar(3)">
                            <font-awesome-icon icon="fa-solid fa-ban" class="mx-1"/>
                            Tolak
                        </danger-button>
                    </div>

                    <AkuTable
                        :data-table="dataInvoice"
                        :column="columns"
                        checkbox-options
                        compact-mode
                        search-default="noInvoice"
                        ref="datatable"
                    >
                        <template #table-row="props">
                             <span v-if="props.column.field === 'price'">
                                {{ formatter.format(props.row.price) }}
                            </span>
                            <span v-if="props.column.field === 'status'">
                                <badge v-if="props.row.status === 0" color-props="yellow" font-width="base" border-props>Belum Bayar</badge>
                                <badge v-if="props.row.status === 1" color-props="indigo" font-width="base" border-props>Sudah Bayar</badge>
                                <badge v-if="props.row.status === 2" color-props="green" font-width="base" border-props>Selesai</badge>
                                <badge v-if="props.row.status === 3" color-props="red" font-width="base" border-props>Di Tolak</badge>
                            </span>
                        </template>
                    </AkuTable>
                </div>
            </div>
        </div>
    </AdminLayout>
    <loading :loading="progressLoading" />
</template>

<style scoped>

</style>
