<script setup>
import Label from '@/components/ui/label/Label.vue';
import Input from '@/components/ui/input/Input.vue';
import Checkbox from '@/components/ui/checkbox/Checkbox.vue';
import { defineProps } from 'vue';

const props = defineProps(['form']);
</script>

<template>
    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-2">
        <h2 class="text-xl font-bold text-blue-900 border-b pb-2 flex items-center gap-2">
            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">Sección IV</span>
            Aspectos Socioeconómicos
        </h2>

        <div class="bg-gray-50 p-4 rounded-lg border">
            <h3 class="font-bold text-gray-700 mb-3 text-sm uppercase">4.1 Idioma y Cultura</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <Label class="text-xs">4.1.1 ¿Cuál es el idioma que aprendió en su niñez?</Label>
                    <Input v-model="form.socio_idioma_ninez" class="uppercase" />
                </div>
                <div class="space-y-1">
                    <Label class="text-xs">4.1.3 Nación/Pueblo Originario (Autoidentificación)</Label>
                    <select v-model="form.socio_nacion" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm uppercase">
                        <option value="">Ninguno</option>
                        <option>QUECHUA</option>
                        <option>AYMARA</option>
                        <option>GUARANÍ</option>
                        <option>MESTIZO</option>
                        <option>AFROBOLIVIANO</option>
                        <option>OTRO</option>
                    </select>
                </div>
                <div class="md:col-span-2 space-y-2">
                    <Label class="text-xs">4.1.2 ¿Qué idiomas habla frecuentemente? (En orden)</Label>
                    <div class="grid grid-cols-3 gap-2">
                        <Input v-model="form.socio_idioma_frec1" placeholder="1er Idioma" class="uppercase" />
                        <Input v-model="form.socio_idioma_frec2" placeholder="2do (Opcional)" class="uppercase" />
                        <Input v-model="form.socio_idioma_frec3" placeholder="3ro (Opcional)" class="uppercase" />
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border">
            <h3 class="font-bold text-gray-700 mb-3 text-sm uppercase">4.2 Salud</h3>
            <div class="space-y-4">
                <div class="space-y-1">
                    <Label class="text-xs">4.2.1 ¿Existe algún Centro de Salud/Posta cerca de su casa?</Label>
                    <select v-model="form.salud_centro" class="w-full border rounded p-2 text-sm uppercase">
                        <option value="SI">SÍ</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
                 <div class="space-y-1">
                    <Label class="text-xs">4.2.2 ¿Dónde acude cuando se enferma?</Label>
                    <select v-model="form.salud_centro" class="w-full border rounded p-2 text-sm uppercase">
                        <option>Caja Nacional de Salud / Seguro</option>
                        <option>Centro de Salud / Hospital Público</option>
                        <option>Consultorio Privado</option>
                        <option>Medicina Tradicional</option>
                        <option>Farmacia / Automedicación</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                     <Checkbox id="seguro" :checked="form.salud_seguro" @update:checked="val => form.salud_seguro = val" />
                     <Label for="seguro">4.2.3 El estudiante cuenta con seguro de salud</Label>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border">
            <h3 class="font-bold text-gray-700 mb-3 text-sm uppercase">4.3 Servicios Básicos</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <Label class="text-xs mb-1 block">Acceso a Agua</Label>
                    <select v-model="form.serv_agua" class="w-full border rounded p-2 text-sm uppercase">
                        <option>Cañería de Red Pública</option>
                        <option>Pileta Pública</option>
                        <option>Carro Cisterna</option>
                        <option>Pozo</option>
                    </select>
                </div>
                <div>
                    <Label class="text-xs mb-1 block">Baño / Alcantarillado</Label>
                    <select v-model="form.serv_alcantarillado" class="w-full border rounded p-2 text-sm uppercase">
                        <option>Red de Alcantarillado</option>
                        <option>Cámara Séptica</option>
                        <option>Pozo Ciego</option>
                        <option>No tiene</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2 md:col-span-2 mt-2">
                     <Checkbox :checked="form.serv_electricidad" @update:checked="val => form.serv_electricidad = val" />
                     <Label>Cuenta con Energía Eléctrica en la vivienda</Label>
                </div>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border">
            <h3 class="font-bold text-gray-700 mb-3 text-sm uppercase">4.4 Acceso a Internet</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <Label class="text-xs">Lugar de acceso frecuente</Label>
                    <select v-model="form.net_acceso" class="w-full border rounded p-2 text-sm uppercase">
                        <option>No tiene acceso</option>
                        <option>Vivienda (Wifi/Datos)</option>
                        <option>Unidad Educativa</option>
                        <option>Lugares Públicos</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <Label class="text-xs">Frecuencia de uso</Label>
                    <select v-model="form.net_frecuencia" class="w-full border rounded p-2 text-sm uppercase">
                        <option>Diariamente</option>
                        <option>Una vez a la semana</option>
                        <option>Mas de una vez a la semana</option>
                        <option>Una vez al mes</option>
                    </select>
                </div>
            </div>
        </div>

         <div class="bg-gray-50 p-4 rounded-lg border">
            <h3 class="font-bold text-gray-700 mb-3 text-sm uppercase">4.5 Actividad Laboral</h3>
            <div class="flex items-center space-x-2 mb-4">
                 <Checkbox :checked="form.trabajo_realiza" @update:checked="val => form.trabajo_realiza = val" />
                 <Label class="font-bold text-blue-900">¿La o el estudiante realizó alguna actividad laboral remunerada?</Label>
            </div>
            
            <div v-if="form.trabajo_realiza" class="grid grid-cols-1 md:grid-cols-3 gap-4 animate-in slide-in-from-top-2">
                <div><Label>Actividad</Label><Input v-model="form.trabajo_actividad" placeholder="Ej. Venta, Agricultura" class="uppercase"/></div>
                <div><Label>Días</Label><Input v-model="form.trabajo_dias" placeholder="Ej. Fines de semana" class="uppercase"/></div>
                <div><Label>Turno</Label><Input v-model="form.trabajo_turno" placeholder="Ej. Tarde" class="uppercase"/></div>
            </div>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg border">
            <h3 class="font-bold text-gray-700 mb-3 text-sm uppercase">4.6 Transporte a la Unidad Educativa</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <Label class="text-xs">Medio de transporte habitual</Label>
                    <select v-model="form.trans_medio" class="w-full border rounded p-2 text-sm uppercase">
                        <option>A pie</option>
                        <option>Transporte Público (Trufi/Micro)</option>
                        <option>Vehículo Particular</option>
                    </select>
                </div>
                 <div>
                    <Label class="text-xs">Tiempo máximo empleado</Label>
                    <select v-model="form.trans_tiempo" class="w-full border rounded p-2 text-sm uppercase">
                        <option>Menos de 30 min</option>
                        <option>Entre 30 min a 1 hora</option>
                        <option>Entre 1 a 2 horas</option>
                        <option>Más de 2 horas</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>