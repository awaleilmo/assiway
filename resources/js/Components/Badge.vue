<script setup>
import {computed} from "vue";

const props = defineProps({
    colorProps: {
        type: String,
        default: 'blue',
    },
    fontWidth: {
        type: String,
        default: 'sm',
    },
    borderProps:{
        type: Boolean,
        default: false
    },
    pills: {
        type: Boolean,
        default: false
    }
})

const colorClass = computed(() => {
    return {
        'blue': 'bg-blue-100 border-blue-400 text-blue-800',
        'gray': 'bg-gray-100 border-gray-500 text-gray-800',
        'red': 'bg-red-100 border-red-400 text-red-800',
        'yellow': 'bg-yellow-100 border-yellow-300 text-yellow-800',
        'green': 'bg-green-100 border-green-400 text-green-800',
        'indigo': 'bg-indigo-100 border-indigo-400 text-indigo-800',
        'purple': 'bg-purple-100 border-purple-400 text-purple-800',
        'pink': 'bg-pink-100 border-pink-400 text-pink-800',
    }[props.colorProps]
})
const fontWidthClass = computed(() => {
    return {
        'xs': 'text-xs',
        'sm': 'text-sm',
        'base': 'text-base',
        'lg': 'text-lg',
        'xl': 'text-xl',
        '2xl': 'text-2xl',
        '3xl': 'text-3xl',
        '4xl': 'text-4xl',
        '5xl': 'text-5xl',
        '6xl': 'text-6xl',
        '7xl': 'text-7xl',
        '8xl': 'text-8xl',
        '9xl': 'text-9xl',
    }[props.fontWidth]
})
const borderClass = computed(() => {
    return {
        true: 'border',
        false: ''
    }[props.borderProps]
})
const pillClass = computed(() => {
    return {
        true: 'rounded-full',
        false: 'rounded'
    }[props.pills]
})
</script>

<template>
    <span class="font-medium mr-2 px-2.5 py-0.5"
        :class="[colorClass, fontWidthClass, borderClass, pillClass].join(' ')"
    >
        <slot />
    </span>
</template>

<style scoped>

</style>
