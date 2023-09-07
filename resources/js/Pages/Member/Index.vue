<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {onBeforeMount, onMounted, ref} from "vue";
import {initFlowbite} from "flowbite";
import CardWithImage from "@/Components/CardWithImage.vue";
import Loading from "@/Components/Loading.vue";

const props = defineProps({
    dataBooks: Object
})

const url = usePage().props.dataBooks.path
const title = 'Dashboard'
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
onBeforeMount(() => {
    progressLoading.value = true
})
onMounted(() => {
    initFlowbite();
    setTimeout(() => {
        progressLoading.value = false
    }, 3000)
})
</script>

<template>
    <UserLayout>
        <div class="p-4">
            <div class="p-4 border-2 bg-gray-100 border-gray-200 border-dashed rounded-lg mt-14">
                <div class="max-w-[100%] flex flex-wrap justify-center">
                    <card-with-image v-for="item in 10">
                        <template #image>
                            <img src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="image"/>
                        </template>
                    </card-with-image>
                </div>
            </div>
        </div>
    </UserLayout>

    <loading :loading="progressLoading"/>
</template>

<style scoped>

</style>
