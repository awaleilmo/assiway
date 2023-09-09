<script setup>

import CardWithImage from "@/Components/CardWithImage.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import {onMounted, ref} from "vue";
import {initFlowbite} from "flowbite";
import {useForm, usePage} from "@inertiajs/vue3";
import Notification from "@/Components/Notification.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Pagination from "@/Components/Pagination.vue";

const loading = ref(true);

const props = defineProps({
    dataBooks: Object
})

const url = usePage().props.dataBooks.path
const title = 'Books'
const columns = [
    {label: 'Cover', field: 'coverType', search: true, sortable: true, width: '200px'},
    {label: 'Display Homepage', field: 'display', search: true, sortable: true, width: '150px'},
    {label: 'Name', field: 'name', search: true, sortable: true, width: '150px'},
    {label: 'Author', field: 'author', search: true, sortable: true, width: '100px'},
    {label: 'Description', field: 'description', search: true, sortable: true, width: '300px'},
    {label: 'Year', field: 'years', search: true, sortable: true, width: '100px'},
    {label: 'Publisher', field: 'publisher', search: true, sortable: true, width: '100px'},
    {label: 'Price', field: 'price', search: true, sortable: true, width: '100px'},
    {label: 'File', field: 'file', search: true, sortable: true, width: '100px'},
]
const show = ref(false)
const alerts = ref({
    color: 'bg-red-50 text-red-600',
    status: false,
    message: '',
})
const params= useForm({
    perPage: 10,
    search: '',
    column: 'name',
})
const selected= ref(
    [
        {name: 'perPage', value: '10'},
        {name: 'search', value: ''},
        {name: 'column', value: 'name'},
    ]
)
const buyButton = (value) => {
    loading.value = true
    let isLogin = usePage().props.auth.user
    setTimeout(() => {
        if (!isLogin) {
            return location.href = '/login'
        }
    }, 3000)
}

onMounted(() => {
    initFlowbite();
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    if(queryString){
        selected.value = []
        urlParams.forEach((value, key) => {
            params[key] = value
            selected.value.push({
                name: key,
                value: value
            })
        })
    }
    setTimeout(() => {
        loading.value = false
    }, 500)
})
</script>

<template>
    <UserLayout :loading="loading">
        <div class="p-4">
            <div class="p-4 rounded-lg mt-14">
                <!-- notification -->
                <Notification :alerts="alerts"/>

                <div class="max-w-[100%] flex flex-wrap justify-center"
                    :class="{'h-[60vh]': dataBooks.data.length === 0}"
                >
                    <card-with-image v-for="(item, index) in dataBooks.data" :key="index">
                        <template #image>
                            <img :src="item.coverType +','+ item.cover"
                                 class="rounded-t-lg object-contain object-top h-96 w-full" alt="image"/>
                        </template>
                        <template #header>
                            {{ item.name }}
                        </template>
                        <template #description>
                            {{ item.description }}
                        </template>
                        <template #button>
                            <primary-button class="inline-flex items-center" @click="buyButton(item)">
                                Buy Now
                                <font-awesome-icon :icon="['fas', 'shopping-cart']" class="w-4 h-4 ml-2"/>
                            </primary-button>
                        </template>
                    </card-with-image>
                </div>
            </div>
        </div>
        <div class="w-full bg-gray-900 py-4 rounded-t-2xl">
            <Pagination :links="dataBooks.links" :params="selected" :url="dataBooks.path"/>
        </div>
    </UserLayout>
</template>

<style scoped>

</style>
