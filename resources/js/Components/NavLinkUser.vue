<script setup>
import { ref } from 'vue'

const props = defineProps({
  activeLink: {
    type: Boolean,
  },
  Link: {
    type: String,
  }
})
</script>

<template>
  <li>
    <a :href="Link"
       :class="
       activeLink ?
       'block py-2 pl-3 pr-4 text-white hover:bg-gray-100 hover:bg-transparent border-b-2 border-blue-500 md:p-0 cursor-pointer':
       'block py-2 pl-3 pr-4 text-white hover:bg-gray-100 hover:bg-transparent border-0 hover:border-b-2 md:p-0 cursor-pointer'
        ">
      <slot />
      </a>
  </li>
</template>

<style scoped>

</style>