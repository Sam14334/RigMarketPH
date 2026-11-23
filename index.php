<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RigMarket PH - Home</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { brand: '#D2232A', brandDark: '#A81C21', brandLight: '#FCECEC' }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-900 text-slate-100 font-sans">
    <!-- navbar -->
    <nav class="bg-slate-900 text-white border-b border-slate-800 sticky top-0 z-50 shadow-sm">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold text-brand tracking-tight">
                <i class="fas fa-microchip mr-2"></i>RigMarket<span class="text-white">PH</span>
            </a>
            
            <div class="hidden md:flex space-x-6 items-center">
                <a href="index.php" class="text-brand font-semibold">Home</a>
                <a href="products.php" class="text-slate-300 hover:text-brand transition font-medium">Browse Market</a>
                <a href="about.php" class="text-slate-300 hover:text-brand transition font-medium">About Us</a>
                <a href="contact.php" class="text-slate-300 hover:text-brand transition font-medium">Contact</a>
                <a href="login.php" class="bg-brand hover:bg-brandDark text-white px-5 py-2 rounded font-semibold transition shadow-sm"><i class="fas fa-user mr-1"></i> Login / Register</a>
            </div>

            <button id="mobile-menu-btn" class="md:hidden text-2xl focus:outline-none">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-slate-800 border-t border-slate-700 shadow-lg">
            <div class="flex flex-col px-4 py-2 space-y-3">
                <a href="index.php" class="text-brand font-semibold block py-1">Home</a>
                <a href="products.php" class="block py-1 hover:text-brand text-slate-300">Browse Market</a>
                <a href="about.php" class="block py-1 hover:text-brand text-slate-300">About Us</a>
                <a href="contact.php" class="block py-1 hover:text-brand text-slate-300">Contact</a>
                <a href="login.php" class="block py-1 text-brand font-semibold"><i class="fas fa-user mr-1"></i> Login / Register</a>
            </div>
        </div>
    </nav>

    <!-- hero section -->
    <header class="relative bg-slate-900 text-white py-24 px-4 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://bwtggiazgqmcwxxrzswl.supabase.co/storage/v1/object/public/website-images/GIGABYTE%20GAMING%20A16.jpg" alt="PC Gaming Setup" class="w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
        </div>

        <div class="container mx-auto max-w-4xl text-center relative z-10">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-400 drop-shadow-md">Find & Sell PC Parts Locally</h1>
            <p class="text-lg md:text-xl text-gray-300 mb-10 drop-shadow">The trusted P2P classifieds for the Philippine PC building and gaming community.</p>
            
            <form id="search-form" class="flex flex-col md:flex-row bg-slate-800/90 backdrop-blur-md rounded-lg overflow-hidden shadow-2xl p-1 border border-slate-700">
                <div class="flex-grow flex items-center px-4 py-3 md:border-r border-slate-700">
                    <i class="fas fa-search text-gray-400 mr-3"></i>
                    <input id="home-search-input" type="text" placeholder="Search for RTX 3060, Keyboards..." class="w-full focus:outline-none bg-transparent text-white placeholder-gray-400">
                </div>
                <div class="flex-grow flex items-center px-4 py-3 md:border-r border-slate-700 mt-2 md:mt-0">
                    <i class="fas fa-map-marker-alt text-brand mr-3"></i>
                    <select id="home-location-select" class="w-full focus:outline-none bg-transparent text-white cursor-pointer appearance-none">
                        <option value="" class="bg-slate-800">All Locations</option>
                        <option value="binan" class="bg-slate-800">Bi&ntilde;an, Laguna</option>
                        <option value="manila" class="bg-slate-800">Metro Manila</option>
                        <option value="cavite" class="bg-slate-800">Cavite</option>
                    </select>
                </div>
                <button type="submit" class="bg-brand hover:bg-brandDark text-white font-bold py-3 px-8 mt-2 md:mt-0 rounded-md transition w-full md:w-auto shadow-lg">
                    Search
                </button>
            </form>
        </div>
    </header>

    <!-- fresh listings -->
    <section class="py-10 bg-slate-900 border-t border-slate-800">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-end mb-4">
                <h2 id="fresh-listings-title" class="text-2xl font-bold text-white">Fresh Listings</h2>
                <a href="products.php" class="text-brand hover:underline font-semibold">View All <i class="fas fa-arrow-right text-sm"></i></a>
            </div>

            <!-- category filters -->
            <div class="flex gap-3 overflow-x-auto pb-4 mb-4 hide-scrollbar whitespace-nowrap" style="scrollbar-width: none; -ms-overflow-style: none;">
                <button data-category="All" class="home-category-btn active-category inline-block px-5 py-2 border border-brand text-brand rounded-full transition focus:outline-none">All</button>
                <style>
                    .hide-scrollbar::-webkit-scrollbar { display: none; }
                </style>
                <button data-category="Processors" class="home-category-btn inline-block px-5 py-2 border border-slate-600 rounded-full text-slate-300 hover:border-brand hover:text-brand transition focus:outline-none">Processors</button>
                <button data-category="Graphics Cards (GPU)" class="home-category-btn inline-block px-5 py-2 border border-slate-600 rounded-full text-slate-300 hover:border-brand hover:text-brand transition focus:outline-none">GPUs</button>
                <button data-category="Laptops" class="home-category-btn inline-block px-5 py-2 border border-slate-600 rounded-full text-slate-300 hover:border-brand hover:text-brand transition focus:outline-none">Laptops</button>
                <button data-category="Monitors" class="home-category-btn inline-block px-5 py-2 border border-slate-600 rounded-full text-slate-300 hover:border-brand hover:text-brand transition focus:outline-none">Monitors</button>
                <button data-category="Peripherals" class="home-category-btn inline-block px-5 py-2 border border-slate-600 rounded-full text-slate-300 hover:border-brand hover:text-brand transition focus:outline-none">Peripherals</button>
                <button data-category="Full Rigs" class="home-category-btn inline-block px-5 py-2 border border-slate-600 rounded-full text-slate-300 hover:border-brand hover:text-brand transition focus:outline-none">Full Rigs</button>
            </div>
            
            <div id="recent-listings-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"></div>
        </div>
    </section>

    <!-- footer -->
    <footer class="bg-slate-800 text-slate-400 py-8 border-t border-slate-700">
        <div class="container mx-auto px-4 text-center md:text-left flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <a href="index.php" class="text-xl font-bold text-white tracking-tight">
                    <i class="fas fa-microchip mr-1"></i>RigMarketPH
                </a>
                <p class="text-sm mt-2">Connecting Filipino PC enthusiasts since 2024.</p>
            </div>
            <div class="space-x-4 text-sm">
                <a href="#" class="hover:text-white transition">Terms of Service</a>
                <a href="#" class="hover:text-white transition">Privacy Policy</a>
                <a href="about.php" class="hover:text-white transition">About Us</a>
            </div>
        </div>
    </footer>

    <!-- scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="script.js"></script>
</body>
</html>

