<script setup>
import UserLayout from "@/Layouts/UserLayout.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {onBeforeMount, onMounted, ref} from "vue";
import {initFlowbite} from "flowbite";
import CardWithImage from "@/Components/CardWithImage.vue";
import Loading from "@/Components/Loading.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import InvoiceModel from "@/Model/InvoiceModel.js";
import BookModel from "@/Model/BookModel.js";

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
const progressLoading = ref(false)
onBeforeMount(() => {
    progressLoading.value = true
})
const downloadFile = async (item) => {
    progressLoading.value = true
    let dta = {
        user_id: usePage().props.auth.user.id,
        book_id: item.id
    }
    let checkMyBook = await BookModel.checkIsMyBook(dta)
    setTimeout(async () => {
        let form = {
            id: checkMyBook.data.invoice.id,
            status: 2
        }
        await InvoiceModel.setStatus(form)
        progressLoading.value = false
        let link = document.createElement('a');
        link.href = '../storage/book/' + item.file;
        link.download = item.name;
        link.click();
        link.remove();
    }, 3000)
}
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
            <div class="p-4 border-2 bg-gray-100 border-gray-200 border-dashed rounded-lg mt-14 min-h-screen">
                <h1 class="text-gray-700 font-bold text-2xl mb-4 pb-5 border-b-2">
                    My Books
                </h1>
                <div class="max-w-[100%] flex flex-wrap">
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
                            <primary-button class="inline-flex items-center" @click="downloadFile(item)">
                                Download file
                                <font-awesome-icon :icon="['fas', 'file-download']" class="w-4 h-4 ml-2"/>
                            </primary-button>
                        </template>
                    </card-with-image>
                    <div v-if="dataBooks.data.length === 0" class="flex justify-center items-center text-center w-full">
                        <h1 class="text-gray-500 font-bold text-2xl mb-4">
                            No Data
                            <svg xmlns="http://www.w3.org/2000/svg" id="currentIllo" data-name="Layer 1"
                                 width="647.63626" height="632.17383" viewBox="0 0 647.63626 632.17383"
                                 class="h-96 mt-12 opacity-50"
                                 xmlns:xlink="http://www.w3.org/1999/xlink">
                                <path
                                    d="M687.3279,276.08691H512.81813a15.01828,15.01828,0,0,0-15,15v387.85l-2,.61005-42.81006,13.11a8.00676,8.00676,0,0,1-9.98974-5.31L315.678,271.39691a8.00313,8.00313,0,0,1,5.31006-9.99l65.97022-20.2,191.25-58.54,65.96972-20.2a7.98927,7.98927,0,0,1,9.99024,5.3l32.5498,106.32Z"
                                    transform="translate(-276.18187 -133.91309)" fill="#f2f2f2"></path>
                                <path
                                    d="M725.408,274.08691l-39.23-128.14a16.99368,16.99368,0,0,0-21.23-11.28l-92.75,28.39L380.95827,221.60693l-92.75,28.4a17.0152,17.0152,0,0,0-11.28028,21.23l134.08008,437.93a17.02661,17.02661,0,0,0,16.26026,12.03,16.78926,16.78926,0,0,0,4.96972-.75l63.58008-19.46,2-.62v-2.09l-2,.61-64.16992,19.65a15.01489,15.01489,0,0,1-18.73-9.95l-134.06983-437.94a14.97935,14.97935,0,0,1,9.94971-18.73l92.75-28.4,191.24024-58.54,92.75-28.4a15.15551,15.15551,0,0,1,4.40966-.66,15.01461,15.01461,0,0,1,14.32032,10.61l39.0498,127.56.62012,2h2.08008Z"
                                    transform="translate(-276.18187 -133.91309)" fill="#3f3d56"></path>
                                <path
                                    d="M398.86279,261.73389a9.0157,9.0157,0,0,1-8.61133-6.3667l-12.88037-42.07178a8.99884,8.99884,0,0,1,5.9712-11.24023l175.939-53.86377a9.00867,9.00867,0,0,1,11.24072,5.9707l12.88037,42.07227a9.01029,9.01029,0,0,1-5.9707,11.24072L401.49219,261.33887A8.976,8.976,0,0,1,398.86279,261.73389Z"
                                    transform="translate(-276.18187 -133.91309)" fill="#ffdc63"></path>
                                <circle cx="190.15351" cy="24.95465" r="20" fill="#ffdc63"></circle>
                                <circle cx="190.15351" cy="24.95465" r="12.66462" fill="#fff"></circle>
                                <path
                                    d="M878.81836,716.08691h-338a8.50981,8.50981,0,0,1-8.5-8.5v-405a8.50951,8.50951,0,0,1,8.5-8.5h338a8.50982,8.50982,0,0,1,8.5,8.5v405A8.51013,8.51013,0,0,1,878.81836,716.08691Z"
                                    transform="translate(-276.18187 -133.91309)" fill="#e6e6e6"></path>
                                <path
                                    d="M723.31813,274.08691h-210.5a17.02411,17.02411,0,0,0-17,17v407.8l2-.61v-407.19a15.01828,15.01828,0,0,1,15-15H723.93825Zm183.5,0h-394a17.02411,17.02411,0,0,0-17,17v458a17.0241,17.0241,0,0,0,17,17h394a17.0241,17.0241,0,0,0,17-17v-458A17.02411,17.02411,0,0,0,906.81813,274.08691Zm15,475a15.01828,15.01828,0,0,1-15,15h-394a15.01828,15.01828,0,0,1-15-15v-458a15.01828,15.01828,0,0,1,15-15h394a15.01828,15.01828,0,0,1,15,15Z"
                                    transform="translate(-276.18187 -133.91309)" fill="#3f3d56"></path>
                                <path
                                    d="M801.81836,318.08691h-184a9.01015,9.01015,0,0,1-9-9v-44a9.01016,9.01016,0,0,1,9-9h184a9.01016,9.01016,0,0,1,9,9v44A9.01015,9.01015,0,0,1,801.81836,318.08691Z"
                                    transform="translate(-276.18187 -133.91309)" fill="#ffdc63"></path>
                                <circle cx="433.63626" cy="105.17383" r="20" fill="#ffdc63"></circle>
                                <circle cx="433.63626" cy="105.17383" r="12.18187" fill="#fff"></circle>
                            </svg>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>

    <loading :loading="progressLoading"/>
</template>

<style scoped>

</style>
