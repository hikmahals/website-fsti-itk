<script setup>
import { ref, computed, watch } from 'vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import Banner from '@/Components/Banner.vue';
import Modal from '@/Components/Modal.vue';
import { X, Eye, Mail, Search, Filter } from 'lucide-vue-next';

// --- DATA STATIS ---
const allDosen = ref([
    { id: 1, name: 'Adi Mahmud Jaya Marindra, S.T., M.Eng., Ph.D.', prodi: 'Teknik Elektro', jurusan: 'Teknik Elektro, Informatika, dan Bisnis', image: '/images/dosen/dosen-1.png', nip: '198001012005011001', email: 'adi.marindra@itk.ac.id' },
    { id: 2, name: 'Irma Fitria, S.Si., M.Si.', prodi: 'Sistem Informasi', jurusan: 'Teknik Elektro, Informatika, dan Bisnis', image: '/images/dosen/dosen-2.png', nip: '198202022006022002', email: 'irma.fitria@itk.ac.id' },
    { id: 3, name: 'Febrian Dedi Sastrawan, S.Si., M.Sc', prodi: 'Fisika', jurusan: 'Sains dan Analitika Data', image: '/images/dosen/dosen-1.png', nip: '198503032008031003', email: 'febrian.ds@itk.ac.id' },
    { id: 4, name: 'Kartika Nugraheni, S.Si., M.Si.', prodi: 'Matematika', jurusan: 'Sains dan Analitika Data', image: '/images/dosen/dosen-2.png', nip: '198804042010042004', email: 'kartika.n@itk.ac.id' },
    { id: 5, name: 'Nisa Rizqiya Fadhliana, S.Kom., M.T', prodi: 'Informatika', jurusan: 'Teknik Elektro, Informatika, dan Bisnis', image: '/images/dosen/dosen-1.png', nip: '199005052012051005', email: 'nisa.rf@itk.ac.id' },
    { id: 6, name: 'Yun Tonce Kusuma Priyanto, S.T., M.T.', prodi: 'Informatika', jurusan: 'Teknik Elektro, Informatika, dan Bisnis', image: '/images/dosen/dosen-2.png', nip: '199106062014061006', email: 'yun.tonce@itk.ac.id' },
    { id: 7, name: 'Desy Ridho Rahayu, S.Si', prodi: 'Fisika', jurusan: 'Sains dan Analitika Data', image: '/images/dosen/dosen-1.png', nip: '199207072015072007', email: 'desy.rr@itk.ac.id' },
    { id: 8, name: 'Muhammad Azka, S.Si., M.Sc', prodi: 'Ilmu Aktuaria', jurusan: 'Sains dan Analitika Data', image: '/images/dosen/dosen-2.png', nip: '199308082016081008', email: 'azka.m@itk.ac.id' },
    { id: 9, name: 'Deli Yansyah, S.E., M.Acc., Ak., CA', prodi: 'Bisnis Digital', jurusan: 'Teknik Elektro, Informatika, dan Bisnis', image: '/images/dosen/dosen-1.png', nip: '199409092018092009', email: 'deli.y@itk.ac.id' },
]);

// --- State untuk Filter dan Pencarian ---
const search = ref('');
const selectedJurusan = ref('');
const selectedProdi = ref('');

// --- State untuk Pagination ---
const currentPage = ref(1);
const perPage = ref(8);

// --- State untuk Modal ---
const isModalVisible = ref(false);
const selectedDosen = ref(null);

// --- Opsi untuk Filter Dropdown ---
const jurusanOptions = ['Sains dan Analitika Data', 'Teknik Elektro, Informatika, dan Bisnis'];
const prodiOptions = {
    'Sains dan Analitika Data': ['Fisika', 'Matematika', 'Statistika', 'Ilmu Aktuaria'],
    'Teknik Elektro, Informatika, dan Bisnis': ['Teknik Elektro', 'Sistem Informasi', 'Informatika', 'Bisnis Digital', 'Magister Manajemen Teknologi'],
};
const currentProdiOptions = computed(() => selectedJurusan.value ? prodiOptions[selectedJurusan.value] : []);

