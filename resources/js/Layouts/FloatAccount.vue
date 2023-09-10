<script setup>

import {onMounted, onUnmounted, watch, ref, computed} from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import TextInputArea from "@/Components/TextInputArea.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerWarning from "@/Components/DangerWarning.vue";
import {Link, useForm, usePage} from '@inertiajs/vue3';
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Select from "@/Components/Select.vue";
import Loading from "@/Components/Loading.vue";
import Notification from "@/Components/Notification.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(['close']);
const user = usePage().props.auth.user;
const fotoProfil = ref(user.photo !== null);
const tempFoto = ref(user.photo !== null ? user.typePhoto + ',' + user.photo : null);
const showCropper = ref(false);
const imgDataUrl = ref('')
const showAlert = ref(false)
const jk = ref([
    {'id': 'L', 'name': 'Laki-laki'},
    {'id': 'P', 'name': 'Perempuan'},
])
const imagePreview = ref({
    status: false,
    image: null,
})

const form = useForm({
    id: user.id,
    photo: user.photo ?? null,
    typePhoto: user.typePhoto ?? null,
    name: user.name,
    email: user.email,
    phone: user.phone,
    address: user.address,
    gender: user.gender,
    date: user.date,
    place: user.place,
    width: null,
    height: null
});


watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = null;
        }
    }
);

function closeCropper() {
    showCropper.value = false
    imgDataUrl.value = null
    fotoProfil.value = user.photo !== null
    tempFoto.value = user.photo !== null ? user.typePhoto + ',' + user.photo : null
    document.getElementById('fileAvatar').value = null
}

function change({canvas}) {
    imgDataUrl.value = canvas.toDataURL("image/jpeg")
}

const changeAvatar = () => {
    document.getElementById('fileAvatar').click()
}
const imagePreviewFn = (e) => {
    imagePreview.value.status = true
    imagePreview.value.image = e.target.src
}

const saveImage = async () => {
    const data = imgDataUrl.value.split(',');
    form.typePhoto = data[0];
    form.photo = data[1];
    // await form.post(route('profile.update'))
    showCropper.value = false
    tempFoto.value = imgDataUrl.value
    imgDataUrl.value = null
    // document.getElementById('fileAvatar').value = null
}

const changeFile = async (e) => {
    const files = e.target.files[0]
    const context = document.getElementById('photoTakenMobile').getContext('2d');
    const img = new Image();
    img.src = URL.createObjectURL(files)
    img.onload = () => {
        const {
            height,
            width
        } = img;
        form.height = height / 2
        form.width = width / 2
    }
    const fileReader = new FileReader();
    fileReader.readAsDataURL(files);
    fileReader.onload = () => {
        const ims = new Image();
        ims.src = URL.createObjectURL(files)
        ims.onload = () => {
            context.drawImage(ims, 0, 0, ims.width / 2, ims.height / 2);
            const dataRaw = document.getElementById("photoTakenMobile").toDataURL("image/jpeg")
            const data = dataRaw.split(',');
            form.typePhoto = data[0];
            form.photo = data[1];
            fotoProfil.value = true
            tempFoto.value = dataRaw
            imgDataUrl.value = dataRaw
            showCropper.value = true
        }
    }
}


const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

