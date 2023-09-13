<script setup>
import {usePage} from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {formatter} from "@/Configuration/sys.js";
import AkuTable from "@/Components/AkuTable.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import WarningButton from "@/Components/WarningButton.vue";

const props = defineProps({
    dataUsers: Object
})

const url = usePage().props.dataUsers.path
const title = 'User Management'
const columns = [
    {label: 'Foto', field: 'typePhoto', search: false, sortable: false, width: '200px'},
    {label: 'Nama', field: 'name', search: true, sortable: true, width: '200px'},
    {label: 'Email', field: 'email', search: true, sortable: true, width: '200px'},
    {label: 'Tanggal Lahir', field: 'date', search: true, sortable: true, width: '200px'},
    {label: 'Tempat Lahir', field: 'place', search: true, sortable: true, width: '200px'},
    {label: 'No Hp', field: 'phone', search: true, sortable: true, width: '200px'},
    {label: 'Jenis Kelamin', field: 'gender', search: true, sortable: true, width: '200px'},
    {label: 'Alamat', field: 'address', search: false, sortable: false, width: '200px'},
]
</script>

<template>
    <admin-layout>
        <template #header>
            MENU USER MANAGEMENT
        </template>

        <div class="p-4 sm:ml-64">
            <div class="p-4 border-2 bg-gray-100 border-gray-200 border-dashed rounded-lg  mt-14">
                <div class="max-w-[100%] mx-auto sm:px-6 lg:px-8">
                    <AkuTable
                        :data-table="dataUsers"
                        :column="columns"
                        checkbox-options
                        ref="datatable"
                    >
                        <template #table-row="props">
                            <span v-if="props.column.field === 'gender'">
                                <span v-if="props.row.gender === 'L'">
                                    <primary-button>Laki Laki</primary-button>
                                </span>
                                <span v-else>
                                    <warning-button>Perempuan</warning-button>
                                </span>
                            </span>
                            <span v-if="props.column.field === 'typePhoto'">
                                <img :src="props.row.typePhoto+','+props.row.photo"
                                     class="w-52 h-64 rounded-lg object-cover" alt="...">
                            </span>
                        </template>
                    </AkuTable>
                </div>
            </div>
        </div>

    </admin-layout>
</template>

<style scoped>

</style>
