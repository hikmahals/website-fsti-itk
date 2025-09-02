<script setup lang="ts">
import { onBeforeUnmount } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import { 
    BookmarkIcon, 
    PaperAirplaneIcon,
    PaperClipIcon,
    ArrowUturnLeftIcon,
    ArrowUturnRightIcon,
    LinkIcon,
    ArrowLeftIcon, // PERUBAHAN: Menambahkan ikon untuk tombol kembali
} from '@heroicons/vue/24/outline';

import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import TiptapLink from '@tiptap/extension-link';
import TextAlign from '@tiptap/extension-text-align';

defineOptions({ layout: AdminLayout });

const form = useForm({
  title: '',
  excerpt: '',
  content: '',
  category: '',
  tags: '',
  status: 'Draft',
  image: null as File | null,
});

const editor = useEditor({
  content: form.content,
  extensions: [
    StarterKit,
    Underline,
    TiptapLink.configure({
      openOnClick: false,
    }),
    TextAlign.configure({
      types: ['heading', 'paragraph'],
    }),
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


onBeforeUnmount(() => {
  editor.value?.destroy();
});

const saveAsDraft = () => {
  form.status = 'Draft';
  form.post(route('admin.posts.store'));
};

const publishPost = () => {
  form.status = 'Terbitkan';
  form.post(route('admin.posts.store'));
};
</script>

<template>
  <div>
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-black">Tambah Berita</h1>
      <p class="mt-1 text-black">Buat berita baru untuk website Fakultas Sains dan Teknologi Institut Teknologi Kalimantan</p>
    </div>

    <div class="bg-white shadow-sm p-8 rounded-lg">
      <form @submit.prevent>
        <div class="grid grid-cols-1 md:grid-cols-[150px_1fr] gap-x-8 gap-y-8">
            
            <!-- Judul Berita -->
            <label for="title" class="pt-2 text-sm font-semibold text-black">Judul Berita *</label>
            <div>
              <input
                type="text"
                id="title"
                v-model="form.title"
                placeholder="Masukkan judul berita"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required
              />
              <p v-if="form.errors.title" class="mt-2 text-sm text-red-600">{{ form.errors.title }}</p>
            </div>

            <!-- Ringkasan Berita -->
            <label for="excerpt" class="pt-2 text-sm font-semibold text-black">Ringkasan Berita *</label>
            <div>
              <textarea
                id="excerpt"
                v-model="form.excerpt"
                placeholder="Tulis ringkasan berita yang akan ditampilkan pada beranda"
                rows="3"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required
              ></textarea>
              <p v-if="form.errors.excerpt" class="mt-2 text-sm text-red-600">{{ form.errors.excerpt }}</p>
            </div>

            <!-- Isi Konten (Rich Text Editor) -->
            <label for="content" class="pt-2 text-sm font-semibold text-black">Isi Konten Berita *</label>
            <div>
              <div v-if="editor" class="flex items-center flex-wrap gap-1 border border-b-0 border-gray-300 rounded-t-md p-2 bg-gray-50 text-gray-800">
                <button @click="applyFormat('toggleBold')" type="button" :class="{ 'is-active': editor.isActive('bold') }" class="toolbar-button">
                  <span class="font-bold">B</span>
                </button>
                <button @click="applyFormat('toggleItalic')" type="button" :class="{ 'is-active': editor.isActive('italic') }" class="toolbar-button">
                  <span class="italic">I</span>
                </button>
                <button @click="applyFormat('toggleUnderline')" type="button" :class="{ 'is-active': editor.isActive('underline') }" class="toolbar-button">
                  <span class="underline">U</span>
                </button>
                <button @click="applyFormat('toggleStrike')" type="button" :class="{ 'is-active': editor.isActive('strike') }" class="toolbar-button">
                  <span class="line-through">S</span>
                </button>
                <button @click="setLink" type="button" :class="{ 'is-active': editor.isActive('link') }" class="toolbar-button">
                  <LinkIcon class="h-5 w-5" />
                </button>
                <div class="toolbar-divider"></div>
                <button @click="applyFormat('toggleHeading', { level: 2 })" type="button" :class="{ 'is-active': editor.isActive('heading', { level: 2 }) }" class="toolbar-button">
                  <span class="text-md font-bold">H2</span>
                </button>
                <button @click="applyFormat('toggleHeading', { level: 3 })" type="button" :class="{ 'is-active': editor.isActive('heading', { level: 3 }) }" class="toolbar-button">
                  <span class="text-sm font-bold">H3</span>
                </button>
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

            <!-- Kategori -->
            <label for="category" class="pt-2 text-sm font-semibold text-black">Kategori *</label>
            <div>
              <select
                id="category"
                v-model="form.category"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
                required
              >
                <option value="" disabled>Pilih kategori berita</option>
                <option value="Prestasi">Prestasi</option>
                <option value="Liputan Kegiatan">Liputan Kegiatan</option>
                <option value="Kerjasama">Kerjasama</option>
              </select>
              <p v-if="form.errors.category" class="mt-2 text-sm text-red-600">{{ form.errors.category }}</p>
            </div>

            <!-- Tags -->
            <label for="tags" class="pt-2 text-sm font-semibold text-black">Tags</label>
            <div>
                <textarea
                    id="tags"
                    rows="2"
                    v-model="form.tags"
                    placeholder="Masukkan kata kunci terkait berita untuk memudahkan pencarian, pisahkan dengan koma. Contoh: Workshop, AI, Kerjasama"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder:text-sm"
                ></textarea>
                <p v-if="form.errors.tags" class="mt-2 text-sm text-red-600">{{ form.errors.tags }}</p>
            </div>
            
            <!-- Status -->
            <label for="status" class="pt-2 text-sm font-semibold text-black">Status *</label>
            <div>
              <select
                id="status"
                v-model="form.status"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors"
              >
                <option value="Draft">Draft</option>
                <option value="Terbitkan">Terbitkan</option>
              </select>
            </div>

            <!-- Gambar -->
            <label for="image" class="pt-2 text-sm font-semibold text-black">Gambar *</label>
            <div>
              <div class="relative flex items-center w-full rounded-md border border-gray-300 bg-white shadow-sm px-4 py-2">
                  <PaperClipIcon class="h-5 w-5 text-gray-400" />
                  <span class="ml-3 text-sm" :class="{'text-gray-400': !form.image, 'text-black': form.image}">
                    {{ form.image ? form.image.name : 'Masukkan gambar yang sesuai' }}
                  </span>
                  <input
                      type="file"
                      id="image"
                      @input="form.image = ($event.target as HTMLInputElement).files?.[0] || null"
                      class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                  />
              </div>
              <p v-if="form.errors.image" class="mt-2 text-sm text-red-600">{{ form.errors.image }}</p>
            </div>

        </div>

        <!-- PERUBAHAN: Tombol Aksi diubah layoutnya -->
        <div class="mt-12 flex items-center justify-between">
            <!-- Tombol Kembali -->
            <Link 
                :href="route('admin.posts.index')" 
                class="flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50"
            >
                <ArrowLeftIcon class="h-5 w-5" />
                Kembali
            </Link>

            <!-- Grup Tombol Kanan -->
            <div class="flex gap-4">
                <button @click="saveAsDraft" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-[#CBDCEB] px-4 py-2 text-sm font-semibold text-black hover:bg-opacity-80 disabled:opacity-50">
                    <BookmarkIcon class="h-5 w-5" />
                    Simpan Draf
                </button>
                <button @click="publishPost" :disabled="form.processing" class="flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 disabled:opacity-50">
                    <PaperAirplaneIcon class="h-5 w-5" />
                    Terbitkan
                </button>
            </div>
        </div>
      </form>
    </div>
  </div>
</template>

<style>
/* Gaya dasar untuk konten di dalam editor Tiptap */
.ProseMirror {
  outline: none;
}

.ProseMirror p {
  margin: 0;
}

/* Gaya untuk tombol toolbar */
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
  background-color: #e5e7eb; /* gray-200 */
}

.toolbar-button.is-active {
  background-color: #d1d5db; /* gray-300 */
  color: #111827; /* gray-900 */
}

.toolbar-button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.toolbar-divider {
  width: 1px;
  background-color: #d1d5db; /* gray-300 */
  margin-left: 4px;
  margin-right: 4px;
  align-self: stretch;
  height: 24px;
}
</style>