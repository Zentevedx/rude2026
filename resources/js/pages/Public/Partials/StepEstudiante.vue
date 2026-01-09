<script setup>
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import { defineProps } from 'vue';

const props = defineProps(['form']);
</script>

<template>
    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-2">
        <h2 class="text-lg font-bold text-blue-900 border-b pb-2">II. Datos de la o el Estudiante</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-3 bg-red-50 p-4 rounded border border-red-200">
                <Label class="text-red-800 font-bold">CÓDIGO RUDE (Obligatorio)</Label>
                <Input v-model="form.codigo_rude" class="mt-1 text-center font-mono text-xl tracking-widest uppercase" placeholder="XXXXXXXXXXXX" />
                <span v-if="form.errors.codigo_rude" class="text-red-600 text-xs font-bold">{{ form.errors.codigo_rude }}</span>
            </div>

            <div><Label>Apellido Paterno</Label><Input v-model="form.apellido_paterno" class="uppercase" /></div>
            <div><Label>Apellido Materno</Label><Input v-model="form.apellido_materno" class="uppercase" /></div>
            <div><Label>Nombres</Label><Input v-model="form.nombres" class="uppercase" /></div>

            <div><Label>Fecha Nacimiento</Label><Input type="date" v-model="form.fecha_nacimiento" /></div>
            <div>
                <Label>Sexo</Label>
                <select v-model="form.sexo" class="w-full border rounded p-2 text-sm">
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>
            </div>
             <div>
                <Label>País Nac.</Label>
                <Input v-model="form.nac_pais" class="uppercase" />
            </div>
            
            <div><Label>Depto. Nac.</Label><Input v-model="form.nac_depto" class="uppercase" /></div>
             <div><Label>Provincia Nac.</Label><Input v-model="form.nac_provincia" class="uppercase" /></div>
             <div><Label>Localidad Nac.</Label><Input v-model="form.nac_localidad" class="uppercase" /></div>

            <div class="md:col-span-3 mt-4">
                <Label class="text-gray-500 text-xs uppercase font-bold">Datos del Certificado de Nacimiento</Label>
                <div class="grid grid-cols-4 gap-2 mt-1">
                    <Input v-model="form.cert_oficialia" placeholder="Oficialía" />
                    <Input v-model="form.cert_libro" placeholder="Libro" />
                    <Input v-model="form.cert_partida" placeholder="Partida" />
                    <Input v-model="form.cert_folio" placeholder="Folio" />
                </div>
            </div>
            
            <div class="md:col-span-3 mt-4 grid grid-cols-3 gap-4">
                 <div><Label>C.I. Estudiante</Label><Input v-model="form.ci_estudiante" /></div>
                 <div><Label>Complemento</Label><Input v-model="form.ci_complemento" placeholder="Ej. 1A" class="uppercase"/></div>
                 <div><Label>Expedido</Label><Input v-model="form.ci_expedido" placeholder="CB" class="uppercase" /></div>
            </div>
        </div>
    </div>
</template>