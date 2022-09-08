
<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>
<script>
import { ref } from 'vue';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import axios from 'axios';
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'

import Swal from 'sweetalert2'
import router from "../../router";
import Navbar from "../Estructura/Navbar.vue";


const open = ref(false)
//const opencoments = ref(false)
const crearemplado = ref(false)
const calcularhoras = ref(false)
const selected = ref([0])
export default {
    //props: ['empleados'],
    data() {
        return {
            emp_nombre: '',
            empleados: {},
            empleadospublic: {},
            emple: '',
            cal_horas: '',
            salarios: {}
        }

    },
    mounted() {
        this.empleadosFunci()
        this.empleadospublicFunci.call()
        this.salariosFunci()
    },

    beforeDestroy() {
    },

    methods: {
        abrirmodalherramientas() {
            crearemplado.value = true;
            // this.iconcerrar = 1;
        },
        cerrarherramientas() {
            open.value = false;
            this.iconcerrar = 0;
        },
        empleadosFunci() {
            axios.get('/empleadosapipublic')
                .then((response) => {
                    this.empleados = response.data[0];

                    //console.log(selected.value[0]);
                })
        },
        empleadospublicFunci() {
            axios.get('/empleadosapi')
                .then((response) => {
                    this.empleadospublic = response.data[0];
                    selected.value = response.data[0][0];
                    this.emple = selected.value;
                })
        },
        salariosFunci() {
            axios.get('/salarios')
                .then((response) => {
                    this.salarios = response.data[0];
                })
        },

        eliminarempleado(id) {

            Swal.fire({
                title: '¿Está seguro de eliminar el empleado?',
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
                    axios.post('/eliminarempleado', data, config)
                        .then((res) => {
                            midis.success = res.data.success;
                            midis.ejecucion = res.data.ejecucion;
                            console.log(midis.success);
                            console.log(midis.ejecucion);
                            if (midis.ejecucion == true) {
                                Swal.fire("Exito", "Eliminado correctamente", "success");
                            }
                        })
                    this.productosFunci()

                }
            })

        },
        eliminarsalario(id) {

            Swal.fire({
                title: '¿Está seguro de eliminar este salario?',
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
                    axios.post('/eliminarsalario', data, config)
                        .then((res) => {
                            midis.success = res.data.success;
                            midis.ejecucion = res.data.ejecucion;
                            console.log(midis.success);
                            console.log(midis.ejecucion);
                            if (midis.ejecucion == true) {
                                Swal.fire("Exito", "Eliminado correctamente", "success");
                            }
                        })
                    this.productosFunci()

                }
            })

        },

        created() {
            this.empleadosFunci()
            this.empleadospublicFunci.call()
            this.salariosFunci()
        },
        submitempleado(e) {
            e.preventDefault();
            let midis = this;
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            let data = new FormData();
            data.append('emp_nombre', this.emp_nombre);
            axios.post('/crearempleados', data, config)
                .then(function (res) {
                    midis.success = res.data.success;
                    midis.ejecucion = res.data.ejecucion;
                    console.log(midis.success);
                    console.log(midis.ejecucion);
                    if (midis.ejecucion == true) {
                        crearemplado.value = false;
                        Swal.fire("Exito", "Guardado correctamente", "success");
                    } else {
                        Swal.fire("Lo sentimos", "No se guardaron datos", "error");

                    }

                })
                .catch(function (err) {
                    midis.output = err;
                    console.log(midis.output);
                });
            this.empleadosFunci.call()
            this.emp_nombre = '';
        },
        submitcalculo(e) {
            e.preventDefault();
            let midis = this;
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            let data = new FormData();
            data.append('cal_nombreempleado', this.selected.emp_nombre);
            data.append('cal_horas', this.cal_horas);
            axios.post('/calcularhoras', data, config)
                .then(function (res) {
                    midis.success = res.data.success;
                    midis.ejecucion = res.data.ejecucion;
                    midis.nombre = res.data.nombre;
                    midis.horas = res.data.horas;
                    midis.salario = res.data.salario;
                    console.log(midis.success);
                    console.log(midis.ejecucion);
                    if (midis.ejecucion == true) {
                        calcularhoras.value = false;
                        Swal.fire("Exito", "Al Empleado:" + midis.nombre + "<br/>" + "se le debe pagar la suma de: " + midis.salario + " pesos", "success");
                    } else {
                        Swal.fire("Lo sentimos", "No se guardaron datos", "error");
                    }
                })
                .catch(function (err) {
                    midis.output = err;
                    console.log(midis.output);
                });
            this.empleadosFunci.call()
            this.salariosFunci.call()
            this.cal_horas = '';
        },

    }

}

</script>
    
<style scoped>

</style>
    
