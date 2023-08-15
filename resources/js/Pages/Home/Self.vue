<script setup>
</script>

<template>

  <div class="md:grid md:grid-cols-3 w-full grid-flow-col gap-0">
    <div class="justify-center md:justify-end flex">
      <img v-motion
           :initial="{ opacity: 0, x: -100, duration: 1000 }"
           :enter="{ opacity: 1, x: 0 }"
           :visible="{ opacity: 1, x: 0 }"
           :delay="600" src="../../assets/Asset2.png" class="w-auto md:w-[355px] h-[280px] md:h-[600px]" alt="">
    </div>
    <div class="text-center flex items-center">
      <div class="py-8 px-4 w-full mx-auto max-w-screen-xl lg:py-16">
        <h1 v-motion
            :initial="{ opacity: 0, y: -100, duration: 1000 }"
            :enter="{ opacity: 1, y: 0 }"
            :visible="{ opacity: 1, y: 0 }"
            :delay="500"
            class="mb-4 text-3xl font-extrabold tracking-tight leading-none text-white md:text-4xl lg:text-5xl ">
          KEMBANGKAN</h1>
        <h1 v-motion
            :initial="{ opacity: 0, y: -100, duration: 1000 }"
            :enter="{ opacity: 1, y: 0 }"
            :visible="{ opacity: 1, y: 0 }"
            :delay="600"
            class="mb-6 text-5xl font-extrabold tracking-tight leading-none text-white md:text-6xl lg:text-7xl ">
          SOFT SKILLS</h1>
        <p v-motion
           :initial="{ opacity: 0, y: -100, duration: 1000 }"
           :enter="{ opacity: 1, y: 0 }"
           :visible="{ opacity: 1, y: 0 }"
           :delay="600" class="mb-8 text-lg font-normal text-gray-500 lg:text-xl ">
          Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
          industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
          scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into
          electronic typesetting, remaining essentially unchanged.
        </p>
      </div>
    </div>
    <div class="justify-center md:justify-start flex">
      <img v-motion
           :initial="{ opacity: 0, x: 100, duration: 1000 }"
           :enter="{ opacity: 1, x: 0 }"
           :visible="{ opacity: 1, x: 0 }"
           :delay="600" src="../../assets/Asset3.png" class="w-auto md:w-[355px] h-[280px] md:h-[600px]" alt="">
    </div>
  </div>

</template>

<style scoped>

</style>