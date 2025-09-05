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

export interface Post {
  id: number;
  title: string;
  slug: string;
  excerpt: string;
  content: string;
  image_url: string | null;
  category: 'Prestasi' | 'Liputan Kegiatan' | 'Kerjasama';
  tags: string | null;
  status: 'Draft' | 'Terbitkan';
  published_at: string | null;
  views: number;
  created_at: string;
  updated_at: string;
}

export interface PaginatorLink {
  url: string | null;
  label: string;
  active: boolean;
}

export interface PaginatedPosts {
  data: Post[];
  links: PaginatorLink[];
}