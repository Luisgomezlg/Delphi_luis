
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
    //props: ['temas'],

    data() {
        return {
            facturas: {},
            cabezafacturas: {},
        }

    },
    mounted() {
        this.facturasFunci()
        this.facturaspublicFunci.call()

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
        facturasFunci() {
            axios.get('/facturasapi')
                .then((response) => {
                    this.facturas = response.data[0];

                    //console.log(selected.value[0]);
                })
        },
        facturaspublicFunci() {
            axios.get('/facturasapipublic')
                .then((response) => {
                    this.cabezafacturas = response.data[0];

                    //console.log(selected.value[0]);
                })
        },

        created() {
            this.facturasFunci()
            this.facturaspublicFunci.call()

        },
        eliminarfactura(id) {
            //alert(id)
            Swal.fire({
                title: '¿Está seguro de eliminar esta factura?',
                showCancelButton: true,
                confirmButtonText: 'Si',
                confirmButtonColor: '#6EE7B7',
                cancelButtonText: `Cancelar`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                let midis = this;
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                let data = new FormData();
                data.append('id', id);
                if (result.isConfirmed) {
                    axios.post('/eliminarfactura', data, config)
                        .then((res) => {
                            midis.success = res.data.success;
                            midis.ejecucion = res.data.ejecucion;
                            console.log(midis.success);
                            console.log(midis.ejecucion);
                            if (midis.ejecucion == true) {
                                Swal.fire("Exito", "Eliminado correctamente", "success");
                            }
                        })
                    this.facturasFunci()
                    this.facturaspublicFunci.call()

                }
            })

        },
        eliminarcabeza(id) {

            Swal.fire({
                title: '¿Está seguro de eliminar esta cabeza de factura?',
                showCancelButton: true,
                confirmButtonText: 'Si',
                confirmButtonColor: '#6EE7B7',
                cancelButtonText: `Cancelar`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                let midis = this;
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                let data = new FormData();
                data.append('id', id);
                if (result.isConfirmed) {
                    axios.post('/eliminarcabeza', data, config)
                        .then((res) => {
                            midis.success = res.data.success;
                            midis.ejecucion = res.data.ejecucion;
                            console.log(midis.success);
                            console.log(midis.ejecucion);
                            if (midis.ejecucion == true) {
                                Swal.fire("Exito", "Eliminado correctamente", "success");
                            }
                        })
                    this.facturasFunci()
                    this.facturaspublicFunci.call()

                }
            })

        },
    }

}

</script>
    
<style scoped>

</style>
    
<template class="">
    <title>Facturas</title>
    <div class="inicio">


        <Navbar />


        <div class="m-8 grid gap-4 content-center my-44 ">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Facturas</h5>

            <div class="overflow-x-auto relative shadow-md">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Producto
                            </th>
                            <th scope="col" class="py-3 px-6">
                                cantidad
                            </th>
                            <th scope="col" class="py-3 px-6">
                                valor
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="factura in facturas" :key="factura.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ factura.pro_nombre }}
                            </th>
                            <td class="py-4 px-6">
                                {{ factura.fac_cantidad }}
                            </td>
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ factura.fac_valor }}
                            </th>
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <button @click="eliminarfactura(factura.idfactura)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="m-8 grid gap-4 content-center my-44 ">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Cabeza Facturas</h5>

            <div class="overflow-x-auto relative shadow-md">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Numero de factura
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Fecha
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Cliente
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Total
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cabeza in cabezafacturas" :key="cabeza.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ cabeza.factura_id }}
                            </th>
                            <td class="py-4 px-6">
                                {{ cabeza.cab_fecha }}
                            </td>
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ cabeza.name }}
                            </th>
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ cabeza.cab_total }}
                            </th>
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <button @click="eliminarcabeza(cabeza.id)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
    
<style>

</style>
    