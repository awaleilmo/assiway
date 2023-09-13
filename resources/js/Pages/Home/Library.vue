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
import Modal from "@/Components/Modal.vue";
import ProgressBar from "@/Components/ProgressBar.vue";
import {formatter} from "@/Configuration/sys.js";
import SuccessButton from "@/Components/SuccessButton.vue";
import InvoiceModel from "@/Model/InvoiceModel.js"
import bookModel from "@/Model/BookModel.js";

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
const showInvoice = ref(false)
const alerts = ref({
    color: 'bg-red-50 text-red-600',
    status: false,
    message: '',
})
const params = useForm({
    perPage: 10,
    search: '',
    column: 'name',
})
const selected = ref(
    [
        {name: 'perPage', value: '10'},
        {name: 'search', value: ''},
        {name: 'column', value: 'name'},
    ]
)
const formInvoice = useForm({
    user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
    book_id: null,
    author: null,
    price: null,
    status: null,
    coverType: null,
    cover: null,
    description: null,
    title: null,
    year: null,
    publisher: null,
    fileData: null,
})
const myBooks = ref(false)
const buyButton = async (value) => {
    loading.value = true
    let isLogin = usePage().props.auth.user
    if(isLogin){
        let form = {
            user_id: isLogin.id,
            book_id: value.id
        }
        let checkIsMyBook = await bookModel.checkIsMyBook(form)
        myBooks.value = checkIsMyBook.data.status
    }
    setTimeout(() => {
        showInvoice.value = true
        formInvoice.book_id = value.id
        formInvoice.price = value.price
        formInvoice.author = value.author
        formInvoice.status = 0
        formInvoice.coverType = value.coverType
        formInvoice.cover = value.cover
        formInvoice.description = value.description
        formInvoice.title = value.name
        formInvoice.year = value.years
        formInvoice.publisher = value.publisher
        formInvoice.fileData = value.file
        loading.value = false
    }, 3000)
}
const downloadFile = async(item) => {
    showInvoice.value = false
    loading.value = true
    let dta = {
        user_id: usePage().props.auth.user.id,
        book_id: item.book_id
    }
    let checkMyBook = await bookModel.checkIsMyBook(dta)
    setTimeout(async () => {
        let form = {
            id: checkMyBook.data.invoice.id,
            status: 2
        }
        await InvoiceModel.setStatus(form)
        loading.value = false
        let link = document.createElement('a');
        link.href = '../storage/book/' + item.fileData;
        link.download = item.title;
        link.click();
        link.remove();
    }, 3000)
}
const bayarSave = () => {
    loading.value = true
    showInvoice.value = false
    let isLogin = usePage().props.auth.user
    setTimeout(async () => {
        if (!isLogin) {
            return location.href = '/login'
        }
        let dateOfBirth = isLogin.date
        let placeOfBirth = isLogin.place
        let gender = isLogin.gender
        let address = isLogin.address
        let phone = isLogin.phone
        let typePhoto = isLogin.typePhoto
        if (dateOfBirth === null || placeOfBirth === null || gender === null || address === null || phone === null || typePhoto === null) {
            loading.value = false
            show.value = true
            let text = 'Silakan isi semua data akun anda terlebih dahulu, sebelum melakukan pembelian <br />' +
                `${dateOfBirth !== null ? '' : 'Tanggal Lahir, '}` +
                `${placeOfBirth !== null ? '' : 'Tempat Lahir, '}` +
                `${gender !== null ? '' : 'Jenis Kelamin, '}` +
                `${address !== null ? '' : 'Alamat, '}` +
                `${phone !== null ? '' : 'Nomor Telepon, '}` +
                `${typePhoto !== null ? '' : 'Foto, '}`
            return alerts.value = {
                color: 'bg-red-50 text-red-600',
                status: true,
                message: text,
            }
        }
        let saveData = await InvoiceModel.createInvoice(formInvoice)
        if(saveData.success){
            loading.value = false
            let data = saveData.data
            let inv = "'"+data.contents.noInvoice.split('#')[1]+"'"
            let text = `Hallo, Nama Saya ${usePage().props.auth.user.name} ` +
                'saya ingin beli buku\n' +
                ` -Nama Buku: ${formInvoice.title}\n` +
                ` -Harga: Rp ${formatter.format(formInvoice.price)}\n` +
                ` -no Invoice: ${inv}\n`
            const whatsappMessage = window.encodeURIComponent(text);
            const url = `https://api.whatsapp.com/send?phone=6285692699715&text=${whatsappMessage}`
            formInvoice.reset()
            return window.open(url)
        }
        loading.value = false
        return alerts.value = {
            color: 'bg-red-50 text-red-600',
            status: true,
            message: saveData.data.message,
        }

    }, 2000)
}

