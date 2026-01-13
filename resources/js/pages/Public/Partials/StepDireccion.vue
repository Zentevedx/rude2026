<script setup>
import { defineProps } from 'vue';
import { Map, MapPin, Phone, GraduationCap } from 'lucide-vue-next';

const props = defineProps(['form']);
</script>

<template>
    <div class="space-y-6 sm:space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <h2 class="text-xl font-bold text-blue-900 border-b pb-4 mb-6 flex items-center gap-3">
            <Map class="w-6 h-6 text-red-600" />
            <span class="flex-1">DIRECCIÓN ACTUAL DE LA O EL ESTUDIANTE</span>
            <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-bold">Sección III</span>
        </h2>
        
        <div class="bg-white rounded-xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border-t-4 border-blue-900 ring-1 ring-gray-100">
             <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                 <div>
                    <label class="text-xs font-bold text-blue-900 uppercase mb-1 block flex items-center gap-1">
                        <MapPin class="w-3 h-3 text-red-500" /> a. Departamento
                    </label>
                    <div class="relative">
                        <select v-model="form.departamento" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 appearance-none font-medium text-sm text-gray-900 shadow-sm">
                            <option>La Paz</option>
                            <option>Oruro</option>
                            <option>Potosí</option>
                            <option>Cochabamba</option>
                            <option>Chuquisaca</option>
                            <option>Tarija</option>
                            <option>Pando</option>
                            <option>Beni</option>
                            <option>Santa Cruz</option>
                        </select>
                         <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-red-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>
                 
                 <div>
                    <label class="text-xs font-bold text-gray-700 uppercase mb-1 block">b. Provincia</label>
                    <input v-model="form.provincia" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 uppercase font-medium text-sm transition-all text-gray-900 shadow-sm">
                </div>
                 
                 <div>
                    <label class="text-xs font-bold text-gray-700 uppercase mb-1 block">c. Municipio (Sección)</label>
                    <input v-model="form.municipio" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 uppercase font-medium text-sm transition-all text-gray-900 shadow-sm">
                </div>
                 
                 <div>
                    <label class="text-xs font-bold text-gray-700 uppercase mb-1 block">d. Localidad/Comunidad</label>
                    <input v-model="form.localidad" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 uppercase font-medium text-sm transition-all text-gray-900 shadow-sm">
                </div>
                 
                 <div class="lg:col-span-2">
                    <label class="text-xs font-bold text-gray-700 uppercase mb-1 block">e. Zona/Villa</label>
                    <input v-model="form.zona" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 uppercase font-medium text-sm transition-all text-gray-900 shadow-sm">
                </div>
                 
                 <div class="lg:col-span-2">
                    <label class="text-xs font-bold text-gray-700 uppercase mb-1 block">f. Avenida/Calle</label>
                    <input v-model="form.avenida_calle" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 uppercase font-medium text-sm transition-all text-gray-900 shadow-sm">
                </div>
                 
                 <div>
                    <label class="text-xs font-bold text-gray-700 uppercase mb-1 block">g. No. Vivienda</label>
                    <input v-model="form.numero_vivienda" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm transition-all text-gray-900 shadow-sm">
                </div>
                 
                 <div>
                    <label class="text-xs font-bold text-gray-700 uppercase mb-1 block flex items-center gap-1">
                        <Phone class="w-3 h-3" /> h. Tel. Fijo
                    </label>
                    <input v-model="form.telefono_fijo" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm transition-all text-gray-900 shadow-sm">
                </div>
                 
                 <div class="bg-red-50 rounded-xl p-1 border border-red-100">
                    <label class="text-xs font-bold text-red-800 uppercase mb-1 block flex items-center gap-1 pl-2 pt-2">
                        <Phone class="w-3 h-3" /> i. Celular
                    </label>
                    <input v-model="form.celular_contacto" class="w-full p-3 bg-white border-red-200 rounded-lg focus:ring-2 focus:ring-red-100 focus:border-red-500 text-sm font-bold tracking-wider transition-all shadow-sm">
                </div>
             </div>
        </div>
    </div>
</template>