<script setup>
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import { defineProps } from 'vue';

const props = defineProps(['form']);
</script>

<template>
    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-2">
        <h2 class="text-xl font-bold text-blue-900 border-b pb-2 flex items-center gap-2">
            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Sección III</span>
            Dirección Actual de la o el Estudiante
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <Label>Departamento</Label>
                <select v-model="form.dir_depto" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                    <option>COCHABAMBA</option>
                    <option>LA PAZ</option>
                    <option>SANTA CRUZ</option>
                    <option>ORURO</option>
                    <option>POTOSÍ</option>
                    <option>CHUQUISACA</option>
                    <option>TARIJA</option>
                    <option>BENI</option>
                    <option>PANDO</option>
                </select>
            </div>
            
            <div class="space-y-2">
                <Label>Provincia</Label>
                <Input v-model="form.dir_provincia" class="uppercase" placeholder="Ej. CERCADO" />
            </div>

            <div class="space-y-2">
                <Label>Municipio / Sección</Label>
                <Input v-model="form.dir_municipio" class="uppercase" placeholder="Ej. COCHABAMBA" />
            </div>

            <div class="space-y-2">
                <Label>Localidad / Comunidad</Label>
                <Input v-model="form.dir_localidad" class="uppercase" />
            </div>

            <div class="space-y-2">
                <Label>Zona / Villa</Label>
                <Input v-model="form.dir_zona" class="uppercase" />
            </div>
            
            <div class="space-y-2">
                <Label>Avenida / Calle</Label>
                <Input v-model="form.dir_calle" class="uppercase" />
            </div>

            <div class="space-y-2">
                <Label>Número de Vivienda</Label>
                <Input v-model="form.dir_numero" class="uppercase" placeholder="S/N" />
            </div>

            <div class="space-y-2">
                <Label>Teléfono Fijo (Opcional)</Label>
                <Input v-model="form.dir_telefono" />
            </div>

            <div class="md:col-span-2 bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                <Label class="text-yellow-900 font-bold text-base">Celular de Contacto (Obligatorio)</Label>
                <Input v-model="form.dir_celular" type="tel" class="mt-2 bg-white font-bold tracking-wider" placeholder="70000000" />
                <p class="text-xs text-yellow-700 mt-1">
                    * Este número será utilizado para enviarle comunicados importantes de la Unidad Educativa.
                </p>
            </div>
        </div>
    </div>
</template>