onMounted(() => {
    initFlowbite();
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    if (queryString) {
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
    <Modal max-width="lg" :show="showInvoice" @close="showInvoice=false">
        <div class="relative">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <button @click="showInvoice=false" type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-hide="crypto-modal">
                    <font-awesome-icon icon="fa-solid fa-close"/>
                    <span class="sr-only">Close modal</span>
                </button>
                <!-- Modal header -->
                <div class="px-6 py-4 border-b rounded-t bg-gray-100">
                    <h3 class="text-base font-semibold text-gray-900 lg:text-xl ">
                        Invoice
                    </h3>
                </div>
                <!-- Modal body -->
                <div v-if="!formInvoice.processing" class="p-6 gap-4 flex flex-col">
                    <h2 class="text-base font-semibold text-gray-900 lg:text-3xl ">
                        {{ formInvoice.title }}
                    </h2>
                    <div>
                        <img :src="formInvoice.coverType +','+ formInvoice.cover"
                             class=" object-cover h-[80vh] rounded-lg w-full" alt="image"/>
                        <p class="text-gray-700 text-sm font-medium italic">
                            Publisher: {{ formInvoice.publisher }}, Year: {{ formInvoice.year }}
                        </p>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 lg:text-xl mb-2">
                            Spoiler
                        </h3>
                        <p class="p-3 rounded text-gray-700 font-medium  bg-gray-200">
                            {{ formInvoice.description }}
                        </p>
                        <p class="text-gray-700 text-xs mt-2 font-medium italic">
                            Penulis: {{ formInvoice.author }}
                        </p>
                        <p class="pt-6 px-3 rounded text-gray-700 font-medium sm:text-2xl">
                            Price : Rp {{ formatter.format(formInvoice.price) }}
                        </p>
                    </div>
                </div>

                <div v-if="formInvoice.processing" class="p-6">
                    <ProgressBar v-if="formInvoice.progress" title="Upload File"
                                 :progress="formInvoice.progress.percentage"/>
                </div>

                <!-- Modal footer -->
                <div v-if="!formInvoice.processing"
                     class="px-4 py-2 flex justify-end border-t rounded-b bg-gray-100 ">
                    <primary-button v-if="myBooks" class="inline-flex items-center" @click="downloadFile(formInvoice)">
                        Download file
                        <font-awesome-icon :icon="['fas', 'file-download']" class="w-4 h-4 ml-2"/>
                    </primary-button>
                    <success-button v-else class="inline-flex items-center" type="button" @click="bayarSave">
                        Beli Sekarang
                        <font-awesome-icon :icon="['fas', 'shopping-cart']" class="w-4 h-4 ml-2"/>
                    </success-button>
                </div>
            </div>
        </div>
    </Modal>

    <Modal :show="show" @close="show=false">
        <div
            :class="'p-4 text-sm rounded-lg flex items-center '+alerts.color"
        >
                        <span class="font-medium" v-html="alerts.message">
                        </span>
            <button @click="show=false" type="button"
                    class=" text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <font-awesome-icon icon="fa-solid fa-close"/>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
    </Modal>

    <UserLayout :loading="loading">
        <div class="p-4">
            <div class="p-4 rounded-lg mt-14">

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
                            <p class="whitespace-pre-line line-clamp-2 overflow-hidden truncate text-ellipsis">
                                {{ item.description }}
                            </p>
                        </template>
                        <template #button>
                            <primary-button class="inline-flex items-center hover:scale-110" @click="buyButton(item)">
                                Lihat Detail
                                <font-awesome-icon :icon="['fas', 'arrow-right']" class="w-4 h-4 ml-2"/>
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
