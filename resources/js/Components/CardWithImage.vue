<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
</script>

<template>

    <div class="max-w-sm m-2 bg-white border border-gray-200 rounded-lg shadow">
        <slot name="image">
            <img src="https://flowbite.com/docs/images/blog/image-1.jpg" class="rounded-t-lg" alt="image"/>
        </slot>
        <div class="p-5">

            <div>
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
                    <slot name="header">
                        Noteworthy technology
                        acquisitions 2021
                    </slot>
                </h5>
            </div>
            <p class="mb-3 font-normal text-gray-700">
                <slot name="description">
                    Here are the biggest enterprise technology
                    acquisitions of 2021 so far, in reverse chronological order.
                </slot>
            </p>
            <slot name="button">
                <primary-button class="inline-flex items-center">
                    <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </primary-button>
                Read more
            </slot>
        </div>
    </div>

</template>


<style scoped>

</style>
