<script setup>
import {onMounted, onUpdated, ref} from "vue";
import gambar1 from "@/Assets/book/1.png";
import gambar2 from "@/Assets/book/2.jpg";
import gambar3 from "@/Assets/book/3.jpg";
import gambar4 from "@/Assets/book/4.jpg";
import gambar5 from "@/Assets/book/5.jpg";
const items = ref([
  {
    id:1,
    img: gambar1,
  },
  {
    id:2,
    img: gambar2,
  },
  {
    id:3,
    img: gambar3,
  },
  {
    id:4,
    img: gambar4,
  },
  {
    id:5,
    img: gambar5,
  }
])
</script>

<template>
  <div id="default-carousel" class="w-full" data-carousel="static">
    <!-- Carousel wrapper -->
    <div class="relative overflow-hidden rounded-lg h-full">
    <!--      item        -->
      <div v-for="(item, index) in items" :key="index" class="hidden duration-700 ease-in-out " data-carousel-item>
        <img :src="item.img" class="block brightness-100 w-full h-full object-cover" alt="...">
        <div
            class="bg-gradient-to-tr from-black from-40% to-transparent w-full h-full absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2"/>
        <section
            class="w-full px-6 pt-20 md:pt-16 md:px-28 flex flex-col-reverse md:flex-row h-full items-center justify-end md:justify-around absolute z-10 top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2">
          <div class="py-8 px-6 w-full mx-auto max-w-screen-xl lg:py-16">
            <h1 v-motion
                :initial="{ opacity: 0, x: 100, duration: 1000 }"
                :enter="{ opacity: 1, x: 0 }"
                :visible="{ opacity: 1, x: 0 }"
                :delay="500"
                class="mb-4 text-4xl font-extrabold md:text-left text-center tracking-tight leading-none text-white md:text-5xl lg:text-6xl ">
              Lorem ipsum dolor sit amet</h1>
            <p v-motion
               :initial="{ opacity: 0, x: 100, duration: 1000 }"
               :enter="{ opacity: 1, x: 0 }"
               :visible="{ opacity: 1, x: 0 }"
               :delay="600" class="mb-8 text-sm font-normal text-justify text-white lg:text-xl ">
              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
              industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
              scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into
              electronic typesetting, remaining essentially unchanged.
            </p>
            <div v-motion
                 :initial="{ opacity: 0, x: 100, duration: 1000 }"
                 :enter="{ opacity: 1, x: 0 }"
                 :visible="{ opacity: 1, x: 0 }"
                 :delay="700" class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
              <a href="#"
                 class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center hover:w-1/3 transition-all delay-100 ease-in-out text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 ">
                Buy Now
                <svg class="w-3.5 h-3.5 ml-2 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
              </a>
            </div>
          </div>
          <div class="md:w-full md:justify-end justify-center flex md:py-8 h-[30%] w-[70%] md:h-[80%]">
            <img v-motion
                 :initial="{ opacity: 0, y: 100, duration: 1000 }"
                 :enter="{ opacity: 1, y: 0 }"
                 :visible="{ opacity: 1, y: 0 }"
                 :delay="500"
                 :src="item.img"
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

</template>

<style scoped>

</style>
