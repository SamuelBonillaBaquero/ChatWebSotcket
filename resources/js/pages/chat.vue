<script setup>

//1. Importamos las bibliotecas necesarias para el chat
import {ref, onMounted, watch, nextTick} from 'vue'; //poder usar las variables magicas que tanto nos gustan
import axios from 'axios'; //poder hacer las peticiones que nececitemos
import {Head} from '@inertiajs/vue3'

//2. objetenemos las props que nececitamos para cargar el chat
const props = defineProps({
    mensajes : Array
});

//3. Reactividad: Variables vigiladas por vue para actualizar la pantalla
const scrollContainer = ref(null);
const listaMensajes = ref([...props.mensajes]); // aqui nececitamos crear una nueva variable ya que al venir por inertia es dfe solo lectura
const nuevoMensaje = ref('');
const enviando = ref(false);

// 3. enviamos los mensajes a la API para la creacion en BD y repartirlo a traves del websockect
const enviarChat = async() => {
    if(nuevoMensaje.value.trim() === '') return;

    enviando.value = true;

    try {
        const response = await axios.post('/chat',{
            content: nuevoMensaje.value
        })

        listaMensajes.value.push(response.data);
        nuevoMensaje.value = '';
    } catch (error){
        console.error("Error al enviar con Axios:", error)
    } finally {
        enviando.value = false
    }

}

const scrollToBottom = () => {
    if(scrollContainer.value){
        scrollContainer.value.scrollTop = scrollContainer.value.scrollHeight;
    }
}

watch (()=>listaMensajes.value,
    async() =>{
        await nextTick();
        scrollToBottom();
    },{
        deep:true
    }
);

//5. montamos la radio necesaria para escuchar el websockect

onMounted(() => {
    window.Echo.channel('MyChat').listen('MessageCreate',(e) => {
        console.log("!Mensaje recibido", e.message);
        listaMensajes.value.push(e.message);
        //const existe = listaMensajes.value.some(m=> m.id === e.message.id)

        /*if(!existe) {
            listaMensajes.value.push(e.message);
        }*/

    });
    scrollToBottom();
});

</script>

<template>
    <Head title="Chat TFG" />
    <div class="p-6 max-w-2xl mx-auto bg-white shadow-xl rounded-lg mt-10 border border-gray-200">
        <h1 class="text-3xl font-extrabold mb-4 border-b-2 pb-2 text-black">Canal de Chat</h1>

        <div ref="scrollContainer" class="h-80 overflow-y-auto mb-4 p-4 border rounded bg-gray-100 flex flex-col gap-3">
            <div v-for="m in listaMensajes" :key="m.id"
                :class="m.user_id === $page.props.auth.user.id ? 'text-right' : 'text-left'">

                <div :class="m.user_id === $page.props.auth.user.id
                    ? 'bg-blue-700 text-white'
                    : 'bg-white text-black border border-gray-300'"
                     class="inline-block px-4 py-2 rounded-lg shadow-md max-w-[80%]">

                    <p class="text-sm font-black block mb-1 underline"
                       :class="m.user_id === $page.props.auth.user.id ? 'text-blue-100' : 'text-black'"
                       v-if="m.user">
                        {{ m.user.name }}
                    </p>

                    <p class="text-base font-medium leading-tight">{{ m.content }}</p>
                </div>
            </div>
        </div>

        <form @submit.prevent="enviarChat" class="flex gap-2">
            <input v-model="nuevoMensaje"
                   type="text"
                   placeholder="Escribe un mensaje..."
                   class="flex-1 border-2 border-gray-400 p-3 rounded text-black font-semibold focus:outline-none focus:border-blue-800 focus:ring-1 focus:ring-blue-800 shadow-inner"
            >
            <button type="submit"
                    :disabled="enviando"
                    class="bg-blue-800 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-900 transition-colors shadow-md disabled:bg-gray-500">
                {{ enviando ? '...' : 'Enviar' }}
            </button>
        </form>
    </div>
</template>
