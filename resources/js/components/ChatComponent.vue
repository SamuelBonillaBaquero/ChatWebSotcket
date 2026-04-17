<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link
        href="/chat"
        class="group relative flex flex-col items-center justify-center p-10 bg-blue-700 hover:bg-blue-800 text-white rounded-3xl shadow-2xl transition-all transform hover:scale-105 active:scale-95 border-4 border-blue-400"
    >
        <span class="text-6xl mb-4">💬</span>
        <span class="text-3xl font-black uppercase tracking-widest">Entrar al Chat</span>
        <p class="mt-2 text-blue-200 font-semibold text-lg">Pulsa aquí para hablar en tiempo real</p>

        <div class="absolute inset-0 rounded-3xl bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
    </Link>
</template>
