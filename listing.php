<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RigMarket PH - Make a Listing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <script>
        tailwind.config = { theme: { extend: { colors: { brand: '#D2232A', brandDark: '#A81C21', brandLight: '#FCECEC' } } } }
    </script>
</head>
<body class="bg-slate-900 text-slate-100 font-sans flex flex-col min-h-screen">

    <!-- navbar -->
    <nav class="bg-slate-900 text-white border-b border-slate-800 sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold text-brand tracking-tight">
                <i class="fas fa-microchip mr-2"></i>RigMarket<span class="text-white">PH</span>
            </a>
            <div class="hidden md:flex space-x-6 items-center">
                <a href="index.php" class="text-slate-300 hover:text-brand transition font-medium">Home</a>
                <a href="products.php" class="text-slate-300 hover:text-brand transition font-medium">Browse Market</a>
                <a href="about.php" class="text-slate-300 hover:text-brand transition font-medium">About Us</a>
                <a href="contact.php" class="text-slate-300 hover:text-brand transition font-medium">Contact</a>
                <a href="login.php" class="bg-brand hover:bg-brandDark text-white px-5 py-2 rounded font-semibold transition shadow-sm"><i class="fas fa-user mr-1"></i> Login / Register</a>
            </div>
            <button id="mobile-menu-btn" class="md:hidden text-2xl"><i class="fas fa-bars"></i></button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-slate-800 border-t border-slate-700 shadow-lg">
            <div class="flex flex-col px-4 py-2 space-y-3">
                <a href="index.php" class="block py-1 hover:text-brand text-slate-300">Home</a>
                <a href="products.php" class="block py-1 hover:text-brand text-slate-300">Browse Market</a>
                <a href="about.php" class="block py-1 hover:text-brand text-slate-300">About Us</a>
                <a href="contact.php" class="block py-1 hover:text-brand text-slate-300">Contact</a>
                <a href="login.php" class="block py-1 text-brand font-semibold"><i class="fas fa-user mr-1"></i> Login / Register</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-10 flex-grow">
        <div class="max-w-2xl mx-auto">
            <!-- listing form -->
            <div class="bg-slate-800 rounded-lg shadow-sm border border-slate-700 p-6 md:p-8">
                <h2 class="text-2xl font-bold text-white mb-2 border-b pb-4"><i class="fas fa-tag text-brand mr-2"></i>Post a Listing</h2>
                <p class="text-sm text-slate-400 mb-6">Fill out the details below to list your item on the marketplace.</p>

                <form id="listing-form" class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1">Item Title</label>
                        <input type="text" required id="post-title" placeholder="e.g. Ryzen 5 5600X Complete Box" class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1">Category</label>
                            <select id="post-category" required class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2 focus:outline-none focus:border-brand bg-slate-800">
                                <option value="">Select Category...</option>
                                <option value="Processors">Processors (CPU)</option>
                                <option value="Graphics Cards (GPU)">Graphics Cards (GPU)</option>
                                <option value="Laptops">Laptops</option>
                                <option value="Monitors">Monitors</option>
                                <option value="Peripherals">Peripherals</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1">Price (&#8369;)</label>
                            <input type="number" required id="post-price" placeholder="e.g. 7500" class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1">Condition</label>
                            <select id="post-condition" required class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2 focus:outline-none focus:border-brand bg-slate-800">
                                <option value="">Select Condition...</option>
                                <option value="Brand New">Brand New</option>
                                <option value="Like New">Like New</option>
                                <option value="Slightly Used">Slightly Used</option>
                                <option value="Defective / Parts Only">Defective / Parts Only</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1">Location</label>
                            <input type="text" required id="post-location" placeholder="e.g. Bi&ntilde;an, Laguna" class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1">Description / Specs</label>
                        <textarea id="post-specs" required rows="4" placeholder="Enter specifications (e.g. 16GB RAM, RTX 3060)..." class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1">Image URL (Optional)</label>
                        <input type="url" id="post-image" placeholder="https://images.unsplash.com/... (optional)" class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2 focus:outline-none focus:border-brand">
                    </div>

                    <button type="submit" class="w-full bg-brand text-white font-bold py-3 rounded hover:bg-brandDark transition shadow-md">
                        Post Listing
                    </button>
                </form>
            </div>
        </div>
    </main>

    <!-- footer -->
    <footer class="bg-slate-800 text-slate-400 py-6 border-t border-slate-700 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm">&copy; 2024 RigMarket PH. Support Local Tech.</p>
        </div>
    </footer>

    <!-- scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
