<template>
  <div class="min-h-screen bg-gray-100 pb-12">
    <header class="bg-[#003366] text-white p-4 shadow-md border-b-4 border-[#CC0000]">
      <div class="max-w-2xl mx-auto text-center">
        <h1 class="text-xl font-bold uppercase tracking-wider">U.E. ISMAEL VÁSQUEZ</h1>
        <p class="text-xs opacity-90">Registro Único de Estudiantes (RUDE) 2025</p>
      </div>
    </header>

    <div class="max-w-2xl mx-auto mt-6 px-4">
      <div class="flex justify-between mb-8 px-2">
        <div v-for="step in 5" :key="step" 
             :class="['w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-all', 
                      currentStep >= step ? 'bg-[#CC0000] text-white' : 'bg-white text-gray-400 border']">
          {{ step }}
        </div>
      </div>

      <form @submit.prevent="submit" class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-[#003366]">
        
        <div v-if="currentStep === 1" class="space-y-4">
          <h2 class="text-lg font-bold text-[#003366] border-b pb-2">I. Datos del Estudiante</h2>
          <div>
            <label class="block text-sm font-medium text-gray-700">Nombres *</label>
            <input v-model="form.nombres" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#003366] focus:ring-[#003366]" placeholder="Como figura en el CI/Certificado">
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Ap. Paterno</label>
              <input v-model="form.apellido_paterno" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#003366] focus:ring-[#003366]">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Ap. Materno</label>
              <input v-model="form.apellido_materno" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#003366] focus:ring-[#003366]">
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700">Fecha Nacimiento *</label>
              <input v-model="form.fecha_nacimiento" type="date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#003366] focus:ring-[#003366]">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Sexo *</label>
              <select v-model="form.sexo" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#003366] focus:ring-[#003366]">
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
              </select>
            </div>
          </div>
        </div>

        <div v-if="currentStep === 2" class="space-y-4">
          <h2 class="text-lg font-bold text-[#003366] border-b pb-2">II. Dirección Actual</h2>
          <div>
            <label class="block text-sm font-medium text-gray-700">Zona / Villa *</label>
            <input v-model="form.dir_zona" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Calle / Avenida *</label>
            <input v-model="form.dir_calle" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Celular de Contacto *</label>
            <input v-model="form.celular_contacto" type="tel" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="7XXXXXXXX">
          </div>
        </div>

        <div v-if="currentStep === 3" class="space-y-4">
          <h2 class="text-lg font-bold text-[#003366] border-b pb-2">III. Socioeconomía</h2>
          <div>
            <label class="block text-sm font-medium text-gray-700">¿En qué idioma aprendió a hablar? *</label>
            <input v-model="form.idioma_niñez" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Ejem: Castellano, Quechua">
          </div>
          <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
            <input v-model="form.agua_red" type="checkbox" class="h-5 w-5 text-[#003366]">
            <label class="text-sm text-gray-700 font-medium">¿Tiene acceso a agua por red?</label>
          </div>
          <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
            <input v-model="form.luz_electrica" type="checkbox" class="h-5 w-5 text-[#003366]">
            <label class="text-sm text-gray-700 font-medium">¿Tiene energía eléctrica?</label>
          </div>
        </div>

        <div v-if="currentStep === 4" class="space-y-4">
          <h2 class="text-lg font-bold text-[#003366] border-b pb-2">IV. Datos del Padre o Tutor</h2>
          <div>
            <label class="block text-sm font-medium text-gray-700">Nombre Completo del Tutor *</label>
            <input v-model="form.nombre_tutor" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Cédula de Identidad (Tutor) *</label>
            <input v-model="form.ci_tutor" type="text" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Parentesco *</label>
            <select v-model="form.parentesco_tutor" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
              <option value="Padre">Padre</option>
              <option value="Madre">Madre</option>
              <option value="Tutor">Otro (Tutor)</option>
            </select>
          </div>
        </div>

        <div v-if="currentStep === 5" class="space-y-6">
          <h2 class="text-lg font-bold text-[#003366] border-b pb-2 text-center">V. Fotos de Documentos</h2>
          <p class="text-xs text-red-600 font-bold">* Asegúrese de que las fotos sean legibles.</p>
          
          <div class="grid grid-cols-1 gap-6">
            <div class="border-2 border-dashed border-gray-300 p-4 rounded-lg text-center">
              <p class="text-sm font-bold mb-2">CI Estudiante (Anverso)</p>
              <input type="file" @input="form.foto_ci_est_anverso = $event.target.files[0]" accept="image/*" capture="camera" class="text-xs">
            </div>
            <div class="border-2 border-dashed border-gray-300 p-4 rounded-lg text-center">
              <p class="text-sm font-bold mb-2">CI Estudiante (Reverso)</p>
              <input type="file" @input="form.foto_ci_est_reverso = $event.target.files[0]" accept="image/*" capture="camera" class="text-xs">
            </div>
            <div class="border-2 border-dashed border-gray-300 p-4 rounded-lg text-center bg-gray-50">
              <p class="text-sm font-bold mb-2 text-[#CC0000]">CI Tutor (Anverso)</p>
              <input type="file" @input="form.foto_ci_tut_anverso = $event.target.files[0]" accept="image/*" class="text-xs">
            </div>
            <div class="border-2 border-dashed border-gray-300 p-4 rounded-lg text-center bg-gray-50">
              <p class="text-sm font-bold mb-2 text-[#CC0000]">CI Tutor (Reverso)</p>
              <input type="file" @input="form.foto_ci_tut_reverso = $event.target.files[0]" accept="image/*" class="text-xs">
            </div>
          </div>
        </div>

        <div class="mt-8 flex justify-between">
          <button v-if="currentStep > 1" type="button" @click="currentStep--" 
                  class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300 transition-colors">
            Atrás
          </button>
          <div v-else></div>

          <button v-if="currentStep < 5" type="button" @click="currentStep++" 
                  class="px-6 py-2 bg-[#003366] text-white rounded-lg font-bold hover:bg-blue-900 transition-colors">
            Siguiente
          </button>

          <button v-if="currentStep === 5" type="submit" :disabled="form.processing"
                  class="px-6 py-2 bg-[#CC0000] text-white rounded-lg font-bold hover:bg-red-800 disabled:opacity-50 transition-colors">
            {{ form.processing ? 'Enviando...' : 'Finalizar Registro' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const currentStep = ref(1);

const form = useForm({
  // Datos Mapeados del PDF
  nombres: '',
  apellido_paterno: '',
  apellido_materno: '',
  fecha_nacimiento: '',
  sexo: '',
  dir_zona: '',
  dir_calle: '',
  celular_contacto: '',
  idioma_niñez: '',
  agua_red: false,
  luz_electrica: false,
  nombre_tutor: '',
  ci_tutor: '',
  parentesco_tutor: '',
  // Fotos solicitadas
  foto_ci_est_anverso: null,
  foto_ci_est_reverso: null,
  foto_ci_tut_anverso: null,
  foto_ci_tut_reverso: null,
});

const submit = () => {
  form.post(route('rude.store'), {
    forceFormData: true,
    onSuccess: () => alert('Registro enviado exitosamente.'),
  });
};
</script>