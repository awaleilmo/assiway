<script setup>
import {onMounted, ref} from 'vue';
import {initFlowbite} from 'flowbite';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link} from '@inertiajs/vue3';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

const showingNavigationDropdown = ref(false);

onMounted(() => {
    initFlowbite();
})
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-900">

            <nav class="fixed top-0 z-50 w-full border-b bg-gray-800 border-gray-700">
                <div class="px-3 py-3 lg:px-5 lg:pl-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center justify-start">
                            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                                    aria-controls="logo-sidebar" type="button"
                                    class="inline-flex items-center p-2 text-sm rounded-lg sm:hidden focus:outline-none focus:ring-2 text-gray-400 hover:bg-gray-700 focus:ring-gray-600">
                                <span class="sr-only">Open sidebar</span>
                                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                          d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                                </svg>
                            </button>
                            <a href="/" class="sm:flex hidden ml-2 md:mr-24">
                                <img src="@/Assets/fav.png" class="h-8 mr-3" alt="FlowBite Logo"/>
                                <span
                                    class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap text-white">ASSI</span>
                            </a>
                        </div>
                        <header v-if="$slots.header">
                            <div class="max-w-7xl text-white font-medium mx-auto px-4 sm:px-6 lg:px-8">
                                <slot name="header"/>
                            </div>
                        </header>
                        <div class="flex items-center">
                            <div class="flex items-center ml-3">
                                <div>
                                    <button type="button"
                                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-600"
                                            aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                        <span class="sr-only">Open user menu</span>
                                        <font-awesome-icon :icon="['fas', 'circle-user']" class="w-8 h-8 rounded-full object-contain text-white"/>
                                    </button>
                                </div>
                                <div
                                    class="z-50 hidden my-4 text-base list-none divide-y rounded shadow bg-gray-700 divide-gray-600"
                                    id="dropdown-user">
                                    <div class="px-4 py-3" role="none">
                                        <p class="text-sm text-white" role="none">
                                            {{ $page.props.auth.user.name }}
                                        </p>
                                        <p class="text-sm font-medium truncate text-gray-300" role="none">
                                            {{ $page.props.auth.user.email }}
                                        </p>
                                    </div>
                                    <ul class="py-1" role="none">
<!--                                        <li>-->
<!--                                            <a :href="route('profile.edit')"-->
<!--                                               class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-600 hover:text-white"-->
<!--                                               role="menuitem">Settings</a>-->
<!--                                        </li>-->
                                        <li>
                                            <DropdownLink :href="route('logout')" method="post" as="button">Sign out</DropdownLink>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <aside id="logo-sidebar"
                   class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full border-r sm:translate-x-0 bg-gray-800 border-gray-700"
                   aria-label="Sidebar">
                <div class="h-full px-3 pb-4 overflow-y-auto bg-gray-800">
                    <ul class="space-y-2 font-medium">
                        <li>
                            <a href="/" class="flex sm:hidden p-2 md:mr-24">
                                <img src="@/Assets/fav.png" class="h-8 mr-3" alt="FlowBite Logo"/>
                                <span
                                    class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap text-white">ASSI</span>
                            </a>
                        </li>
                        <li>
                            <a href="dashboard" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group"
                                :class="{ 'bg-blue-700': route().current('dashboardAdmin') }"
                            >
                                <font-awesome-icon :icon="['fas', 'chart-pie']" class="w-5 h-5 transition duration-75 group-hover:text-white"
                                :class="route().current('dashboardAdmin') ? 'text-white' : 'text-gray-400'"
                                />
                                <span class="ml-3">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="book" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group"
                               :class="{ 'bg-blue-700': route().current('bookAdmin') }"
                            >
                                <font-awesome-icon :icon="['fas', 'book']" class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white"
                                :class="route().current('bookAdmin') ? 'text-white' : 'text-gray-400'"
                                />
                                <span class="flex-1 ml-3 whitespace-nowrap">Book</span>
                            </a>
                        </li>
                        <li>
                            <a href="invoice" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group"
                               :class="{ 'bg-blue-700': route().current('invoiceAdmin') }"
                            >
                                <font-awesome-icon :icon="['fas', 'receipt']" class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white"
                                :class="route().current('invoiceAdmin') ? 'text-white' : 'text-gray-400'"
                                />
                                <span class="flex-1 ml-3 whitespace-nowrap">Invoice</span>
                            </a>
                        </li>
                        <li>
                            <a href="user" class="flex items-center p-2 rounded-lg text-white hover:bg-gray-700 group"
                               :class="{ 'bg-blue-700': route().current('userAdmin') }"
                            >
                                <font-awesome-icon :icon="['fas', 'user-group']" class="w-5 h-5 transition duration-75 text-gray-400 group-hover:text-white"
                                :class="route().current('userAdmin') ? 'text-white' : 'text-gray-400'"
                                />
                                <span class="flex-1 ml-3 whitespace-nowrap">Users</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>

            <!-- Page Content -->
            <main>
                <!-- Page Heading -->
                <slot/>
            </main>
        </div>
    </div>
</template>
