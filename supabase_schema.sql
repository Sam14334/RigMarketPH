-- ==============================================================================
-- RigMarket PH — Cloud Database Schema (Supabase PostgreSQL)
-- Target Project: Sam's Project (bwtggiazgqmcwxxrzswl)
-- Stack: PostgreSQL 15+, PostgREST, Supabase Storage
-- ==============================================================================

-- 1. USERS TABLE
CREATE TABLE IF NOT EXISTS public.users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

-- 2. CATEGORIES TABLE
CREATE TABLE IF NOT EXISTS public.categories (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE
);

-- Seed Categories
INSERT INTO public.categories (id, name, slug) VALUES
(1, 'Processors', 'processors'),
(2, 'Graphics Cards (GPU)', 'gpus'),
(3, 'Laptops', 'laptops'),
(4, 'Monitors', 'monitors'),
(5, 'Peripherals', 'peripherals')
ON CONFLICT (id) DO NOTHING;

-- 3. PRODUCTS TABLE
CREATE TABLE IF NOT EXISTS public.products (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES public.users(id) ON DELETE SET NULL,
    title VARCHAR(255) NOT NULL,
    price NUMERIC(12, 2) NOT NULL,
    category_id INT REFERENCES public.categories(id) ON DELETE SET NULL,
    condition VARCHAR(50) NOT NULL,
    brand VARCHAR(100) DEFAULT 'Other',
    location VARCHAR(150) NOT NULL,
    image TEXT NULL,
    specs TEXT NULL,
    description TEXT NULL,
    status VARCHAR(50) DEFAULT 'Available',
    seller_name VARCHAR(100) NULL,
    date_posted VARCHAR(50) NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

-- Performance Indexes for Products
CREATE INDEX IF NOT EXISTS idx_products_category_id ON public.products(category_id);
CREATE INDEX IF NOT EXISTS idx_products_user_id ON public.products(user_id);
CREATE INDEX IF NOT EXISTS idx_products_status ON public.products(status);

-- 4. LISTING IMAGES TABLE (Multi-Image Gallery Support)
CREATE TABLE IF NOT EXISTS public.listing_images (
    id SERIAL PRIMARY KEY,
    product_id INT NOT NULL REFERENCES public.products(id) ON DELETE CASCADE,
    image_url TEXT NOT NULL,
    storage_path TEXT NULL,
    is_primary BOOLEAN NOT NULL DEFAULT FALSE,
    display_order INT NOT NULL DEFAULT 0,
    alt_text VARCHAR(255) NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

-- Performance Indexes for Listing Images
CREATE INDEX IF NOT EXISTS idx_listing_images_product_id ON public.listing_images(product_id);
CREATE INDEX IF NOT EXISTS idx_listing_images_primary ON public.listing_images(product_id, is_primary);

-- 5. INQUIRIES TABLE (Contact Support Tickets)
CREATE TABLE IF NOT EXISTS public.inquiries (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    category VARCHAR(100) NOT NULL,
    issue VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

-- 6. MESSAGES TABLE (Buyer-Seller Inquiries / Chat)
CREATE TABLE IF NOT EXISTS public.messages (
    id SERIAL PRIMARY KEY,
    product_id INT REFERENCES public.products(id) ON DELETE CASCADE,
    sender_name VARCHAR(100) NOT NULL,
    sender_email VARCHAR(150) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

-- ==============================================================================
-- ROW LEVEL SECURITY (RLS) POLICIES
-- ==============================================================================

-- Enable RLS on all tables
ALTER TABLE public.users ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.categories ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.products ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.listing_images ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.inquiries ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.messages ENABLE ROW LEVEL SECURITY;

-- Public Read Policies
CREATE POLICY "Public read users" ON public.users FOR SELECT USING (true);
CREATE POLICY "Public read categories" ON public.categories FOR SELECT USING (true);
CREATE POLICY "Public read products" ON public.products FOR SELECT USING (true);
CREATE POLICY "Public read listing_images" ON public.listing_images FOR SELECT USING (true);
CREATE POLICY "Public read inquiries" ON public.inquiries FOR SELECT USING (true);
CREATE POLICY "Public read messages" ON public.messages FOR SELECT USING (true);

-- Public Write Policies (Application-level access)
CREATE POLICY "Public insert users" ON public.users FOR INSERT WITH CHECK (true);
CREATE POLICY "Public update users" ON public.users FOR UPDATE USING (true);
CREATE POLICY "Public insert products" ON public.products FOR INSERT WITH CHECK (true);
CREATE POLICY "Public update products" ON public.products FOR UPDATE USING (true);
CREATE POLICY "Public insert listing_images" ON public.listing_images FOR INSERT WITH CHECK (true);
CREATE POLICY "Public insert inquiries" ON public.inquiries FOR INSERT WITH CHECK (true);
CREATE POLICY "Public insert messages" ON public.messages FOR INSERT WITH CHECK (true);

-- ==============================================================================
-- STORAGE BUCKETS (Managed via Supabase Dashboard / storage schema)
-- ==============================================================================
-- Bucket 1: 'listings-iamges' -> Public bucket for user product uploads
-- Bucket 2: 'website-images'  -> Public bucket for UI/branding banners
-- ==============================================================================
