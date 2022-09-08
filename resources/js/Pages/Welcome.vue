<script setup>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Swal from 'sweetalert2'
    import { ref } from 'vue';
    import router from "../router";
    import axios from 'axios';
    const props = defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
        productos: Array,
    });
    
    const products = props.productos;
    const vacio = products;
    const count = vacio.length;
    console.log(count);

    const comprar = (id, precio) => {
        Swal.fire({
            title: '¿Desea hacer esta compra?',
            showCancelButton: true,
            confirmButtonText: 'Si',
            confirmButtonColor: '#6EE7B7',
            cancelButtonText: `Cancelar`,
    
        }).then((result) => {
    
            let midis = this;
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }
            let data = new FormData();
            data.append('venta_producto', id);
            data.append('venta_cantidad', 1);
            data.append('venta_precio', precio);
            if (result.isConfirmed) {
                axios.post('/comprarproducto', data, config)
                    .then((res) => {
                        console.log(res.data.ejecucion);
                        if (res.data.ejecucion == true) {
                            Swal.fire("Compra con éxito", "En un momento recibirá su pedido", "success");
                        }
                    })
            }
        })
    }
    
    </script>
    <script>
    
    </script>
    
    <template>
    
        <Head title="Productos" />
    
        <div class="relative flex items-top justify-center min-h-screen bg-white dark:bg-gray-900 sm:items-center sm:pt-0">
            <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                <Link v-if="$page.props.user" :href="'productosauth'"
                    class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-600 focus:outline-none focus:border-emerald-600 focus:ring focus:ring-emerald-300 disabled:opacity-25 transition ml-4">Panel</Link>
    
                <template v-else>
                    <Link :href="route('login')" class="text-sm text-gray-700 dark:text-gray-500 underline">Ingresar</Link>
    
                    <Link v-if="canRegister" :href="route('register')"
                        class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Registrarse</Link>
                </template>
    
            </div>
            <div class="flex justify-center ...">
                <div class="bg-white">
                    <div v-show="count <= 0">
                        <h1 class="text-3xl	">Aquí se verán los productos cuando sean creados</h1>
                    </div>
                    <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                        <div
                            class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                            <div v-for="product in products" :key="product.id" class="group">
                                <div
                                    class="w-full aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden xl:aspect-w-7 xl:aspect-h-8">
                                    <img src="producto.png"
                                        class="w-full h-full object-center object-cover group-hover:opacity-75" />
                                </div>
                                <h3 class="mt-4 text-sm text-gray-700">
                                    {{ product.pro_nombre }}
                                </h3>
                                <p class="mt-1 text-lg font-medium text-gray-900">
                                    {{ product.pro_precio }}
                                </p>
    
                                <button @click="comprar(product.id, product.pro_precio)" type="submit"
                                    className="mt-3 w-1/3 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border duration-700 border-transparent rounded-md shadow-sm text-base font-medium text-white bg-emerald-400 hover:bg-emerald-700">
                                    comprar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    
    </template>
    