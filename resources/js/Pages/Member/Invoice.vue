<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import Notification from "@/Components/Notification.vue";
import AkuTable from "@/Components/AkuTable.vue";
import Badge from "@/Components/Badge.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import {formatter} from "@/Configuration/sys.js";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InvoiceModel from "@/Model/InvoiceModel.js";

const props = defineProps({
    dataInvoice: {
        type: Object
    }
})
const url = usePage().props.dataInvoice.path
const title = 'Invoices'
const columns = [
    {label: 'No Invoice', field: 'noInvoice', search: true, sortable: false, width: '150px'},
    {label: 'Name User', field: 'user_name', search: false, sortable: true, width: '150px'},
    {label: 'Book', field: 'book_name', search: false, sortable: true, width: '150px'},
    {label: 'Price', field: 'price', search: false, sortable: true, width: '150px'},
    {label: 'Status', field: 'status', search: false, sortable: true, width: '150px'},
    {label: 'Action', field: 'action', search: false, sortable: true, width: '150px'},
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

const btnSend = (data) => {
    progressLoading.value = true
    setTimeout(async () => {
        progressLoading.value = false
        let inv = "'" + data.noInvoice.split('#')[1] + "'"
        let text = `Hallo, Nama Saya ${data.user_name} ` +
            'saya ingin beli buku\n' +
            ` -Nama Buku: ${data.book_name}\n` +
            ` -Harga: Rp ${formatter.format(data.price)}\n` +
            ` -no Invoice: ${inv}\n`
        const whatsappMessage = window.encodeURIComponent(text);
        const url = `https://api.whatsapp.com/send?phone=6285692699715&text=${whatsappMessage}`
        return window.open(url)
    }, 3000)
}

</script>

<template>
    <UserLayout :loading="progressLoading">

        <div class="p-4 min-h-screen">
            <div class="p-4 border-2 bg-gray-100 border-gray-200 border-dashed rounded-lg  mt-14">
                <div class="max-w-[100%] mx-auto sm:px-6 lg:px-8">
                    <!-- notification -->
                    <Notification :alerts="alerts"/>
                    <AkuTable
                        :data-table="dataInvoice"
                        :column="columns"
                        :select-options="{
                            enable: false,
                        }"
                        compact-mode
                        search-default="noInvoice"
                        ref="datatable"
                    >
                        <template #table-row="props">
                             <span v-if="props.column.field === 'price'">
                                {{ formatter.format(props.row.price) }}
                            </span>
                            <span v-if="props.column.field === 'status'">
                                <badge v-if="props.row.status === 0" color-props="yellow" font-width="base"
                                       border-props>Belum Bayar</badge>
                                <badge v-if="props.row.status === 1" color-props="indigo" font-width="base"
                                       border-props>Sudah Bayar</badge>
                                <badge v-if="props.row.status === 2" color-props="green" font-width="base" border-props>Selesai</badge>
                                <badge v-if="props.row.status === 3" color-props="red" font-width="base" border-props>Di Tolak</badge>
                            </span>
                            <span v-if="props.column.field === 'action'">
                                <primary-button v-if="props.row.status === 0" @click="btnSend(props.row)">
                                    <font-awesome-icon icon="fa-solid fa-paper-plane" class="mx-1"/>
                                    Kirim Pesan
                                </primary-button>
                            </span>
                        </template>
                    </AkuTable>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<style scoped>

</style>
