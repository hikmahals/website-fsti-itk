<script setup lang="ts">
import { onBeforeUnmount, onUnmounted, ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { 
    BookmarkIcon, 
    PaperAirplaneIcon,
    PaperClipIcon,
    ArrowUturnLeftIcon,
    ArrowUturnRightIcon,
    LinkIcon,
    ArrowLeftIcon,
    PencilSquareIcon,
    XMarkIcon, // <-- Tambahkan ikon X
} from '@heroicons/vue/24/outline';

// Import Tiptap
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import TiptapLink from '@tiptap/extension-link';
import TextAlign from '@tiptap/extension-text-align';

defineOptions({ layout: AdminLayout });

const props = defineProps<{
  post: {
    id: number;
    title: string;
    excerpt: string;
    content: string;
    category: string;
    tags: string;
    status: string;
    image_url?: string;
  }
}>();

const form = useForm({
  _method: 'PUT',
  title: props.post.title,
  excerpt: props.post.excerpt,
  content: props.post.content,
  category: props.post.category,
  tags: props.post.tags,
  status: props.post.status,
  image: null as File | null,
});

// Inisialisasi Tiptap dengan konten dari props
const editor = useEditor({
  content: props.post.content,
  extensions: [
    StarterKit,
    Underline,
    TiptapLink.configure({ openOnClick: false }),
    TextAlign.configure({ types: ['heading', 'paragraph'] }),
  ],
  onUpdate: ({ editor }) => {
    form.content = editor.getHTML();
  },
  editorProps: {
    attributes: {
      class: 'prose max-w-none w-full rounded-b-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-4 min-h-[250px]',
    },
  },
});

const imagePreview = ref<string | null>(props.post.image_url ?? null);
const temporaryImageUrl = ref<string | null>(null);

// PERBAIKAN: State untuk mengontrol modal
const showImageModal = ref(false);

function handleImageChange(event: Event) {
  const target = event.target as HTMLInputElement;
  if (target.files && target.files[0]) {
    const file = target.files[0];
    form.image = file;

    // Hapus object URL lama jika ada untuk mencegah memory leak
    if (temporaryImageUrl.value) {
        URL.revokeObjectURL(temporaryImageUrl.value);
    }
    
    const newUrl = URL.createObjectURL(file);
    imagePreview.value = newUrl;
    temporaryImageUrl.value = newUrl;
  }
}

const applyFormat = (format: string, options?: any) => {
    if (!editor.value) return;
    const chain = editor.value.chain().focus();
    (chain as any)[format](options).run();
};

const setLink = () => {
  if (!editor.value) return;
  const previousUrl = editor.value.getAttributes('link').href;
  const url = window.prompt('URL', previousUrl);
  if (url === null) return;
  if (url === '') {
    editor.value.chain().focus().extendMarkRange('link').unsetLink().run();
    return;
  }
  editor.value.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
};

// PERBAIKAN: Fungsi untuk membuka dan menutup modal
const openImageModal = () => {
    if (imagePreview.value) {
        showImageModal.value = true;
    }
};
const closeImageModal = () => {
    showImageModal.value = false;
};


onBeforeUnmount(() => {
  editor.value?.destroy();
});

onUnmounted(() => {
    if (temporaryImageUrl.value) {
        URL.revokeObjectURL(temporaryImageUrl.value);
    }
});


const updatePost = () => {
  form.post(route('admin.posts.update', props.post.id));
};
</script>

<template>
  <div>
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-black">Edit Berita</h1>
      <p class="mt-1 text-black">Perbarui detail berita untuk website Fakultas Sains dan Teknologi.</p>
    </div>

    <div class="bg-white shadow-sm p-8 rounded-lg">
      <form @submit.prevent="updatePost">
        <div class="grid grid-cols-1 md:grid-cols-[150px_1fr] gap-x-8 gap-y-8">
            
            <label for="title" class="pt-2 text-sm font-semibold text-black">Judul Berita *</label>
            <div>
                <input type="text" id="title" v-model="form.title" class="block w-full rounded-md border-gray-300 shadow-sm" required />
                <p v-if="form.errors.title" class="mt-2 text-sm text-red-600">{{ form.errors.title }}</p>
            </div>

            <label for="excerpt" class="pt-2 text-sm font-semibold text-black">Ringkasan Berita *</label>
            <div>
                <textarea id="excerpt" v-model="form.excerpt" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm" required></textarea>
                <p v-if="form.errors.excerpt" class="mt-2 text-sm text-red-600">{{ form.errors.excerpt }}</p>
            </div>

            <label for="content" class="pt-2 text-sm font-semibold text-black">Isi Konten Berita *</label>
            <div>
              <div v-if="editor" class="flex items-center flex-wrap gap-1 border border-b-0 border-gray-300 rounded-t-md p-2 bg-gray-50 text-gray-800">
                <button @click="applyFormat('toggleBold')" type="button" :class="{ 'is-active': editor.isActive('bold') }" class="toolbar-button"><span class="font-bold">B</span></button>
                <button @click="applyFormat('toggleItalic')" type="button" :class="{ 'is-active': editor.isActive('italic') }" class="toolbar-button"><span class="italic">I</span></button>
                <button @click="applyFormat('toggleUnderline')" type="button" :class="{ 'is-active': editor.isActive('underline') }" class="toolbar-button"><span class="underline">U</span></button>
                <button @click="applyFormat('toggleStrike')" type="button" :class="{ 'is-active': editor.isActive('strike') }" class="toolbar-button"><span class="line-through">S</span></button>
                <button @click="setLink" type="button" :class="{ 'is-active': editor.isActive('link') }" class="toolbar-button"><LinkIcon class="h-5 w-5" /></button>
                <div class="toolbar-divider"></div>
                <button @click="applyFormat('toggleHeading', { level: 2 })" type="button" :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }" class="toolbar-button"><span class="text-md font-bold">H2</span></button>
                <button @click="applyFormat('toggleHeading', { level: 3 })" type="button" :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }" class="toolbar-button"><span class="text-sm font-bold">H3</span></button>
                <button @click="applyFormat('toggleBlockquote')" type="button" :class="{ 'is-active': editor.isActive('blockquote') }" class="toolbar-button">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M9.983 3v7.391c0 2.908-2.353 5.261-5.261 5.261v3.65c4.894 0 8.87-3.977 8.87-8.87V3h-3.609zM21.017 3v7.391c0 2.908-2.353 5.261-5.261 5.261v3.65c4.894 0 8.87-3.977 8.87-8.87V3h-3.609z"/></svg>
                </button>
                <div class="toolbar-divider"></div>
                <button @click="applyFormat('toggleBulletList')" type="button" :class="{ 'is-active': editor.isActive('bulletList') }" class="toolbar-button">
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h2v2H4V4zm4 0h12v2H8V4zM4 11h2v2H4v-2zm4 0h12v2H8v-2zm-4 7h2v2H4v-2zm4 0h12v2H8v-2z"/></svg>
                </button>
                <button @click="applyFormat('toggleOrderedList')" type="button" :class="{ 'is-active': editor.isActive('orderedList') }" class="toolbar-button">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M5.83 4.242H8v2H4.5V4.742l1.33-.5zM4.5 11h3.5v2H4.5v-2zm0 7h3.5v2H4.5v-2zM9.5 4h10v2h-10V4zm0 7h10v2h-10v-2zm0 7h10v2h-10v-2zM4.03 4.9v.8L2.5 7H4.5V9H1V4h1.5v.9l1.53-1.8z"/></svg>
                </button>
                 <div class="toolbar-divider"></div>
                <button @click="applyFormat('setTextAlign', 'left')" type="button" :class="{ 'is-active': editor.isActive({ textAlign: 'left' }) }" class="toolbar-button">
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 4h18v2H3V4zm0 7h12v2H3v-2zm0 7h18v2H3v-2z"/></svg>
                </button>
                 <button @click="applyFormat('setTextAlign', 'center')" type="button" :class="{ 'is-active': editor.isActive({ textAlign: 'center' }) }" class="toolbar-button">
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 4h18v2H3V4zm3 7h12v2H6v-2zm-3 7h18v2H3v-2z"/></svg>
                </button>
                 <button @click="applyFormat('setTextAlign', 'right')" type="button" :class="{ 'is-active': editor.isActive({ textAlign: 'right' }) }" class="toolbar-button">
                  <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 4h18v2H3V4zm9 7h9v2h-9v-2zm-9 7h18v2H3v-2z"/></svg>
                </button>
                <div class="toolbar-divider"></div>
                <button @click="applyFormat('undo')" type="button" :disabled="!editor.can().undo()" class="toolbar-button">
                    <ArrowUturnLeftIcon class="h-5 w-5"/>
                </button>
                <button @click="applyFormat('redo')" type="button" :disabled="!editor.can().redo()" class="toolbar-button">
                    <ArrowUturnRightIcon class="h-5 w-5"/>
                </button>
              </div>
              <EditorContent :editor="editor" />
              <p v-if="form.errors.content" class="mt-2 text-sm text-red-600">{{ form.errors.content }}</p>
            </div>
            
            <label for="category" class="pt-2 text-sm font-semibold text-black">Kategori *</label>
            <div>
                <select id="category" v-model="form.category" class="block w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="" disabled>Pilih kategori</option>
                    <option>Prestasi</option>
                    <option>Liputan Kegiatan</option>
                    <option>Kerjasama</option>
                </select>
                <p v-if="form.errors.category" class="mt-2 text-sm text-red-600">{{ form.errors.category }}</p>
            </div>

            <label for="tags" class="pt-2 text-sm font-semibold text-black">Tags</label>
            <div>
                <textarea id="tags" v-model="form.tags" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                <p v-if="form.errors.tags" class="mt-2 text-sm text-red-600">{{ form.errors.tags }}</p>
            </div>

            <label for="status" class="pt-2 text-sm font-semibold text-black">Status *</label>
            <div>
                <select id="status" v-model="form.status" class="block w-full rounded-md border-gray-300 shadow-sm">
                    <option>Draft</option>
                    <option>Terbitkan</option>
                </select>
            </div>
            
            <label for="image" class="pt-2 text-sm font-semibold text-black">Gambar</label>
            <div>
              <!-- PERBAIKAN: Pratinjau gambar sekarang bisa diklik -->
              <div v-if="imagePreview" class="mb-4">
                <img 
                    :src="imagePreview" 
                    alt="Preview Gambar" 
                    class="w-48 h-auto rounded-lg object-cover cursor-pointer hover:opacity-80 transition-opacity"
                    @click="openImageModal"
                >
              </div>
              <div class="relative flex items-center w-full rounded-md border border-gray-300 bg-white shadow-sm px-4 py-2">
                  <PaperClipIcon class="h-5 w-5 text-gray-400" />
                  <span class="ml-3 text-sm" :class="{'text-gray-400': !form.image, 'text-black': form.image}">
                    {{ form.image ? form.image.name : 'Pilih gambar baru (opsional)' }}
                  </span>
                  <input
                      type="file"
                      id="image"
                      @change="handleImageChange"
                      class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                  />
              </div>
              <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah gambar.</p>
              <p v-if="form.errors.image" class="mt-2 text-sm text-red-600">{{ form.errors.image }}</p>
            </div>

        </div>

        <div class="mt-12 flex items-center justify-between">
            <Link 
                :href="route('admin.posts.index')" 
                class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50"
            >
                <ArrowLeftIcon class="h-5 w-5" />
                Kembali
            </Link>

            <div class="flex gap-4">
                <button type="submit" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 disabled:opacity-50">
                    <PencilSquareIcon class="h-5 w-5" />
                    Perbarui Berita
                </button>
            </div>
        </div>
      </form>
    </div>
  </div>

  <!-- PERBAIKAN: Tambahkan Modal untuk Pratinjau Gambar Penuh -->
  <Teleport to="body">
    <div v-if="showImageModal" @keydown.escape="closeImageModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-75 transition-opacity">
      <div class="relative w-full max-w-4xl max-h-[90vh]" @click.stop>
        <img :src="imagePreview!" alt="Preview Gambar Penuh" class="w-full h-full object-contain rounded-lg">
        <button @click="closeImageModal" class="absolute -top-2 -right-2 bg-white rounded-full p-2 text-gray-800 hover:bg-gray-200 transition shadow-lg">
          <XMarkIcon class="h-6 w-6" />
        </button>
      </div>
    </div>
  </Teleport>
</template>

<style>
/* Gaya Tiptap Editor */
.ProseMirror {
  outline: none;
}
.toolbar-button {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 32px;
  height: 32px;
  border-radius: 4px;
  transition: background-color 0.2s;
}
.toolbar-button:hover {
  background-color: #e5e7eb;
}
.toolbar-button.is-active {
  background-color: #d1d5db;
}
.toolbar-divider {
    width: 1px;
    height: 20px;
    background-color: #d1d5db;
    margin: 0 8px;
}
</style>