// --- Logika Filtering Real-time ---
const filteredDosen = computed(() => {
    return allDosen.value.filter(dosen => 
        dosen.name.toLowerCase().includes(search.value.toLowerCase()) &&
        (!selectedJurusan.value || dosen.jurusan === selectedJurusan.value) &&
        (!selectedProdi.value || dosen.prodi === selectedProdi.value)
    );
});

// PERBAIKAN PAGINATION: Reset halaman ke 1 hanya jika filter berubah
watch([search, selectedJurusan, selectedProdi], () => {
    currentPage.value = 1;
});

// --- Logika Pagination ---
const totalPages = computed(() => Math.ceil(filteredDosen.value.length / perPage.value));
const paginatedDosen = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    const end = start + perPage.value;
    return filteredDosen.value.slice(start, end);
});
// 3. Pagination Info dipecah agar bisa di-style
const paginationInfo = computed(() => {
    const total = filteredDosen.value.length;
    const from = total > 0 ? (currentPage.value - 1) * perPage.value + 1 : 0;
    const to = Math.min(currentPage.value * perPage.value, total);
    return { from, to, total };
});
const paginationPages = computed(() => {
    return Array.from({ length: totalPages.value }, (_, i) => i + 1);
});

function changePage(page) {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        const filterSection = document.getElementById('filter-section');
        if (filterSection) {
            filterSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
}

// --- Logika Modal ---
function openModal(dosen) {
    selectedDosen.value = dosen;
    isModalVisible.value = true;
}
function closeModal() {
    isModalVisible.value = false;
}
</script>

<template>
    <PublicLayout>
        <Banner
            title="DOSEN"
            subtitle="DOSEN"
            background-image="/images/background-banner.png"
        />

        <div class="bg-white">
            <div class="bg-[#CBDCEB] py-6 mt-8">
                <div class="container mx-auto px-4">
                    <h2 class="text-3xl md:text-4xl font-kulim-park font-bold text-[#133E87]">Daftar Dosen FSTI ITK</h2>
                    <p class="mt-2 font-inter text-black max-w-3xl">
                        Temukan dan kenali para dosen yang mendukung perjalanan akademik anda.
                    </p>
                </div>
            </div>

            <div class="container mx-auto px-4">

                <div id="filter-section" class="bg-[#CBDCEB] py-8 px-6 rounded-xl my-10">
                     <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="relative">
                            <label for="search" class="sr-only">Cari Dosen</label>
                            <input v-model="search" type="text" placeholder="Cari Dosen..." class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg text-black focus:ring-[#133E87] focus:border-[#133E87]">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <Search class="h-6 w-6 text-black" />
                            </div>
                        </div>
                        <div class="relative">
                            <label for="jurusan" class="sr-only">Filter Jurusan</label>
                             <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                <Filter class="h-6 w-6 text-black" />
                            </div>
                            <select v-model="selectedJurusan" id="jurusan" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg appearance-none text-black focus:ring-[#133E87] focus:border-[#133E87]">
                                <option value="">Semua Jurusan</option>
                                <option v-for="jurusan in jurusanOptions" :key="jurusan" :value="jurusan">{{ jurusan }}</option>
                            </select>
                        </div>
                        <div class="relative">
                             <label for="prodi" class="sr-only">Filter Prodi</label>
                             <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                <Filter class="h-6 w-6 text-black" />
                            </div>
                            <select v-model="selectedProdi" id="prodi" :disabled="!selectedJurusan" class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg appearance-none text-black focus:ring-[#133E87] focus:border-[#133E87] disabled:bg-gray-100">
                                <option value="">Semua Prodi</option>
                                <option v-for="prodi in currentProdiOptions" :key="prodi" :value="prodi">{{ prodi }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 justify-items-center">
                    <div
                        v-for="dosen in paginatedDosen"
                        :key="dosen.id"
                        class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col w-[299px] h-[420px]"
                        data-aos="fade-up"
                    >
                        <div class="h-[245px] flex-shrink-0">
                            <img :src="dosen.image" :alt="dosen.name" class="object-cover w-full h-full">
                        </div>
                        <div class="p-4 flex flex-col flex-grow bg-[#CBDCEB]">
                             <div class="flex-grow">
                                <h3 class="font-kulim-park font-bold text-lg text-[#133E87]">{{ dosen.name }}</h3>
                                <p class="text-sm text-black mt-2">Prodi {{ dosen.prodi }}</p>
                                <p class="text-xs text-black">Jurusan {{ dosen.jurusan }}</p>
                            </div>
                            <div class="mt-2 text-right flex-shrink-0">
                                <button @click="openModal(dosen)" class="inline-flex items-center px-4 py-2 bg-white text-[#133E87] text-sm font-semibold rounded-full hover:bg-gray-200 transition shadow">
                                    <Eye class="w-4 h-4 mr-2" />
                                    Lihat Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                 <div v-if="filteredDosen.length === 0" class="text-center py-16 text-black">
                    <p>Dosen tidak ditemukan. Silakan coba kata kunci atau filter lain.</p>
                </div>

                <div v-if="filteredDosen.length > 0 && totalPages > 1" class="mt-12 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <p class="text-sm text-black">
                        Menampilkan <span class="font-semibold">{{ paginationInfo.from }}</span> sampai <span class="font-semibold">{{ paginationInfo.to }}</span> dari <span class="font-semibold">{{ paginationInfo.total }}</span> Dosen
                    </p>
                    <div class="flex items-center space-x-1">
                        <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1" v-html="'&laquo; Previous'" class="px-3 py-1.5 text-sm font-semibold rounded-lg transition bg-gray-200 text-black hover:bg-gray-300 disabled:opacity-50"></button>
                        
                        <template v-for="page in paginationPages" :key="page">
                             <button @click="changePage(page)" 
                                :class="page === currentPage ? 'bg-[#133E87] text-white shadow-md' : 'bg-gray-200 text-black hover:bg-gray-300'"
                                class="px-3 py-1.5 text-sm font-semibold rounded-lg transition w-9 h-9">
                                {{ page }}
                            </button>
                        </template>

                        <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages" v-html="'Next &raquo;'" class="px-3 py-1.5 text-sm font-semibold rounded-lg transition bg-gray-200 text-black hover:bg-gray-300 disabled:opacity-50"></button>
                    </div>
                </div>
            </div>
            
            <div class="pb-16 md:pb-24"></div>
        </div>

        <Modal :show="isModalVisible" @close="closeModal" max-width="lg">
            <div v-if="selectedDosen" class="bg-[#CBDCEB] rounded-lg relative">
                 <button @click="closeModal" class="absolute top-4 right-4 text-gray-600 hover:text-gray-900 z-10">
                    <X class="w-6 h-6" />
                </button>
                <div class="p-8 text-center">
                    <h2 class="text-2xl font-kulim-park font-bold text-[#133E87] mb-6">Detail Dosen</h2>
                    <div class="flex justify-center mb-4">
                        <div class="w-40 h-40 rounded-full border-4 border-[#133E87] p-1 shadow-lg">
                            <img :src="selectedDosen.image" :alt="selectedDosen.name" class="w-full h-full object-cover rounded-full">
                        </div>
                    </div>
                    <h3 class="text-2xl font-kulim-park font-bold text-[#133E87]">{{ selectedDosen.name }}</h3>
                    <p class="text-black">Prodi {{ selectedDosen.prodi }}</p>
                    <p class="text-sm text-black">Jurusan {{ selectedDosen.jurusan }}</p>
                    <hr class="my-6 border-t border-[#133E87]">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-left text-sm">
                        <div>
                            <p class="font-semibold text-gray-800">NIP/NIDN</p>
                            <p class="text-black">{{ selectedDosen.nip }}</p>
                        </div>
                         <div>
                            <p class="font-semibold text-gray-800 flex items-center"><Mail class="w-4 h-4 mr-2 text-[#133E87]"/> Email</p>
                            <a :href="'mailto:' + selectedDosen.email" class="text-black hover:underline break-all">{{ selectedDosen.email }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </Modal>

    </PublicLayout>
</template>