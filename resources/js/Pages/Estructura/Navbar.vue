
<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

</script>
<script>
import { ref } from 'vue';
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'

const navigation = [
    { name: 'Productos', href: '/productosauth', current: false },
    { name: 'Facturas', href: '/facturas', current: false },
    { name: 'Calculo Salarial', href: '/calculosalarial', current: false },
    { name: 'Comprar productos', href: '/', current: false },
]
const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<style scoped>
.upload-images {
    width: 100px !important;
    height: 100px !important;
}

.tool-bar-img {
    font-size: 12px;
}
</style>

<template class="">
    <Disclosure as="nav" class="bg-black" v-slot="{ open }">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <DisclosureButton
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Abrir menu</span>
                        <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                        <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
                    </DisclosureButton>
                </div>
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="block lg:hidden h-8 w-auto"
                            src="https://upload.wikimedia.org/wikipedia/commons/8/87/Avatar_poe84it.png"
                            alt="Konectaluis" />
                        <img class="hidden lg:block h-8 w-auto"
                            src="https://upload.wikimedia.org/wikipedia/commons/8/87/Avatar_poe84it.png"
                            alt="Konectaluis" />
                    </div>
                    <div class="hidden sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <Link v-for="item in navigation" :key="item.name" :href="item.href"
                                :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'px-3 py-2 rounded-md text-sm font-medium']"
                                :aria-current="item.current ? 'page' : undefined">{{ item.name }}</Link>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">


                    <!-- Profile dropdown -->
                    <Menu as="div" class="ml-3 relative">
                        <div>
                            <MenuButton
                                class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                                <span class="sr-only">Abrir usuario</span>
                                <img class="h-8 w-8 rounded-full"
                                    src="https://img.lovepik.com/element/45006/1283.png_860.png" alt="" />
                            </MenuButton>
                        </div>
                        <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <form @submit.prevent="logout">
                                    <button type="submit" href="#"
                                        class="bg-gray-100 w-full block px-4 py-2 text-sm text-gray-700">
                                        Salir
                                    </button>
                                </form>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
        </div>

        <DisclosurePanel class="sm:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <DisclosureButton v-for="item in navigation" :key="item.name" as="a" :href="item.href"
                    :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block px-3 py-2 rounded-md text-base font-medium']"
                    :aria-current="item.current ? 'page' : undefined">{{ item.name }}</DisclosureButton>
            </div>
        </DisclosurePanel>
    </Disclosure>

</template>

<style>
</style>
