<script setup>
import {onMounted, onUpdated, ref} from "vue";
import gambar1 from "@/Assets/book/1.png";
import gambar2 from "@/Assets/book/2.jpg";
import gambar3 from "@/Assets/book/3.jpg";
import gambar4 from "@/Assets/book/4.jpg";
import gambar5 from "@/Assets/book/5.jpg";
import {useForm, usePage} from "@inertiajs/vue3";
import InvoiceModel from "@/Model/InvoiceModel.js";
import {formatter} from "@/Configuration/sys.js";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Login from "@/Pages/Auth/Login.vue";
import Loading from "@/Components/Loading.vue";
const props = defineProps({
    items:{
        type:Object
    }
})
const loadings = ref(false)
const show = ref(false)
const showInvoice = ref(false)
const alerts = ref({
    color: 'bg-red-50 text-red-600',
    status: false,
    message: '',
})
const formInvoice = useForm({
    user_id: usePage().props.auth.user ? usePage().props.auth.user.id : null,
    book_id: null,
    price: null,
})
const bayarSave = (data) => {
    loadings.value = true
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
            loadings.value = false
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
        formInvoice.book_id = data.id
        formInvoice.price = data.price
        let saveData = await InvoiceModel.createInvoice(formInvoice)
        if(saveData.success){
            loadings.value = false
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
        loadings.value = false
        return alerts.value = {
            color: 'bg-red-50 text-red-600',
            status: true,
            message: saveData.data.message,
        }

    }, 2000)
}

</script>

<template>
  <div id="default-carousel" class="w-full" data-carousel="static" v-if="items.length > 0">
    <!-- Carousel wrapper -->
    <div class="relative overflow-hidden rounded-lg h-full">
    <!--      item        -->
      <div v-for="(item, index) in items" :key="index" class="hidden duration-700 ease-in-out " data-carousel-item>
        <img :src="item.coverType+','+item.cover" class="block brightness-100 w-full h-full object-cover" alt="...">
        <div
            class="bg-gradient-to-tr from-black from-40% to-transparent w-full h-full absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2"/>
        <section
            class="w-full px-6 pt-20 md:pt-16 md:px-28 flex flex-col-reverse md:flex-row h-full items-center justify-end md:justify-around absolute z-10 top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2">
          <div class="py-8 px-6 w-full mx-auto max-w-screen-xl lg:py-16">
            <h1 v-motion
                :initial="{ opacity: 0, x: 100, duration: 1000 }"
                :enter="{ opacity: 1, x: 0 }"
                :delay="500"
                class="mb-4 text-4xl font-extrabold md:text-left text-center tracking-tight leading-none text-white md:text-5xl lg:text-6xl ">
              {{ item.name }}</h1>
            <p v-motion
               :initial="{ opacity: 0, x: 100, duration: 1000 }"
               :enter="{ opacity: 1, x: 0 }"
               :delay="600" class="mb-8 text-sm font-normal text-justify text-white lg:text-xl ">
              {{ item.description }}
            </p>
            <div v-motion
                 :initial="{ opacity: 0, x: 100, duration: 1000 }"
                 :enter="{ opacity: 1, x: 0 }"
                 :delay="700" class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
              <primary-button @click="bayarSave(item)"
                 class="inline-flex justify-center items-center hover:scale-105 ">
                Buy Now
                <font-awesome-icon class="ml-2" :icon="['fas', 'arrow-right']" />
              </primary-button>
            </div>
          </div>
          <div class="md:w-full md:justify-end justify-center flex md:py-8 h-[30%] w-[70%] md:h-[80%]">
            <img v-motion
                 :initial="{ opacity: 0, y: 100, duration: 1000 }"
                 :enter="{ opacity: 1, y: 0 }"
                 :delay="500"
                 :src="item.coverType+','+item.cover"
                 class="block drop-shadow-lg rounded w-[80%] h-[calc(100%-1rem)] md:w-[80%] lg:w-auto" alt="...">
          </div>
        </section>
      </div>
    </div>
    <!-- Slider indicators -->
    <div class="absolute hidden md:flex z-30 space-x-3 -translate-x-1/2 bottom-5 left-1/2">
      <button v-for="(item, index) in items" :key="index" type="button" class="w-3 h-3 rounded-full" :aria-current="index === 0" aria-label="Slide 1"
              :data-carousel-slide-to="index"></button>
    </div>
    <!-- Slider controls -->
    <button type="button"
            class="absolute top-0 left-0 z-30 flex hover:scale-90 items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
        <span
            class="inline-flex items-center justify-center h-7 w-7 md:w-14 md:h-14 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="h-3 w-3 md:w-4 md:h-4 text-white dark:text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 1 1 5l4 4"/>
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button"
            class="absolute top-0 right-0 z-30 flex hover:scale-90 items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
        <span
            class="inline-flex items-center justify-center h-7 w-7 md:w-14 md:h-14 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="h-3 w-3 md:w-4 md:h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 9 4-4-4-4"/>
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
  </div>

    <Loading :loading="loadings"/>

</template>

<style scoped>

</style>
