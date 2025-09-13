<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import { ArrowLeftIcon, PaperAirplaneIcon, PaperClipIcon } from '@heroicons/vue/24/outline';
import type { Achievement } from '@/types'; // Pastikan Anda memiliki definisi tipe ini

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    achievement: Achievement;
}>();

const form = useForm({
  _method: 'patch', // Metode untuk update
  student_name: props.achievement.student_name,
  student_nim: props.achievement.student_nim,
  study_program: props.achievement.study_program,
  achievement_name: props.achievement.achievement_name,
  category: props.achievement.category,
  level: props.achievement.level,
  organizer: props.achievement.organizer,
  year: props.achievement.year,
  photo: null as File | null,
  proof: null as File | null,
});

const submit = () => {
  // Gunakan .post agar Inertia dapat menangani unggahan file dengan benar
  form.post(route('admin.achievements.update', props.achievement.id));
};
</script>

<template>
  <div>
    <Head :title="'Edit Prestasi: ' + achievement.student_name" />
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-black">Edit Prestasi</h1>
      <p class="mt-1 text-black">Perbarui detail prestasi untuk {{ achievement.student_name }}</p>
    </div>

    <div class="bg-white shadow-sm p-8 rounded-lg">
      <form @submit.prevent="submit">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
          
          <div class="space-y-6">
            <div>
              <label for="student_name" class="block text-sm font-semibold text-black">Nama Mahasiswa *</label>
              <input type="text" id="student_name" v-model="form.student_name" placeholder="Masukkan Nama Mahasiswa" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
              <p v-if="form.errors.student_name" class="mt-2 text-sm text-red-600">{{ form.errors.student_name }}</p>
            </div>

            <div>
              <label for="student_nim" class="block text-sm font-semibold text-black">NIM Mahasiswa *</label>
              <input type="text" id="student_nim" v-model="form.student_nim" placeholder="Masukkan NIM Mahasiswa" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
              <p v-if="form.errors.student_nim" class="mt-2 text-sm text-red-600">{{ form.errors.student_nim }}</p>
            </div>

            <div>
              <label for="study_program" class="block text-sm font-semibold text-black">Program Studi *</label>
              <select id="study_program" v-model="form.study_program" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="" disabled>Pilih Program Studi</option>
                <option>Teknik Elektro</option>
                <option>Sistem Informasi</option>
                <option>Informatika</option>
                <option>Bisnis Digital</option>
                <option>Magister Manajemen Teknologi</option>
                <option>Fisika</option>
                <option>Matematika</option>
                <option>Statistika</option>
                <option>Ilmu Aktuaria</option>
              </select>
              <p v-if="form.errors.study_program" class="mt-2 text-sm text-red-600">{{ form.errors.study_program }}</p>
            </div>

            <div>
              <label for="achievement_name" class="block text-sm font-semibold text-black">Capaian Prestasi *</label>
              <input type="text" id="achievement_name" v-model="form.achievement_name" placeholder="Masukkan nama prestasi atau lomba yang dicapai" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
              <p v-if="form.errors.achievement_name" class="mt-2 text-sm text-red-600">{{ form.errors.achievement_name }}</p>
            </div>
          </div>

          <div class="space-y-6">
            <div>
              <label for="category" class="block text-sm font-semibold text-black">Kategori *</label>
              <select id="category" v-model="form.category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="" disabled>Pilih kategori prestasi</option>
                <option>Akademik</option>
                <option>Non-Akademik</option>
              </select>
              <p v-if="form.errors.category" class="mt-2 text-sm text-red-600">{{ form.errors.category }}</p>
            </div>

            <div>
              <label for="level" class="block text-sm font-semibold text-black">Tingkat *</label>
              <select id="level" v-model="form.level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="" disabled>Pilih tingkat prestasi</option>
                <option>Internasional</option>
                <option>Nasional</option>
                <option>Provinsi</option>
                <option>Kota/Kabupaten</option>
                <option>Universitas</option>
              </select>
              <p v-if="form.errors.level" class="mt-2 text-sm text-red-600">{{ form.errors.level }}</p>
            </div>

            <div>
              <label for="organizer" class="block text-sm font-semibold text-black">Penyelenggara *</label>
              <input type="text" id="organizer" v-model="form.organizer" placeholder="Masukkan institusi penyelenggara" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
              <p v-if="form.errors.organizer" class="mt-2 text-sm text-red-600">{{ form.errors.organizer }}</p>
            </div>
            
            <div>
              <label for="year" class="block text-sm font-semibold text-black">Tahun *</label>
              <input type="number" id="year" v-model="form.year" placeholder="Masukkan tahun capaian prestasi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
              <p v-if="form.errors.year" class="mt-2 text-sm text-red-600">{{ form.errors.year }}</p>
            </div>
          </div>

          <div class="md:col-span-2">
            <label for="photo" class="block text-sm font-semibold text-black">Ganti Foto Mahasiswa/Tim</label>
            <div class="mt-2 mb-4">
                <img :src="achievement.photo_url" :alt="'Foto ' + achievement.student_name" class="h-40 w-auto rounded-lg border p-2">
                <p class="text-xs text-gray-500 mt-1">Foto saat ini</p>
            </div>
            <div class="relative flex items-center w-full rounded-md border border-gray-300 bg-white shadow-sm px-4 py-2">
              <PaperClipIcon class="h-5 w-5 text-gray-400" />
              <span class="ml-3 text-sm" :class="{'text-gray-400': !form.photo, 'text-black': form.photo}">
                {{ form.photo ? form.photo.name : 'Pilih file baru untuk mengganti foto' }}
              </span>
              <input type="file" id="photo" @input="form.photo = ($event.target as HTMLInputElement).files?.[0] || null" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
            </div>
            <p v-if="form.errors.photo" class="mt-2 text-sm text-red-600">{{ form.errors.photo }}</p>
          </div>

          <div class="md:col-span-2">
            <label for="proof" class="block text-sm font-semibold text-black">Ganti Bukti (Opsional)</label>
            <a v-if="achievement.proof_url" :href="achievement.proof_url" target="_blank" class="text-sm text-blue-600 hover:underline mt-2 mb-2 block">
                Lihat bukti yang sudah diunggah
            </a>
            <div class="mt-1 relative flex items-center w-full rounded-md border border-gray-300 bg-white shadow-sm px-4 py-2">
              <PaperClipIcon class="h-5 w-5 text-gray-400" />
              <span class="ml-3 text-sm" :class="{'text-gray-400': !form.proof, 'text-black': form.proof}">
                {{ form.proof ? form.proof.name : 'Pilih file baru untuk mengganti bukti' }}
              </span>
              <input type="file" id="proof" @input="form.proof = ($event.target as HTMLInputElement).files?.[0] || null" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
            </div>
            <p v-if="form.errors.proof" class="mt-2 text-sm text-red-600">{{ form.errors.proof }}</p>
          </div>
        </div>

        <div class="mt-12 flex items-center justify-end gap-4">
            <Link :href="route('admin.achievements.index')" class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                <ArrowLeftIcon class="h-5 w-5" />
                Batal
            </Link>
            <button type="submit" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 disabled:opacity-50">
                <PaperAirplaneIcon class="h-5 w-5" />
                Perbarui
            </button>
        </div>
      </form>
    </div>
  </div>
</template>