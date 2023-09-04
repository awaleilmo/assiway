<script setup>
import {VueGoodTable} from 'vue-good-table-next';
import Pagination from "@/Components/Pagination.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {onBeforeMount, ref} from "vue";
const props = defineProps({
    column: {
        request: true,
    },
    searchDefault:{
        type: String,
        default: 'name'
    },
    searchActive:{
        type: Boolean,
        default: true
    },
    dataTable: {
        type: Object,
        request: true,
    },
    selectOptions: {
        type: Object,
        default: {
            enabled: true
        }
    },
    lineNumbers: {
        type: Boolean,
        default: false
    },
    maxHeight: {
        type: String,
        default: '700px'
    },
    fixedHeader: {
        type: Boolean,
        default: false
    },
    rowStyleClassFn: {
        type: String || Function,
    },
    rtl: {
        type: Boolean,
        default: false
    },
    sortOptions: {
        type: Object,
        default: {
            enabled: false
        }
    },
    onRowClick: {
        type: Function
    },
    onRowDoubleClick: {
        type: Function
    },
    onCellClick: {
        type: Function
    },
    onRowMouseover: {
        type: Function
    },
    onRowMouseleave: {
        type: Function
    },
    onPageChange: {
        type: Function
    },
    onPerPageChange: {
        type: Function
    },
    onSelectAll: {
        type: Function
    },
    selectionChanged: {
        type: Function,
    }
})

// data
const params= useForm({
    perPage: 10,
    search: '',
    column: props.searchDefault,
})
const selected= ref(
    [
        {name: 'perPage', value: '10'},
        {name: 'search', value: ''},
        {name: 'column', value: props.searchDefault},
    ]
)

// method
const start = () => {
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
}
const searchFunction = () => {
    params.get(props.dataTable.path)
}

onBeforeMount(() => {
    start()
})
/** Use of Functions in Table Events
 *
 *  onRowClick(params) {
 *     // params.row - row object
 *     // params.pageIndex - index of this row on the current page.
 *     // params.selected - if selection is enabled this argument
 *     // indicates selected or not
 *     // params.event - click event
 *   }
 *
 *   onRowDoubleClick(params) {
 *     // params.row - row object
 *     // params.pageIndex - index of this row on the current page.
 *     // params.selected - if selection is enabled this argument
 *     // indicates selected or not
 *     // params.event - click event
 *   }
 *
 *   onCellClick(params) {
 *     // params.row - row object
 *     // params.column - column object
 *     // params.rowIndex - index of this row on the current page.
 *     // params.event - click event
 *   }
 *
 *   onRowMouseover(params) {
 *     // params.row - row object
 *     // params.pageIndex - index of this row on the current page.
 *   }
 *
 *   onRowMouseleave(row, pageIndex) {
 *     // row - row object
 *     // pageIndex - index of this row on the current page.
 *   }
 *
 *   onPageChange(params) {
 *     // params.currentPage - current page that pagination is at
 *     // params.prevPage - previous page
 *     // params.currentPerPage - number of items per page
 *     // params.total - total number of items in the table
 *   }
 *
 *   onPerPageChange(params) {
 *     // params.currentPage - current page that pagination is at
 *     // params.currentPerPage - number of items per page
 *     // params.total - total number of items in the table
 *   }
 *
 *   selectionChanged(params) {
 *     // params.selectedRows - all rows that are selected (this page)
 *   }
 */
</script>
<template>
    <div v-if="searchActive" class="flex justify-end w-auto mb-2 mt-4">
        <select id="countries" v-model="params.column"
                class="flex-shrink-0 z-10 rounded-l-lg px-5 text-sm font-medium text-gray-900 bg-gray-100 border border-gray-300 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 ">
            <option v-for="(item, index) in column" v-show="item.search" :key="index"
                    :value="item.field">{{
                    item.label
                }}
            </option>
        </select>
        <div class="relative w-full">
            <input v-model="params.search" v-on:keyup.enter="searchFunction"
                   type="search" id="default-search"
                   class="block w-full p-3 text-sm text-gray-900 border-l-gray-50 border-l-2 border border-gray-300 rounded-r-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "
                   placeholder="Search ..." required>
            <button @click="searchFunction"
                    type="submit"
                    class="text-white absolute right-2.5 top-1.5 bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-1.5">
                <font-awesome-icon icon="fa-solid fa-search" class="mx-1"/>
            </button>
        </div>
    </div>
    <VueGoodTable
        :columns="column"
        :rows="dataTable.data"
        :select-options="selectOptions"
        :line-numbers="lineNumbers"
        :max-height="maxHeight"
        :fixed-header="fixedHeader"
        :row-style-class="rowStyleClassFn"
        :rtl="rtl"
        :sort-options="sortOptions"
        ref="datatab"
        v-on:selected-rows-change="selectionChanged"
        v-on:row-click="onRowClick"
        v-on:row-dblclick="onRowDoubleClick"
        v-on:cell-click="onCellClick"
        v-on:row-mouseenter="onRowMouseover"
        v-on:row-mouseleave="onRowMouseleave"
        v-on:page-change="onPageChange"
        v-on:per-page-change="onPerPageChange"
        v-on:select-all="onSelectAll"
    >
        <template #table-row="props">
            <slot name="table-row" v-bind="props"></slot>
        </template>
        <template #table-column="props">
            <slot name="table-column" v-bind="props"></slot>
        </template>
        <template #column-filter="props">
            <slot name="column-filter" v-bind="props"></slot>
        </template>
    </VueGoodTable>
    <Pagination :links="dataTable.links" :params="selected" :url="dataTable.path"/>
</template>

<style scoped>

</style>
