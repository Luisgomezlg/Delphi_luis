
<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>
<script>
import { ref } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import axios from 'axios';
import Swal from 'sweetalert2'
import router from "../../router";
import Navbar from "../Estructura/Navbar.vue";


const open = ref(false)
//const opencoments = ref(false)
const crearproducto = ref(false)


export default {
    props: ['producto_id'],
    data() {
        return {
            productos: {},
            productospublic: {},
            producto: {
                pro_nombre: '',
                pro_precio: ''
            },

        }

    },
    mounted() {
        this.productosFunci()
        this.productospublicFunci.call()
        this.producto = this.producto_id
    },

    beforeDestroy() {
    },

    methods: {
        abrirmodalherramientas() {
            crearproducto.value = true;
            // this.iconcerrar = 1;
        },

        cerrarherramientas() {
            open.value = false;
            this.iconcerrar = 0;
        },
        productosFunci() {
            axios.get('/productosapi')
                .then((response) => {
                    this.productos = response.data[0];

                    //console.log(selected.value[0]);
                })
        },
        productospublicFunci() {
            axios.get('/productosapipublic')
                .then((response) => {
                    this.productospublic = response.data[0];

                    //console.log(this.productospublic[0])
                })
        },

        created() {
            this.productosFunci()
            this.productospublicFunci.call()

        },
        updateProduct(e) {
            e.preventDefault();
            let midis = this;
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            let data = new FormData();
            data.append('id', this.producto.id);
            data.append('pro_nombre', this.producto.pro_nombre);
            data.append('pro_precio', this.producto.pro_precio);
            axios
                .post('/actualizarproducto/', data, config)
                .then((res) => {
                    router.back();
                    midis.success = res.data.success;
                    midis.ejecucion = res.data.ejecucion;
                    console.log(midis.success);
                    console.log(midis.ejecucion);
                    if (midis.ejecucion == true) {
                        Swal.fire("Exito", "Actualizado correctamente", "success");
                    }
                });

        },
    }

}

</script>

<style scoped>
</style>

<template class="">
    <title>Editar Productos</title>
    <div class="inicio">

       <Navbar/>

        <TransitionRoot as="template" :show="crearproducto = true">
            <Dialog as="div" class="relative z-10">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                    enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                </TransitionChild>

                <div class="grid justify-items-center fixed z-10 inset-0 overflow-y-auto">
                    <div
                        class="flex items-end sm:items-center  justify-center max-w-5xl min-h-full p-4 text-center sm:p-0">
                        <TransitionChild as="template" enter="ease-out duration-300"
                            enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                            leave-from="opacity-100 translate-y-0 sm:scale-100"
                            leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">


                            <DialogPanel
                                className="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all">
                                <div className="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div className="sm:flex sm:items-start">
                                        <div className="mt-12 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                            <DialogTitle as="h3"
                                                className="text-lg mt-3 leading-6 font-medium text-gray-900">
                                                Actualizar producto
                                            </DialogTitle>
                                            <div className="mt-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-gray-50 px-4 py-3 sm:px-6">
                                    <div className="md:grid md:grid-cols-2 md:gap-6">
                                        <div className="mt-5 md:mt-0 md:col-span-2">
                                            <form @submit="updateProduct">
                                                <div className="shadow sm:rounded-md sm:overflow-hidden">
                                                    <div className="px-4 py-5 bg-white space-y-6 sm:p-6">
                                                        <div className="flex gap-6">

                                                            <div className="w-full">
                                                                <label htmlFor="titulo"
                                                                    className="text-md block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nombre</label>
                                                                <input type="text" id="titulo"
                                                                    v-model="producto.pro_nombre"
                                                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    placeholder="" required />
                                                            </div>
                                           

                                                            <div className="w-full">
                                                                <label htmlFor="pos_color"
                                                                    className="text-md block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Precio</label>
                                                                <input type="text" v-model="producto.pro_precio"
                                                                    id="pos_color"
                                                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div className="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                                                        <button type="submit"
                                                            className="mt-3 w-1/3 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-emerald-400 hover:bg-indigo-700">
                                                            Actualizar
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div className="bg-gray-50 px-4 py-3 sm:px-6">

                                    </div>
                                </div>
                            </DialogPanel>


                        </TransitionChild>
                    </div>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<style>

</style>
