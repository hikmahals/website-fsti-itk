export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
};

// --- TIPE UNTUK HALAMAN BERITA ---

export interface Post {
  id: number;
  title: string;
  slug: string;
  excerpt: string;
  content: string;
  image_url: string | null; // Sesuai dengan accessor yang Anda buat
  category: 'Prestasi' | 'Liputan Kegiatan' | 'Kerjasama';
  tags: string | null;
  status: 'Draft' | 'Terbitkan';
  published_at: string | null;
  views: number;
  created_at: string;
  updated_at: string;
  thumbnail_url: string;
}

export interface PaginatorLink {
  url: string | null;
  label: string;
  active: boolean;
}

export interface PaginatedPosts {
  data: Post[];
  links: PaginatorLink[];
  from: number;
  to: number;
  total: number;
}

// Tipe untuk menampung filter yang dikirim dari controller
export interface Filters {
    search: string | null;
    category: string | null;
    level?: string; // Tambahkan ini
    year?: string;   // Tambahkan ini
}

export interface Achievement {
  id: number;
  student_name: string;
  student_nim: string;
  study_program: string;
  achievement_name: string;
  category: 'Akademik' | 'Non-Akademik';
  level: 'Internasional' | 'Nasional' | 'Provinsi' | 'Kota/Kabupaten' | 'Universitas';
  organizer: string;
  year: number;
  proof_url?: string | null; // URL lengkap untuk file bukti
  photo_path: string;

  photo_url: string;
  proof_url?: string | null;
}

export interface PaginatedAchievements {
  data: Achievement[];
  links: PaginatorLink[];
  from: number;
  to: number;
  total: number;
}