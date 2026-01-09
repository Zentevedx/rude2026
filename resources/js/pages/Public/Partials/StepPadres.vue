<script setup>
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import { defineProps } from 'vue';

const props = defineProps(['form']);
</script>

<template>
    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-2">
        <h2 class="text-xl font-bold text-blue-900 border-b pb-2 flex items-center gap-2">
            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Sección V</span>
            Datos del Padre, Madre o Tutor
        </h2>

        <div class="border rounded-lg p-5 relative bg-white shadow-sm">
            <span class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-gray-500 uppercase">Datos del Padre</span>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                <div><Label>Cédula de Identidad</Label><Input v-model="form.padre_ci" /></div>
                <div><Label>Apellido Paterno</Label><Input v-model="form.padre_paterno" class="uppercase" /></div>
                <div><Label>Apellido Materno</Label><Input v-model="form.padre_materno" class="uppercase" /></div>
                <div><Label>Nombres</Label><Input v-model="form.padre_nombres" class="uppercase" /></div>
                <div><Label>Ocupación Laboral</Label><Input v-model="form.padre_ocupacion" class="uppercase" /></div>
                <div><Label>Grado de Instrucción</Label><Input v-model="form.padre_grado" class="uppercase" /></div>
            </div>
        </div>

        <div class="border rounded-lg p-5 relative bg-white shadow-sm">
            <span class="absolute -top-3 left-4 bg-white px-2 text-sm font-bold text-gray-500 uppercase">Datos de la Madre</span>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                <div><Label>Cédula de Identidad</Label><Input v-model="form.madre_ci" /></div>
                <div><Label>Apellido Paterno</Label><Input v-model="form.madre_paterno" class="uppercase" /></div>
                <div><Label>Apellido Materno</Label><Input v-model="form.madre_materno" class="uppercase" /></div>
                <div><Label>Nombres</Label><Input v-model="form.madre_nombres" class="uppercase" /></div>
                <div><Label>Ocupación Laboral</Label><Input v-model="form.madre_ocupacion" class="uppercase" /></div>
                <div><Label>Grado de Instrucción</Label><Input v-model="form.madre_grado" class="uppercase" /></div>
            </div>
        </div>

        <div class="border-2 border-blue-100 rounded-lg p-5 relative bg-blue-50">
            <span class="absolute -top-3 left-4 bg-blue-100 px-2 text-sm font-bold text-blue-800 uppercase">Datos del Tutor (Responsable de Inscripción)</span>
            <p class="text-xs text-blue-600 mb-4">Llene esta sección solo si el tutor es una persona distinta al padre o la madre (Ej. Abuela, Tío).</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div><Label>Cédula de Identidad (*)</Label><Input v-model="form.tutor_ci" required /></div>
                <div><Label>Apellido Paterno</Label><Input v-model="form.tutor_paterno" class="uppercase" /></div>
                <div><Label>Apellido Materno</Label><Input v-model="form.tutor_materno" class="uppercase" /></div>
                <div><Label>Nombres (*)</Label><Input v-model="form.tutor_nombres" class="uppercase" required /></div>
                <div><Label>Parentesco (*)</Label><Input v-model="form.tutor_parentesco" placeholder="Ej. ABUELA" class="uppercase" required /></div>
                <div><Label>Ocupación</Label><Input v-model="form.tutor_ocupacion" class="uppercase" /></div>
            </div>
        </div>
    </div>
</template>