<template class="">
    <title>Empleados</title>
    <div class="inicio">


        <Navbar />

        <div class="m-8 flex gap-4 content-center">
            <div class="mt-8">
                <button type="button" @click="crearemplado = true" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 
            focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-base px-6 py-3.5 text-center 
            dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Crear un Empleado</button>

            </div>
            <div class="mt-8">
                <button type="button" @click="calcularhoras = true" class="text-white bg-emerald-700 hover:bg-emerald-800 focus:ring-4 
            focus:outline-none focus:ring-emerald-300 font-medium rounded-lg text-base px-6 py-3.5 text-center 
            dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800">Calcular horas</button>

            </div>
        </div>

        <div class="m-8 grid gap-4 content-center my-44 ">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Empleados</h5>

            <div class="overflow-x-auto relative shadow-md">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Nombre
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="empleado in empleados" :key="empleado.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ empleado.emp_nombre }}
                            </th>

                            <td class="py-4 px-6">
                                <div class="flex">
                                    <button @click="eliminarempleado(empleado.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="m-8 grid gap-4 content-center my-44 ">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Salarios</h5>

            <div class="overflow-x-auto relative shadow-md">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Nombre
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Horas
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Salario
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="salario in salarios" :key="salario.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ salario.cal_nombreempleado }}
                            </th>
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ salario.cal_horas }}
                            </th>
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ salario.cal_salario }}
                            </th>

                            <td class="py-4 px-6">
                                <div class="flex">
                                    <button @click="eliminarsalario(salario.id)">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <TransitionRoot as="template" :show="crearemplado">
            <Dialog as="div" class="relative z-10" @close="crearemplado = false">
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
                                                Crear Empleados
                                            </DialogTitle>
                                            <div className="mt-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-gray-50 px-4 py-3 sm:px-6">
                                    <div className="md:grid md:grid-cols-2 md:gap-6">
                                        <div className="mt-5 md:mt-0 md:col-span-2">
                                            <form @submit="submitempleado">
                                                <div className="shadow sm:rounded-md sm:overflow-hidden">
                                                    <div className="px-4 py-5 bg-white space-y-6 sm:p-6">
                                                        <div className="flex gap-6">

                                                            <div className="w-full">
                                                                <label htmlFor="titulo"
                                                                    className="text-md block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nombre</label>
                                                                <input type="text" id="titulo" v-model="emp_nombre"
                                                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    placeholder="" required />
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div className="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                                                        <button type="submit"
                                                            className="mt-3 w-1/3 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-emerald-400 hover:bg-indigo-700">
                                                            Guardar
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

        <TransitionRoot as="template" :show="calcularhoras">
            <Dialog as="div" class="relative z-10" @close="calcularhoras = false">
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
                                                Calcular horas
                                            </DialogTitle>
                                            <div className="mt-2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div className="bg-gray-50 px-4 py-3 sm:px-6">
                                    <div className="md:grid md:grid-cols-2 md:gap-6">
                                        <div className="mt-5 md:mt-0 md:col-span-2">
                                            <form @submit="submitcalculo">
                                                <div className="shadow sm:rounded-md sm:overflow-hidden">
                                                    <div className="px-4 py-5 bg-white space-y-6 sm:p-6">
                                                        <div className="flex gap-6">
                                                            <div className="w-full">
                                                                <label htmlFor="email"
                                                                    className="text-md block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Empleados
                                                                </label>

                                                                <Listbox as="div" v-model="selected">
                                                                    <div class="mt-1 relative">
                                                                        <ListboxButton
                                                                            class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                                            <span class="flex items-center">
                                                                                <!--<img :src="selected.avatar" alt=""
                                                                                    class="flex-shrink-0 h-6 w-6 rounded-full" />-->
                                                                                <span class="ml-3 block truncate">{{
                                                                                selected.emp_nombre
                                                                                }}</span>
                                                                            </span>
                                                                            <span
                                                                                class="ml-3 absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">

                                                                            </span>
                                                                        </ListboxButton>

                                                                        <transition
                                                                            leave-active-class="transition ease-in duration-100"
                                                                            leave-from-class="opacity-100"
                                                                            leave-to-class="opacity-0">
                                                                            <ListboxOptions
                                                                                class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-56 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                                                                <ListboxOption as="template"
                                                                                    v-for="emple in empleadospublic"
                                                                                    :key="emple.id" :value="emple"
                                                                                    v-slot="{ active, selected }">
                                                                                    <li
                                                                                        :class="[active ? 'text-white bg-indigo-600' : 'text-gray-900', 'cursor-default select-none relative py-2 pl-3 pr-9']">
                                                                                        <div class="flex items-center">
                                                                                            <!--<img :src="person.avatar"
                                                                                                alt=""
                                                                                                class="flex-shrink-0 h-6 w-6 rounded-full" />-->
                                                                                            <span
                                                                                                :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">
                                                                                                {{ emple.emp_nombre }}
                                                                                            </span>
                                                                                        </div>

                                                                                        <span v-if="selected"
                                                                                            :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">

                                                                                        </span>
                                                                                    </li>
                                                                                </ListboxOption>
                                                                            </ListboxOptions>
                                                                        </transition>
                                                                    </div>
                                                                </Listbox>
                                                            </div>
                                                            <div className="w-full">
                                                                <label htmlFor="horas"
                                                                    className="text-md block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Horas</label>
                                                                <input type="number" id="horas" v-model="cal_horas"
                                                                    className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    placeholder="" required />
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div className="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
                                                        <button type="submit"
                                                            className="mt-3 w-1/3 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-emerald-400 hover:bg-indigo-700">
                                                            Guardar
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
    