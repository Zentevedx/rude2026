<script setup>
import { defineProps } from 'vue';

const props = defineProps(['form']);

const handleFile = (e, field) => {
    const file = e.target.files[0];
    if (file) {
        props.form[field] = file;
    }
};
</script>

<template>
    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-2">
        <h2 class="text-xl font-bold text-red-700 border-b border-red-200 pb-2 flex items-center gap-2">
            <span class="text-2xl">📸</span>
            Verificación Documental
        </h2>
        
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <p class="text-sm text-blue-900">
                <strong>Importante:</strong> Para validar la inscripción y verificar los datos ingresados, debe subir fotografías claras o escaneos del <strong>Carnet de Identidad</strong>.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="space-y-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-blue-100 text-blue-800 font-bold px-2 py-1 rounded text-xs">ESTUDIANTE</span>
                    <h3 class="font-bold text-gray-800">Cédula de Identidad</h3>
                </div>

                <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 hover:border-blue-400 transition-all group">
                    <input type="file" @change="e => handleFile(e, 'foto_ci_est_anverso')" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                    
                    <div v-if="form.foto_ci_est_anverso" class="flex flex-col items-center text-green-600">
                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold text-sm">Foto Anverso Cargada</span>
                        <span class="text-xs text-gray-500">{{ form.foto_ci_est_anverso.name }}</span>
                    </div>
                    <div v-else class="flex flex-col items-center text-gray-400 group-hover:text-blue-500">
                        <span class="text-3xl mb-2">🪪</span>
                        <span class="font-bold text-sm">Subir ANVERSO (Frente)</span>
                        <span class="text-xs mt-1">Toque aquí para seleccionar</span>
                    </div>
                </div>

                <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 hover:border-blue-400 transition-all group">
                    <input type="file" @change="e => handleFile(e, 'foto_ci_est_reverso')" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                    
                    <div v-if="form.foto_ci_est_reverso" class="flex flex-col items-center text-green-600">
                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold text-sm">Foto Reverso Cargada</span>
                    </div>
                    <div v-else class="flex flex-col items-center text-gray-400 group-hover:text-blue-500">
                        <span class="text-3xl mb-2">🔄</span>
                        <span class="font-bold text-sm">Subir REVERSO (Atrás)</span>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center gap-2 mb-2">
                    <span class="bg-gray-200 text-gray-800 font-bold px-2 py-1 rounded text-xs">PADRE O TUTOR</span>
                    <h3 class="font-bold text-gray-800">Cédula de Identidad</h3>
                </div>

                <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 hover:border-blue-400 transition-all group">
                    <input type="file" @change="e => handleFile(e, 'foto_ci_tut_anverso')" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                    
                    <div v-if="form.foto_ci_tut_anverso" class="flex flex-col items-center text-green-600">
                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold text-sm">Foto Anverso Cargada</span>
                         <span class="text-xs text-gray-500">{{ form.foto_ci_tut_anverso.name }}</span>
                    </div>
                    <div v-else class="flex flex-col items-center text-gray-400 group-hover:text-blue-500">
                        <span class="text-3xl mb-2">🪪</span>
                        <span class="font-bold text-sm">Subir ANVERSO (Frente)</span>
                    </div>
                </div>

                <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-gray-50 hover:border-blue-400 transition-all group">
                    <input type="file" @change="e => handleFile(e, 'foto_ci_tut_reverso')" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                    
                    <div v-if="form.foto_ci_tut_reverso" class="flex flex-col items-center text-green-600">
                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold text-sm">Foto Reverso Cargada</span>
                    </div>
                    <div v-else class="flex flex-col items-center text-gray-400 group-hover:text-blue-500">
                        <span class="text-3xl mb-2">🔄</span>
                        <span class="font-bold text-sm">Subir REVERSO (Atrás)</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>