const saveAccount = () => {
    form.post(route('profile.updateAccount'))
    showAlert.value = true
    setTimeout(() => {
        showAlert.value = false
    }, 3000)
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

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
    <teleport to="body">
        <transition leave-active-class="duration-200">
            <div v-show="show" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 items-center justify-center">
                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div v-show="show" class="fixed inset-0 transform transition-all" @click="close">
                        <div class="absolute inset-0 bg-gray-900 opacity-75"/>
                    </div>
                </transition>

                <transition
                    enter-active-class="fade-in delay-300 duration-600"
                    enter-from-class="transform transition-y-1"
                    enter-to-class="transform transition-y-0"
                    leave-active-class="fade-out duration-600"
                    leave-from-class="opacity-100 scale-100 blur-0"
                    leave-to-class="opacity-0 scale-90 blur-lg"
                >
                    <!-- drawer component -->
                    <div
                        class="fixed top-0 left-0 z-40  w-full h-screen max-w-xs sm:max-w-lg p-4 overflow-y-auto bg-gray-800">
                        <h5 id="drawer-label"
                            class="inline-flex items-center mb-6 text-sm font-semibold text-gray-400 uppercase">
                            Account</h5>
                        <button type="button" @click="close"
                                class="text-gray-400 bg-transparent hover:bg-gray-600 hover:text-white rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center">
                            <font-awesome-icon :icon="['fas', 'close']" class="w-4 h-4"/>
                            <span class="sr-only">Close menu</span>
                        </button>
                        <Modal :show="showAlert" @close="showAlert=false">
                            <Notification class="mb-0" :alerts="notification"/>
                        </Modal>

                        <form @submit.prevent="saveAccount">
                            <div class="space-y-4 grid grid-cols-1 gap-2 sm:grid-cols-2">
                                <div class="sm:col-span-2 flex flex-col items-center">
                                    <font-awesome-icon v-if="!fotoProfil" icon="fa-solid fa-circle-user"
                                                       class="w-full h-24 rounded-full object-contain text-white mb-2"/>
                                    <img id="imgAvatar" v-if="fotoProfil" @click="imagePreviewFn" :src="tempFoto"
                                         class="w-24 h-24 rounded-full object-cover border-2" alt="..."/>
                                    <secondary-button class="mt-2 w-fit" @click="changeAvatar">
                                        Ganti Foto
                                    </secondary-button>
                                    <input id="fileAvatar" type="file" accept="image/*" class="hidden"
                                           @change="changeFile"/>
                                    <canvas class="hidden" id="photoTakenMobile" :width="form.width"
                                            :height="form.height"></canvas>
                                </div>
                                <div>
                                    <InputLabel value="Nama" class="text-white"/>
                                    <TextInput :model-value="form.name" v-model="form.name" class="w-full"/>
                                </div>
                                <div>
                                    <InputLabel value="Email" class="text-white"/>
                                    <TextInput type="email" readonly :model-value="form.email" v-model="form.email"
                                               class="w-full"/>
                                </div>
                                <div>
                                    <InputLabel value="Tanggal Lahir" class="text-white"/>
                                    <TextInput type="date" :model-value="form.date" v-model="form.date" class="w-full"/>
                                </div>
                                <div>
                                    <InputLabel value="Tempat Lahir" class="text-white"/>
                                    <TextInput type="text" :model-value="form.place" v-model="form.place"
                                               class="w-full"/>
                                </div>
                                <div>
                                    <InputLabel value="No HP" class="text-white"/>
                                    <TextInput type="number" :model-value="form.phone" v-model="form.phone"
                                               class="w-full"/>
                                </div>
                                <div>
                                    <InputLabel value="Jenis Kelamin" class="text-white"/>
                                    <Select :data="jk" :model-value="form.gender" v-model="form.gender"/>
                                </div>
                                <div class="sm:col-span-2">
                                    <InputLabel value="Alamat" class="text-white"/>
                                    <TextInputArea :model-value="form.address" v-model="form.address" class="w-full"/>
                                </div>
                                <div class="sm:col-span-2 flex justify-around w-full pb-4 ">
                                    <primary-button type="submit">
                                        Save
                                    </primary-button>
                                    <danger-warning type="button" @click="close">
                                        Cancel
                                    </danger-warning>
                                </div>
                            </div>
                        </form>

                        <Modal :show="showCropper" @close="closeCropper">
                            <div class="relative">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow">
                                    <button @click="closeCropper" type="button"
                                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                                            data-modal-hide="crypto-modal">
                                        <font-awesome-icon icon="fa-solid fa-close"/>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <!-- Modal header -->
                                    <div class="px-6 py-4 border-b rounded-t bg-gray-100">
                                        <h3 class="text-base font-semibold text-gray-900 lg:text-xl ">
                                            Avatar
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
                        aspectRatio: 10 / 10,
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
                                            <img id="imgAvatar" v-if="fotoProfil" @click="imagePreviewFn"
                                                 :src="imgDataUrl"
                                                 class="w-52 h-52 rounded-full object-cover border-4 border-white drop-shadow-lg"
                                                 alt="..."/>
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
                        <loading :loading="form.processing"/>
                    </div>

                </transition>
            </div>
        </transition>
    </teleport>
</template>

<style scoped>

</style>
