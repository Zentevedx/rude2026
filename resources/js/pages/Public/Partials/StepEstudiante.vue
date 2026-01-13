<script setup>
defineProps({ form: Object });

// Función simple para previsualizar o mostrar el nombre del archivo
const handleFileUpload = (event, fieldName, formObj) => {
    const file = event.target.files[0];
    if (file) {
        formObj[fieldName] = file;
    }
};
</script>

<template>
    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <h2 class="text-xl font-bold text-gray-800 border-b pb-2 border-red-500">1. Datos del Estudiante</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Carnet de Identidad *</label>
                <input v-model="form.carnet_identidad" type="text" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ej: 5234567" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Código RUDE (Si tiene)</label>
                <input v-model="form.codigo_rude" type="text" class="w-full border-gray-300 rounded-md shadow-sm bg-gray-50">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Apellido Paterno</label>
                <input v-model="form.apellido_paterno" type="text" class="w-full border-gray-300 rounded-md shadow-sm uppercase">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Apellido Materno</label>
                <input v-model="form.apellido_materno" type="text" class="w-full border-gray-300 rounded-md shadow-sm uppercase">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombres *</label>
                <input v-model="form.nombres" type="text" class="w-full border-gray-300 rounded-md shadow-sm uppercase" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento</label>
                <input v-model="form.fecha_nacimiento" type="date" class="w-full border-gray-300 rounded-md shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sexo</label>
                <select v-model="form.sexo" class="w-full border-gray-300 rounded-md shadow-sm">
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>
            </div>
        </div>

        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200 mt-6">
            <h3 class="text-[#1976D2] font-bold text-sm mb-3 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Fotografías del C.I. del Estudiante
            </h3>
            <p class="text-xs text-gray-500 mb-4">Por favor tome una foto clara del anverso y reverso del carnet.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="border-2 border-dashed border-blue-300 rounded-lg p-4 text-center bg-white hover:bg-blue-50 transition cursor-pointer relative">
                    <input 
                        type="file" 
                        accept="image/*" 
                        @change="(e) => handleFileUpload(e, 'file_ci_anverso', form)"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    >
                    <div v-if="!form.file_ci_anverso">
                        <span class="text-blue-600 font-semibold block">Subir Anverso</span>
                        <span class="text-xs text-gray-400">(Lado de la foto)</span>
                    </div>
                    <div v-else class="text-green-600 font-bold flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Foto Cargada
                    </div>
                </div>

                <div class="border-2 border-dashed border-blue-300 rounded-lg p-4 text-center bg-white hover:bg-blue-50 transition cursor-pointer relative">
                    <input 
                        type="file" 
                        accept="image/*" 
                        @change="(e) => handleFileUpload(e, 'file_ci_reverso', form)"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    >
                    <div v-if="!form.file_ci_reverso">
                        <span class="text-blue-600 font-semibold block">Subir Reverso</span>
                        <span class="text-xs text-gray-400">(Lado de los datos)</span>
                    </div>
                    <div v-else class="text-green-600 font-bold flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Foto Cargada
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>