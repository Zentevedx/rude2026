<script setup>
import { defineProps } from 'vue';
import { Languages, Heart, Activity, Droplet, Wifi, Briefcase, Car, AlertTriangle, Home } from 'lucide-vue-next';

const props = defineProps(['form']);
</script>

<template>
    <div class="space-y-6 sm:space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-500">
        <h2 class="text-xl font-bold text-blue-900 border-b pb-4 mb-6 flex items-center gap-3">
            <Activity class="w-6 h-6 text-red-600" />
            <span class="flex-1">ASPECTOS SOCIOECONÓMICOS</span>
            <span class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-bold">Sección IV</span>
        </h2>

        <!-- a. IDIOMA Y CULTURA -->
        <div class="bg-white rounded-xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border-t-4 border-blue-900 ring-1 ring-gray-100 relative overflow-hidden">
            <h3 class="font-bold text-blue-900 mb-6 border-b border-gray-200 pb-2 flex items-center gap-2">
                <Languages class="w-5 h-5 text-red-500" />
                a. IDIOMA Y AUTOIDENTIFICACIÓN CULTURAL
            </h3>
            
            <div class="space-y-6">
                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase mb-1 block">i. ¿Cuál es el idioma que aprendió a hablar en su niñez?</label>
                    <input v-model="form.idioma_ninez" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 uppercase font-medium text-sm transition-all shadow-sm" />
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase mb-1 block">ii. ¿Qué idiomas habla frecuentemente?</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <input v-model="form.idioma_frecuente_1" placeholder="1er Idioma" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 uppercase font-medium text-sm transition-all shadow-sm" />
                        <input v-model="form.idioma_frecuente_2" placeholder="2do Idioma" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 uppercase font-medium text-sm transition-all shadow-sm" />
                        <input v-model="form.idioma_frecuente_3" placeholder="3er Idioma" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 uppercase font-medium text-sm transition-all shadow-sm" />
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase mb-1 block">iii. ¿Con cuál de las naciones y pueblos indígena originarios, campesinos o afrobolivianos se autoidentifica?</label>
                    <select v-model="form.nacion_originaria" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 uppercase font-medium text-sm transition-all appearance-none shadow-sm">
                        <option>NINGUNO</option>
                        <option>QUECHUA</option>
                        <option>AYMARA</option>
                        <option>GUARANÍ</option>
                        <option>AFROBOLIVIANO</option>
                        <option>MOJEÑO</option>
                        <option>CHIQUITANO</option>
                        <option>OTRO</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- a.iv SALUD -->
        <div class="bg-white rounded-xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border-t-4 border-red-600 ring-1 ring-gray-100 relative overflow-hidden">
             <h3 class="font-bold text-blue-900 mb-6 border-b border-gray-200 pb-2 flex items-center gap-2">
                <Heart class="w-5 h-5 text-red-600" />
                a.iv. SALUD DE LA O EL ESTUDIANTE
             </h3>
             
             <div class="mb-6">
                 <label class="text-xs font-bold text-gray-700 uppercase mb-2 block">1. ¿Existe algún Centro de Salud/Posta/Hospital en su comunidad/barrio/zona?</label>
                 <div class="flex gap-4">
                     <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-gray-50 rounded-lg"><input type="radio" :value="true" v-model="form.existe_centro_salud" class="text-red-600 focus:ring-red-500"> <span class="font-medium text-sm">SI</span></label>
                     <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-gray-50 rounded-lg"><input type="radio" :value="false" v-model="form.existe_centro_salud" class="text-red-600 focus:ring-red-500"> <span class="font-medium text-sm">NO</span></label>
                 </div>
             </div>

             <div class="mb-6">
                 <label class="text-xs font-bold text-gray-700 uppercase mb-2 block">2. El año pasado, por problemas de salud ¿Acudió o se atendió en...? (Puede marcar más de una opción)</label>
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                     <label class="flex items-center gap-2 p-3 bg-slate-50 rounded-xl hover:bg-red-50 transition-colors cursor-pointer border border-transparent hover:border-red-100"><input type="checkbox" v-model="form.salud_sus" class="text-red-600 rounded focus:ring-red-500"> <span>1. Sistema Único de Salud (SUS)</span></label>
                     <label class="flex items-center gap-2 p-3 bg-slate-50 rounded-xl hover:bg-red-50 transition-colors cursor-pointer border border-transparent hover:border-red-100"><input type="checkbox" v-model="form.salud_caja" class="text-red-600 rounded focus:ring-red-500"> <span>2. Otra Caja o Seguro de Salud</span></label>
                     <label class="flex items-center gap-2 p-3 bg-slate-50 rounded-xl hover:bg-red-50 transition-colors cursor-pointer border border-transparent hover:border-red-100"><input type="checkbox" v-model="form.salud_publico" class="text-red-600 rounded focus:ring-red-500"> <span>3. Establecimientos de Salud Públicos</span></label>
                     <label class="flex items-center gap-2 p-3 bg-slate-50 rounded-xl hover:bg-red-50 transition-colors cursor-pointer border border-transparent hover:border-red-100"><input type="checkbox" v-model="form.salud_privado" class="text-red-600 rounded focus:ring-red-500"> <span>4. Establecimientos de Salud Privados</span></label>
                     <label class="flex items-center gap-2 p-3 bg-slate-50 rounded-xl hover:bg-red-50 transition-colors cursor-pointer border border-transparent hover:border-red-100"><input type="checkbox" v-model="form.salud_vivienda" class="text-red-600 rounded focus:ring-red-500"> <span>5. En su vivienda</span></label>
                     <label class="flex items-center gap-2 p-3 bg-slate-50 rounded-xl hover:bg-red-50 transition-colors cursor-pointer border border-transparent hover:border-red-100"><input type="checkbox" v-model="form.salud_tradicional" class="text-red-600 rounded focus:ring-red-500"> <span>6. Medicina Tradicional</span></label>
                     <label class="flex items-center gap-2 p-3 bg-slate-50 rounded-xl hover:bg-red-50 transition-colors cursor-pointer border border-transparent hover:border-red-100"><input type="checkbox" v-model="form.salud_automedicacion" class="text-red-600 rounded focus:ring-red-500"> <span>7. La farmacia sin receta médica (Automedicación)</span></label>
                 </div>
             </div>
             
             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                 <div>
                     <label class="text-xs font-bold text-gray-700 uppercase mb-2 block">3. ¿El año pasado cuántas veces fue al centro de salud?</label>
                     <select v-model="form.frecuencia_salud" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-100 focus:border-red-500 text-sm appearance-none shadow-sm">
                         <option>1 a 2 VECES</option>
                         <option>3 a 5 VECES</option>
                         <option>6 O MÁS VECES</option>
                         <option>NINGUNA</option>
                     </select>
                 </div>
                 <div>
                     <label class="text-xs font-bold text-gray-700 uppercase mb-2 block">4. ¿Tiene seguro de salud?</label>
                     <div class="flex gap-4 mt-2">
                        <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-gray-50 rounded-lg"><input type="radio" :value="true" v-model="form.tiene_seguro_salud" class="text-red-600 focus:ring-red-500"> <span class="font-medium text-sm">SI</span></label>
                        <label class="flex items-center gap-2 cursor-pointer p-2 hover:bg-gray-50 rounded-lg"><input type="radio" :value="false" v-model="form.tiene_seguro_salud" class="text-red-600 focus:ring-red-500"> <span class="font-medium text-sm">NO</span></label>
                     </div>
                 </div>
             </div>
        </div>

        <!-- b. ACCESO A SERVICIOS BÁSICOS -->
        <div class="bg-white rounded-xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border-t-4 border-blue-900 ring-1 ring-gray-100 relative overflow-hidden">
            <h3 class="font-bold text-blue-900 mb-6 border-b border-gray-200 pb-2 flex items-center gap-2">
                <Droplet class="w-5 h-5 text-red-500" />
                b. ACCESO A SERVICIOS BÁSICOS
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8 text-sm">
                <div class="flex flex-col justify-center p-3 bg-slate-50 rounded-xl border border-gray-200">
                    <span class="block font-bold text-gray-800 mb-2">i. ¿Tiene acceso a agua por cañería de red?</span>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="true" v-model="form.acceso_agua" class="text-blue-600 focus:ring-blue-500"> SI</label>
                        <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="false" v-model="form.acceso_agua" class="text-blue-600 focus:ring-blue-500"> NO</label>
                    </div>
                </div>
                <div class="flex flex-col justify-center p-3 bg-slate-50 rounded-xl border border-gray-200">
                    <span class="block font-bold text-gray-800 mb-2">ii. ¿Tiene baño en su vivienda?</span>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="true" v-model="form.tiene_bano" class="text-blue-600 focus:ring-blue-500"> SI</label>
                        <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="false" v-model="form.tiene_bano" class="text-blue-600 focus:ring-blue-500"> NO</label>
                    </div>
                </div>
                <div class="flex flex-col justify-center p-3 bg-slate-50 rounded-xl border border-gray-200">
                    <span class="block font-bold text-gray-800 mb-2">iii. ¿Tiene red de alcantarillado?</span>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="true" v-model="form.tiene_alcantarillado" class="text-blue-600 focus:ring-blue-500"> SI</label>
                        <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="false" v-model="form.tiene_alcantarillado" class="text-blue-600 focus:ring-blue-500"> NO</label>
                    </div>
                </div>
                <div class="flex flex-col justify-center p-3 bg-slate-50 rounded-xl border border-gray-200">
                    <span class="block font-bold text-gray-800 mb-2">iv. ¿Usa energía eléctrica?</span>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="true" v-model="form.usa_electricidad" class="text-blue-600 focus:ring-blue-500"> SI</label>
                        <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="false" v-model="form.usa_electricidad" class="text-blue-600 focus:ring-blue-500"> NO</label>
                    </div>
                </div>
                <div class="flex flex-col justify-center p-3 bg-slate-50 rounded-xl border border-gray-200">
                    <span class="block font-bold text-gray-800 mb-2">v. ¿Cuenta con servicio de recojo de basura?</span>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="true" v-model="form.servicio_basura" class="text-blue-600 focus:ring-blue-500"> SI</label>
                        <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="false" v-model="form.servicio_basura" class="text-blue-600 focus:ring-blue-500"> NO</label>
                    </div>
                </div>
                
                <div class="md:col-span-2 mt-2">
                    <label class="text-xs font-bold text-gray-500 uppercase mb-2 block flex items-center gap-2">
                        <Home class="w-4 h-4" /> vi. La vivienda que ocupa el hogar es:
                    </label>
                    <select v-model="form.propiedad_vivienda" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-100 focus:border-cyan-500 text-sm uppercase appearance-none font-medium shadow-sm">
                        <option>PROPIA</option>
                        <option>ALQUILADA</option>
                        <option>ANTICRÉTICO</option>
                        <option>CEDIDA POR SERVICIOS</option>
                        <option>PRESTADA POR PARIENTES O AMIGOS</option>
                        <option>CONTRATO MIXTO</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- c. ACCESO A INTERNET -->
        <div class="bg-white rounded-xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border-t-4 border-blue-900 ring-1 ring-gray-100 relative overflow-hidden">
            <h3 class="font-bold text-gray-800 mb-6 border-b border-gray-200 pb-2 flex items-center gap-2">
                <Wifi class="w-5 h-5 text-blue-500" />
                c. ACCESO A INTERNET
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">i. El estudiante accede a internet en:</label>
                    <select v-model="form.acceso_internet_lugar" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 text-sm uppercase appearance-none font-medium shadow-sm">
                        <option>NO ACCEDE A INTERNET</option>
                        <option>SU VIVIENDA</option>
                        <option>LA UNIDAD EDUCATIVA</option>
                        <option>LUGARES PÚBLICOS</option>
                        <option>TELÉFONO CELULAR</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">ii. ¿Con qué frecuencia accede a internet?</label>
                    <select v-model="form.frecuencia_internet" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 text-sm uppercase appearance-none font-medium shadow-sm">
                        <option>DIARIAMENTE</option>
                        <option>UNA VEZ A LA SEMANA</option>
                        <option>MÁS DE UNA VEZ A LA SEMANA</option>
                        <option>UNA VEZ AL MES</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- d. ACTIVIDAD LABORAL -->
        <div class="bg-white rounded-xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border-t-4 border-red-600 ring-1 ring-gray-100 relative overflow-hidden">
            <h3 class="font-bold text-blue-900 mb-6 border-b border-gray-200 pb-2 flex items-center gap-2">
                <Briefcase class="w-5 h-5 text-red-600" />
                d. ACTIVIDAD LABORAL
            </h3>
            
            <div class="flex items-center space-x-4 mb-6">
                 <span class="text-sm font-bold text-gray-700">i. En la gestión pasada ¿El estudiante trabajó?</span>
                 <div class="flex gap-4">
                     <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="true" v-model="form.trabajo_gestion_pasada" class="text-red-600 focus:ring-red-500"> SI</label>
                     <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="false" v-model="form.trabajo_gestion_pasada" class="text-red-600 focus:ring-red-500"> NO</label>
                 </div>
            </div>
            
            <div v-if="form.trabajo_gestion_pasada" class="space-y-6 animate-in slide-in-from-to-2 opacity-0 fade-in duration-300 fill-mode-forwards">
                 <div>
                    <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">ii. Actividad:</label>
                    <select v-model="form.trabajo_actividad" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase appearance-none font-medium shadow-sm">
                        <option>AGRICULTURA</option>
                        <option>GANADERÍA O PESCA</option>
                        <option>COMERCIO / VENDEDOR</option>
                        <option>CONSTRUCCIÓN</option>
                        <option>TRANSPORTE</option>
                        <option>HOGAR / NIÑERO(A)</option>
                        <option>OTRO</option>
                    </select>
                 </div>
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                     <div>
                        <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">iii. Turno:</label>
                        <select v-model="form.trabajo_turnos" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase appearance-none font-medium shadow-sm">
                            <option>MAÑANA</option>
                            <option>TARDE</option>
                            <option>NOCHE</option>
                        </select>
                     </div>
                     <div>
                        <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">iv. Frecuencia:</label>
                        <select v-model="form.trabajo_frecuencia" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase appearance-none font-medium shadow-sm">
                            <option>TODOS LOS DÍAS</option>
                            <option>FINES DE SEMANA</option>
                            <option>ESPORÁDICO</option>
                            <option>VACACIONES</option>
                        </select>
                     </div>
                 </div>
                 <div>
                    <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">v. ¿Recibió algún pago?</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="true" v-model="form.trabajo_pago" class="text-red-600 focus:ring-red-500"> SI</label>
                        <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="false" v-model="form.trabajo_pago" class="text-red-600 focus:ring-red-500"> NO</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- e. TRANSPORTE -->
        <div class="bg-white rounded-xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border-t-4 border-blue-900 ring-1 ring-gray-100 relative overflow-hidden">
            <h3 class="font-bold text-blue-900 mb-6 border-b border-gray-200 pb-2 flex items-center gap-2">
                <Car class="w-5 h-5 text-red-500" />
                e. MEDIO DE TRANSPORTE
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">i. Medio Generalmente Usado</label>
                    <select v-model="form.medio_transporte" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase appearance-none font-medium shadow-sm">
                        <option>A PIE</option>
                        <option>VEHÍCULO TRANSPORTE TERRESTRE</option>
                        <option>FLUVIAL</option>
                        <option>OTRO</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase mb-2 block">ii. Tiempo Máximo (Ida)</label>
                    <select v-model="form.tiempo_transporte" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase appearance-none font-medium shadow-sm">
                        <option>MENOS DE MEDIA HORA</option>
                        <option>ENTRE MEDIA HORA Y UNA HORA</option>
                        <option>ENTRE UNA A DOS HORAS</option>
                        <option>MÁS DE DOS HORAS</option>
                    </select>
                </div>
            </div>
        </div>
        
        <!-- f. ABANDONO -->
        <div class="bg-white rounded-xl sm:rounded-3xl p-4 sm:p-6 shadow-sm border-t-4 border-red-600 ring-1 ring-gray-100 relative overflow-hidden">
            <h3 class="font-bold text-gray-800 mb-6 border-b border-gray-200 pb-2 flex items-center gap-2">
                <AlertTriangle class="w-5 h-5 text-red-600" />
                f. ABANDONO ESCOLAR
            </h3>
            <div class="mb-6 flex items-center gap-4">
                 <span class="text-sm font-bold text-gray-700">i. ¿El estudiante abandonó la UE el año pasado?</span>
                 <div class="flex gap-4">
                     <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="true" v-model="form.abandono_gestion_pasada" class="text-red-600 focus:ring-red-500"> SI</label>
                     <label class="flex items-center gap-2 cursor-pointer"><input type="radio" :value="false" v-model="form.abandono_gestion_pasada" class="text-red-600 focus:ring-red-500"> NO</label>
                 </div>
            </div>
            <div v-if="form.abandono_gestion_pasada" class="animate-in slide-in-from-top-2">
                <label class="text-xs font-bold text-gray-700 uppercase mb-2 block">ii. Razón del abandono:</label>
                <input v-model="form.abandono_razon" class="w-full p-3 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-600 text-sm uppercase font-medium transition-all shadow-sm" placeholder="Especifique la razón" />
            </div>
        </div>
    </div>
</template>