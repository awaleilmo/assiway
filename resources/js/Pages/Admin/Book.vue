<script setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import AkuTable from "@/Components/AkuTable.vue";
import Notification from "@/Components/Notification.vue";
import WarningButton from "@/Components/WarningButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextInputArea from "@/Components/TextInputArea.vue";
import convertToBase64 from "@/Configuration/sys.js";
import ProgressBar from "@/Components/ProgressBar.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Loading from "@/Components/Loading.vue";

const props = defineProps({
    dataBooks: Object
})

const url = usePage().props.dataBooks.path
const title = 'Books'
const columns = [
    {label: 'Cover', field: 'coverType', search: true, sortable: true, width: '100px'},
    {label: 'Name', field: 'name', search: true, sortable: true, width: '100px'},
    {label: 'Author', field: 'author', search: true, sortable: true, width: '100px'},
    {label: 'Description', field: 'description', search: true, sortable: true, width: '300px'},
    {label: 'Year', field: 'years', search: true, sortable: true, width: '100px'},
    {label: 'Publisher', field: 'publisher', search: true, sortable: true, width: '100px'},
    {label: 'Price', field: 'price', search: true, sortable: true, width: '100px'},
    {label: 'File', field: 'file', search: true, sortable: true, width: '100px'},
]
const tempFoto = ref(null);
const tempFile = ref(null);
const show = ref(false)
const previewShow = ref(false)
const imgDataUrl = ref('')
const form = useForm({
    id: null,
    name: null,
    author: null,
    description: null,
    year: null,
    publisher: null,
    price: null,
    cover: null,
    coverType: null,
    fileData: null
});
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
const saveFunction = () => {
    form.post(url, {
        onSuccess: (e) => {
            if (e.props.flash.response.status) {
                form.reset()
                popForm.reset()
                tempFile.value = null
            }
        },
    })
}

// methods
const addFunction = () => {
    popForm.status = true
    popForm.title = 'Add ' + title
    usePage().props.flash = []
}
const editFunction = () => {
    let rawData = datatable.value.$refs.datatab.selectedRows
    if (rawData.length === 0 || rawData.length > 1) {
        alerts.value.status = true
        alerts.value.message = rawData.length === 0 ? 'Please select at least one menu' : 'You can only edit one menu at a time'
        alerts.value.color = 'bg-red-50 text-red-600'
        return;
    }
    let data = rawData[0]
    popForm.status = true
    popForm.title = 'Edit ' + title
    form.id = data.id
    form.name = data.name
    form.author = data.author
    form.description = data.description
    form.year = data.years
    form.publisher = data.publisher
    form.price = data.price
    form.cover = data.cover
    form.coverType = data.coverType
    form.fileData = data.file
    tempFile.value = data.file
    tempFoto.value = data.coverType + ',' + data.cover
    console.log(data)
    usePage().props.flash = []
}
const convertBase = async (file) => {
    let dataRaw = await convertToBase64(file)
    tempFoto.value = dataRaw
    imgDataUrl.value = dataRaw
    show.value = true
}
const saveImage = async () => {
    const data = imgDataUrl.value.split(',');
    form.coverType = data[0];
    form.cover = data[1];
    show.value = false
    tempFoto.value = imgDataUrl.value
    imgDataUrl.value = null
}

function change({canvas}) {
    imgDataUrl.value = canvas.toDataURL("image/jpeg")
}
const openPreview = (data) => {
    progressLoading.value = true
    setTimeout(() => {
        form.id = data.id
        form.name = data.name
        form.author = data.author
        form.description = data.description
        form.year = data.years
        form.publisher = data.publisher
        form.price = data.price
        form.cover = data.cover
        form.coverType = data.coverType
        form.fileData = data.file
        progressLoading.value = false
        previewShow.value = true
    }, 2000)
}
const closeFunction = () => {
    popForm.reset()
    form.reset()
    previewShow.value = false
    tempFile.value = null
    tempFoto.value = null
    usePage().props.flash = []
}
const changeFile = (e) => {
    form.fileData = e.target.files[0]
}
const changeAvatar = () => {
    document.getElementById('fileAvatar').click()
}
// computed
const notification = computed(() => {
    const data = usePage().props.flash.response
    let result;
    if (data) {
        result = {
            status: true,
            message: data.message,
            color: data.color
        }
    }
    return result;
})
</script>

