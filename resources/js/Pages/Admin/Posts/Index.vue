<script setup lang="ts">
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { 
    MagnifyingGlassIcon, 
    PlusIcon, 
    FunnelIcon,
    ChevronDownIcon,
    EyeIcon,
    PencilSquareIcon,
    TrashIcon,
    ExclamationTriangleIcon,
    CheckCircleIcon,
} from '@heroicons/vue/24/outline';
import { Link, router, usePage } from '@inertiajs/vue3';
import { ref, watch, computed } from 'vue';
import throttle from "lodash/throttle";

defineOptions({ layout: AdminLayout });

const props = defineProps<{
    posts: {
        data: Array<{
            id: number;
            title: string;
            category: string;
            created_at: string;
            status: 'Terbitkan' | 'Draft';
            views: number;
        }>;
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
    };
    filters: {
        search: string | null;
        status: string | null;
    };
}>();

const search = ref(props.filters.search);
const status = ref(props.filters.status);

// PERUBAHAN: Menambahkan anotasi tipe eksplisit pada parameter fungsi throttle
watch([search, status], throttle(function ([searchVal, statusVal]: [(string | null), (string | null)]) {
    router.get(route('admin.posts.index'), {
        search: searchVal,
        status: statusVal,
    }, {
        preserveState: true,
        replace: true,
    });
}, 300));

const isModalOpen = ref(false);
const postToDelete = ref<typeof props.posts.data[0] | null>(null);

const openDeleteModal = (post: typeof props.posts.data[0]) => {
    postToDelete.value = post;
    isModalOpen.value = true;
};

const closeDeleteModal = () => {
    isModalOpen.value = false;
    postToDelete.value = null;
};

const confirmDelete = () => {
    if (postToDelete.value) {
        router.delete(route('admin.posts.destroy', postToDelete.value.id), {
            onSuccess: () => closeDeleteModal(),
        });
    }
};

const page = usePage();
const showNotification = ref(false);
const notificationMessage = ref('');
const flashSuccess = computed(() => (page.props as any).flash?.success);

watch(flashSuccess, (message) => {
    if (message) {
        notificationMessage.value = message as string;
        showNotification.value = true;
        setTimeout(() => {
            showNotification.value = false;
        }, 3000);
    }
}, { immediate: true });

const formatDate = (datetime: string) => {
    const date = new Date(datetime);
    return date.toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' });
}
</script>

<template>
    <div>
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-black">Kelola Berita</h1>
                <p class="mt-1 text-black">Manajemen konten berita untuk website Fakultas Sains dan Teknologi Institut Teknologi Kalimantan</p>
            </div>
            <Link :href="route('admin.posts.create')" class="flex items-center gap-2 rounded-lg bg-[#4682A9] px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 flex-shrink-0">
                <PlusIcon class="h-5 w-5" />
                Tambah Berita
            </Link>
        </div>

        <!-- Panel Aksi (Search & Filter) -->
        <div class="flex items-center justify-between gap-4 mb-6">
            <div class="relative flex-grow">
                <MagnifyingGlassIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-400" />
                <input 
                    v-model="search"
                    type="text" 
                    placeholder="Cari Berita" 
                    class="w-full rounded-lg border-gray-300 py-3 pl-11 pr-4 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                />
            </div>
            
            <div class="relative flex-shrink-0">
                <FunnelIcon class="pointer-events-none absolute top-1/2 left-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
                <select v-model="status" class="w-full appearance-none rounded-lg border border-gray-300 bg-white py-3 pl-11 pr-10 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                    <option :value="null">Semua Status</option>
                    <option value="Terbitkan">Terbitkan</option>
                    <option value="Draft">Draft</option>
                </select>
                <ChevronDownIcon class="pointer-events-none absolute top-1/2 right-4 h-5 w-5 -translate-y-1/2 text-gray-500"/>
            </div>
        </div>

        <!-- Tabel -->
        <div class="bg-white shadow-sm p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-black mb-4">Daftar Berita</h3>
            
            <div class="border rounded-lg overflow-x-auto">
                <table class="w-full min-w-full">
                    <thead class="bg-[#CBDCEB]">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Judul</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Kategori</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Views</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-black">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <tr v-if="props.posts.data.length > 0" v-for="post in props.posts.data" :key="post.id" class="hover:bg-gray-50">
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-black">{{ post.title }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-800">{{ post.category }}</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-black">{{ formatDate(post.created_at) }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-800">{{ post.status }}</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-black">
                                <span class="flex items-center gap-2"><EyeIcon class="h-4 w-4" /> {{ post.views }}</span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <Link :href="route('admin.posts.edit', post.id)" class="flex items-center gap-1 text-[#4682A9] hover:opacity-80">
                                        <PencilSquareIcon class="h-4 w-4" />
                                        Edit
                                    </Link>
                                    <span class="text-gray-300">|</span>
                                    <button @click="openDeleteModal(post)" type="button" class="flex items-center gap-1 text-[#DC645E] hover:opacity-80">
                                        <TrashIcon class="h-4 w-4" />
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-else>
                            <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada berita yang cocok dengan pencarian Anda.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginasi -->
            <div class="flex items-center justify-between mt-4">
                <p class="text-sm text-black"></p>
                <div class="flex items-center gap-1">
                    <Link 
                        v-for="(link, index) in props.posts.links" 
                        :key="index"
                        :href="link.url ?? '#'"
                        v-html="link.label"
                        :class="[
                            'px-3 py-1 text-sm rounded border border-gray-300',
                            link.active ? 'bg-[#4682A9] text-white' : 'bg-[#CBDCEB] text-gray-800 hover:bg-opacity-80',
                            !link.url ? 'text-gray-400 cursor-not-allowed' : ''
                        ]"
                    />
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md rounded-lg bg-white p-8 shadow-2xl">
            <div class="flex flex-col items-center text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
                    <ExclamationTriangleIcon class="h-10 w-10 text-red-500" />
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Hapus Berita</h2>
                <p class="mt-2 text-gray-600">
                    Apakah Anda yakin ingin menghapus berita <br>
                    <span class="font-semibold">"{{ postToDelete?.title }}"</span>?
                </p>
            </div>
            <div class="mt-8 flex justify-center gap-4">
                <button @click="closeDeleteModal" class="rounded-lg bg-gray-200 px-6 py-2 font-semibold text-gray-800 hover:bg-gray-300">
                    Batal
                </button>
                <button @click="confirmDelete" class="rounded-lg bg-red-600 px-6 py-2 font-semibold text-white hover:bg-red-700">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
    
    <!-- Notifikasi Sukses (Toast) -->
    <div v-if="showNotification" class="fixed top-5 right-5 z-50 transition-transform duration-300 ease-in-out">
        <div class="flex items-center gap-4 rounded-lg bg-green-600 p-4 text-white shadow-lg">
            <CheckCircleIcon class="h-8 w-8" />
            <p class="font-semibold">{{ notificationMessage }}</p>
        </div>
    </div>
</template>