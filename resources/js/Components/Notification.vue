<script setup>
import {ref, watch, watchEffect} from 'vue';
import {usePage} from "@inertiajs/vue3";

const props = defineProps({
    alerts: {
        type: Object,
        default: {
            status: false
        },
        required: true
    }
})

const timeOut = ref(setTimeout(() => {
    usePage().props.flash = []
    props.alerts.status = false
}, 100))

watchEffect(() => {
    if (props.alerts.status === true) {
        clearTimeout(timeOut.value)
        timeOut.value = setTimeout(() => {
            usePage().props.flash = []
            props.alerts.status = false
        }, 3000)
    }
})

const close = () => {
    usePage().props.flash = []
    props.alerts.status = false
}
</script>
<template>
    <transition
        enter-active-class="ease-out duration-500"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="ease-in duration-400"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div v-if="alerts.status"
             :class="'p-4 mb-4 text-sm rounded-lg flex items-center '+alerts.color"
        >
                        <span class="font-medium">
                        {{ alerts.message }}
                        </span>
            <button @click="close" type="button"
                    class=" text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                <font-awesome-icon icon="fa-solid fa-close"/>
                <span class="sr-only">Close modal</span>
            </button>
        </div>
    </transition>
</template>

<style scoped>

</style>