<template>
    <AdminLayout>
        <template #header>
            MENU BOOK
        </template>

        <div class="p-4 sm:ml-64">
            <div class="p-4 border-2 bg-gray-100 border-gray-200 border-dashed rounded-lg  mt-14">
                <div class="max-w-[100%] mx-auto sm:px-6 lg:px-8">
                    <!-- notification -->
                    <Notification :alerts="alerts"/>
                    <!--  button  -->
                    <div class="px-3 py-4 flex justify-end">
                        <primary-button class="mx-1 pl-3 pr-3" @click="addFunction">
                            <font-awesome-icon icon="fa-solid fa-add"/>
                            Add
                        </primary-button>
                        <warning-button class="mx-1 pl-2 pr-3" @click="editFunction">
                            <font-awesome-icon icon="fa-solid fa-pencil" class="mx-1"/>
                            Edit
                        </warning-button>
                    </div>

                    <AkuTable
                        :data-table="dataBooks"
                        :column="columns"
                        checkbox-options
                        ref="datatable"
                    >
                        <template #table-row="props">
                                <span v-if="props.column.field === 'coverType'">
                                  <img :src="props.row.coverType+','+props.row.cover"
                                       class="w-52 h-64 rounded-lg object-cover" alt="...">
                                </span>
                            <span v-if="props.column.field === 'file'">
                                <secondary-button v-if="props.row.file !== null" @click="openPreview(props.row)">
                                    Preview
                                </secondary-button>
                            </span>
                        </template>
                    </AkuTable>
                </div>
            </div>
        </div>
    </AdminLayout>

    <Modal :show="popForm.status" @close="closeFunction" max-width="4xl">
        <div class="relative">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <button @click="closeFunction" type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-hide="crypto-modal">
                    <font-awesome-icon icon="fa-solid fa-close"/>
                    <span class="sr-only">Close modal</span>
                </button>
                <!-- Modal header -->
                <div class="px-6 py-4 border-b rounded-t bg-gray-100">
                    <h3 class="text-base font-semibold text-gray-900 lg:text-xl ">
                        {{ popForm.title }}
                    </h3>
                </div>

                <!-- Modal notification -->
                <Notification :alerts="notification"/>
                <form @submit.prevent="saveFunction" enctype="multipart/form-data">
                    <!-- Modal body -->
                    <div v-if="!form.processing" class="p-6 grid grid-cols-2 gap-3">
                        <div>
                            <InputLabel for="name" value="Name"/>
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                placeholder="Name"
                                :model-value="form.name"
                            />
                        </div>
                        <div>
                            <InputLabel for="author" value="Author"/>
                            <TextInput
                                id="author"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.author"
                                required
                                placeholder="Author"
                                :model-value="form.author"
                            />
                        </div>
                        <div class="col-span-2">
                            <InputLabel for="description" value="Description"/>
                            <TextInputArea
                                id="description"
                                class="mt-1 block w-full"
                                v-model="form.description"
                                required
                                placeholder="Description"
                                :model-value="form.description"
                            />
                        </div>
                        <div>
                            <InputLabel for="year" value="Published Year"/>
                            <TextInput
                                id="year"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.year"
                                required
                                placeholder="Published Year"
                                :model-value="form.year"
                            />
                        </div>
                        <div>
                            <InputLabel for="publisher" value="Publisher"/>
                            <TextInput
                                id="publisher"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.publisher"
                                required
                                placeholder="Publisher Name"
                                :model-value="form.publisher"
                            />
                        </div>
                        <div>
                            <InputLabel for="price" value="Price"/>
                            <TextInput
                                id="price"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.price"
                                required
                                placeholder="Price"
                                :model-value="form.price"
                            />
                        </div>
                        <div>
                            <InputLabel for="file" value="File"/>
                            <TextInput
                                id="file"
                                type="file"
                                class="mt-1 block w-full"
                                accept=".pdf"
                                @change="changeFile($event)"
                                placeholder="File"
                            />
                        </div>
                        <div>
                            <InputLabel for="cover" value="cover"/>
                            <div
                                class="w-52 h-80 mt-2 cursor-pointer border border-gray-300 object-cover flex items-center justify-center rounded-lg"
                                @click="changeAvatar">
                                <font-awesome-icon v-if="form.coverType === ''" icon="fa-solid fa-add"
                                                   class="text-7xl text-gray-600"/>
                                <img id="imgAvatar" v-else :src="tempFoto"
                                     class="w-52 h-80 rounded-lg object-cover" alt="..."/>
                            </div>
                            <input id="fileAvatar" type="file" accept="image/*" class="hidden"
                                   @change="convertBase($event)"/>
                        </div>
                    </div>

                    <div v-if="form.processing" class="p-6">
                        <ProgressBar v-if="form.progress" title="Upload File"
                                     :progress="form.progress.percentage"/>
                    </div>

                    <!-- Modal footer -->
                    <div v-if="!form.processing" class="px-4 py-2 flex justify-end border-t rounded-b bg-gray-100 ">
                        <primary-button type="submit">
                            Save
                        </primary-button>
                    </div>
                </form>
            </div>
        </div>
    </Modal>

    <Modal :show="show">
        <div class="relative">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <!-- Modal header -->
                <div class="px-6 py-4 border-b rounded-t bg-gray-100">
                    <h3 class="text-base font-semibold text-gray-900 lg:text-xl ">
                        Cover Book
                    </h3>
                </div>

                <!-- Modal body -->
                <div class="p-6">
                    <div class="mt-4">
                        <cropper
                            class="copper"
                            :src="tempFoto"
                            :auto-zoom="false"
                            :resizeImage="false"
                            @change="change"
                            image-class="cropper__image"
                            :stencil-props="{
                        class: 'cropper-stencil',
                        previewClass: 'cropper-stencil__preview',
                        draggingClass: 'cropper-stencil--dragging',
                        aspectRatio: 5 / 8,
                        handlersClasses: {
                          default: 'cropper-handler',
                          eastNorth: 'cropper-handler--east-north',
                          westNorth: 'cropper-handler--west-north',
                          eastSouth: 'cropper-handler--east-south',
                          westSouth: 'cropper-handler--west-south',
                        },
                        handlersWrappersClasses: {
                          default: 'cropper-handler-wrapper',
                          eastNorth: 'cropper-handler-wrapper--east-north',
                          westNorth: 'cropper-handler-wrapper--west-north',
                          eastSouth: 'cropper-handler-wrapper--east-south',
                          westSouth: 'cropper-handler-wrapper--west-south',
                        },
                    }"
                        ></cropper>
                    </div>
                    <div class="mt-4 border-t-2 p-2">
                        <h3 class="p-2">
                            Preview
                        </h3>
                        <img id="imgAvatar" :src="imgDataUrl"
                             class="w-52 h-80 rounded-lg object-cover border-4 border-white drop-shadow-lg" alt="..."/>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="px-4 py-2 flex justify-end border-t rounded-b bg-gray-100 ">
                    <primary-button @click="saveImage">
                        Save
                    </primary-button>
                </div>
            </div>
        </div>

    </Modal>

    <Modal :show="previewShow" @close="closeFunction" max-width="7xl">
        <div class="relative w-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow">
                <button @click="closeFunction" type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-hide="crypto-modal">
                    <font-awesome-icon icon="fa-solid fa-close"/>
                    <span class="sr-only">Close modal</span>
                </button>
                <!-- Modal header -->
                <div class="px-6 py-4 border-b rounded-t bg-gray-100">
                    <h3 class="text-base font-semibold text-gray-900 lg:text-xl ">
                        Preview File
                    </h3>
                </div>

                <!-- Modal body -->
                <div class="p-6">
                    <div class="mt-4">
                        <embed :src="'../storage/book/'+form.fileData" width="100%"  height="700" />
                    </div>
                </div>
            </div>
        </div>
    </Modal>



    <Loading :loading="progressLoading"/>
</template>

<style scoped>

</style>
