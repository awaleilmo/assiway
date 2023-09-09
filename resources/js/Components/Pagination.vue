<script setup>
import {Link, useForm} from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import Select from '@/Components/Select.vue';
import {onMounted, ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    links: {
        type: Array,
        required: true
    },
    params: {
        type: Object,
        required: true
    },
    url: {
        type: String,
        required: true
    }
})

const parameter = ref('')
const perPages = ref([
    {id: '10', name: '10'},
    {id: '20', name: '20'},
    {id: '50', name: '50'},
    {id: '100', name: '100'},
])
const perPage = ref('10')

const start = () => {
    const dataParams = props.params
    if (dataParams.search !== '') {
        dataParams.forEach((item) => {
            if (item.name === 'perPage') {
                perPage.value = item.value
                parameter.value += '&' + item.name + '=' + item.value
            } else if (item.name !== 'page') {
                parameter.value += '&' + item.name + '=' + item.value
            }
        })
    }
}
const change = () => {
    const dataParams = props.params
    const dataLink = props.links.find((item) => item.active === true)
    parameter.value = ''
    if (dataParams.search !== '') {
        dataParams.forEach((item) => {
            if (item.name === 'perPage') {
                parameter.value += '&' + item.name + '=' + perPage.value
            } else if (item.name !== 'page') {
                parameter.value += '&' + item.name + '=' + item.value
            }
        })
    }
    window.location.href = dataLink.url + parameter.value
}
onMounted(() => {
    start()
})
</script>
<template>
    <div>
        <div class="flex justify-end flex-wrap my-3">
            <InputLabel value="rows per page" class="px-3 py-2 mb-1 mr-1 text-base leading-4 text-gray-200  font-semibold"/>
            <Select @change="change"
                    class="min-w-[48px] max-w-[100px] px-3 py-2 mb-1 mr-7 text-xs leading-4 text-gray-400  font-normal"
                    :data="perPages" :model-value="perPage" v-model="perPage"/>
            <template v-for="(link, key) in links">
                <primary-button  v-if="link.url === null" :key="key" :class="{ 'opacity-50': true }"
                                 :disabled="true"
                                 class="
                                        mb-1
                                        mr-1
                                        text-sm
                                    "
                                 v-html="link.label"/>
                <div v-else class="mb-1 mr-1">
                    <primary-button  v-if="link.active" :key="key" :class="{ 'opacity-20': link.active }"
                                     :disabled="true"
                                     v-html="link.label"/>
                    <a v-else :href="link.url + parameter">
                        <primary-button v-html="link.label" />
                    </a>
                </div>
            </template>
        </div>
    </div>
</template>
