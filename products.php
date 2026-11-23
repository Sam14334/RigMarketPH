<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RigMarket PH - Browse Products</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <script>
        tailwind.config = {
            theme: { extend: { colors: { brand: '#D2232A', brandDark: '#A81C21', brandLight: '#FCECEC' } } }
        }
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
                <a href="products.php" class="text-brand font-semibold">Browse Market</a>
                <a href="about.php" class="text-slate-300 hover:text-brand transition font-medium">About Us</a>
                <a href="contact.php" class="text-slate-300 hover:text-brand transition font-medium">Contact</a>
                <a href="login.php" class="bg-brand hover:bg-brandDark text-white px-5 py-2 rounded font-semibold transition shadow-sm"><i class="fas fa-user mr-1"></i> Login / Register</a>
            </div>
            <button id="mobile-menu-btn" class="md:hidden text-2xl focus:outline-none"><i class="fas fa-bars"></i></button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-slate-800 border-t border-slate-700 shadow-lg">
            <div class="flex flex-col px-4 py-2 space-y-3">
                <a href="index.php" class="block py-1 hover:text-brand text-slate-300">Home</a>
                <a href="products.php" class="text-brand font-semibold block py-1">Browse Market</a>
                <a href="about.php" class="block py-1 hover:text-brand text-slate-300">About Us</a>
                <a href="contact.php" class="block py-1 hover:text-brand text-slate-300">Contact</a>
                <a href="login.php" class="block py-1 text-brand font-semibold"><i class="fas fa-user mr-1"></i> Login / Register</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 flex-grow">
        <!-- search bar -->
        <div class="mb-8">
            <form id="market-search-form" class="flex flex-col md:flex-row bg-slate-800 border border-slate-700 rounded-lg overflow-hidden shadow-lg p-1">
                <div class="flex-grow flex items-center px-4 py-3 md:border-r border-slate-700">
                    <i class="fas fa-search text-gray-400 mr-3"></i>
                    <input id="market-search-input" type="text" placeholder="Search for RTX 3060, Keyboards, Monitors..." class="w-full focus:outline-none bg-transparent text-white placeholder-gray-400">
                </div>
                <div class="flex-grow flex items-center px-4 py-3 md:border-r border-slate-700 mt-2 md:mt-0">
                    <i class="fas fa-map-marker-alt text-brand mr-3"></i>
                    <select id="market-location-select" class="w-full focus:outline-none bg-transparent text-white cursor-pointer appearance-none">
                        <option value="" class="bg-slate-800">All Locations</option>
                        <option value="binan" class="bg-slate-800">Bi&ntilde;an, Laguna</option>
                        <option value="manila" class="bg-slate-800">Metro Manila</option>
                        <option value="cavite" class="bg-slate-800">Cavite</option>
                    </select>
                </div>
                <button type="submit" class="bg-brand hover:bg-brandDark text-white font-bold py-3 px-8 mt-2 md:mt-0 rounded-md transition w-full md:w-auto shadow-md">
                    Search
                </button>
            </form>
        </div>

        <div class="flex flex-col md:flex-row gap-6">
            <button id="filter-toggle-btn" class="md:hidden bg-slate-800 border border-slate-600 p-2 rounded text-center font-semibold mb-2">
                <i class="fas fa-filter mr-2"></i> Toggle Filters
            </button>

        <!-- sidebar filters -->
        <aside id="sidebar-filters" class="hidden md:block w-full md:w-1/4 bg-slate-800 border border-slate-700 rounded-lg p-5 h-fit shadow-sm">
            <h2 class="text-lg font-bold border-b pb-2 mb-4">Filters</h2>
            
            <div class="mb-5">
                <h3 class="font-semibold text-slate-300 mb-2">Category</h3>
                <div class="space-y-2 text-sm">
                    <label class="flex items-center"><input type="checkbox" class="filter-category mr-2 rounded text-brand" value="Processors"> Processors</label>
                    <label class="flex items-center"><input type="checkbox" class="filter-category mr-2 rounded text-brand" value="Graphics Cards (GPU)"> Graphics Cards (GPU)</label>
                    <label class="flex items-center"><input type="checkbox" class="filter-category mr-2 rounded text-brand" value="Laptops"> Laptops</label>
                    <label class="flex items-center"><input type="checkbox" class="filter-category mr-2 rounded text-brand" value="Monitors"> Monitors</label>
                    <label class="flex items-center"><input type="checkbox" class="filter-category mr-2 rounded text-brand" value="Peripherals"> Peripherals</label>
                </div>
            </div>

            <div class="mb-5">
                <h3 class="font-semibold text-slate-300 mb-2">Price Range</h3>
                <div class="flex items-center space-x-2">
                    <input type="number" id="min-price" placeholder="Min" class="w-1/2 bg-slate-700 text-white border-slate-600 border p-1 rounded text-sm">
                    <span>-</span>
                    <input type="number" id="max-price" placeholder="Max" class="w-1/2 bg-slate-700 text-white border-slate-600 border p-1 rounded text-sm">
                </div>
            </div>

            <div class="mb-5">
                <h3 class="font-semibold text-slate-300 mb-2">Condition</h3>
                <div class="space-y-2 text-sm">
                    <label class="flex items-center"><input type="checkbox" class="filter-condition mr-2 rounded text-brand" value="Brand New"> Brand New</label>
                    <label class="flex items-center"><input type="checkbox" class="filter-condition mr-2 rounded text-brand" value="Like New"> Like New</label>
                    <label class="flex items-center"><input type="checkbox" class="filter-condition mr-2 rounded text-brand" value="Slightly Used"> Slightly Used</label>
                </div>
            </div>

            <div class="mb-5">
                <h3 class="font-semibold text-slate-300 mb-2">Brands</h3>
                <div class="space-y-2 text-sm">
                    <label class="flex items-center"><input type="checkbox" class="filter-brand mr-2 rounded text-brand" value="NVIDIA"> NVIDIA</label>
                    <label class="flex items-center"><input type="checkbox" class="filter-brand mr-2 rounded text-brand" value="AMD"> AMD</label>
                    <label class="flex items-center"><input type="checkbox" class="filter-brand mr-2 rounded text-brand" value="Intel"> Intel</label>
                    <label class="flex items-center"><input type="checkbox" class="filter-brand mr-2 rounded text-brand" value="Asus"> Asus</label>
                    <label class="flex items-center"><input type="checkbox" class="filter-brand mr-2 rounded text-brand" value="Lenovo"> Lenovo</label>
                    <label class="flex items-center"><input type="checkbox" class="filter-brand mr-2 rounded text-brand" value="Gigabyte"> Gigabyte</label>
                    <label class="flex items-center"><input type="checkbox" class="filter-brand mr-2 rounded text-brand" value="Acer"> Acer</label>
                </div>
            </div>
        </aside>

        <!-- product listings -->
        <main class="w-full md:w-3/4">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-white">All Results</h1>
                <select id="sort-select" class="bg-slate-700 text-white border border-slate-600 rounded p-2 text-sm focus:outline-none focus:border-brand">
                    <option value="newest">Sort by: Newest</option>
                    <option value="price-asc">Sort by: Price (Low to High)</option>
                    <option value="price-desc">Sort by: Price (High to Low)</option>
                </select>
            </div>

            <div id="products-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"></div>
            
            <!-- pagination -->
            <div id="pagination-controls" class="mt-10 flex justify-center space-x-2 flex-wrap gap-y-2"></div>
        </main>
    </div>
    </div>

    <!-- footer -->
    <footer class="bg-slate-800 text-slate-400 py-8 border-t border-slate-700 mt-auto">
        <div class="container mx-auto px-4 text-center md:text-left flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <a href="index.php" class="text-xl font-bold text-white tracking-tight">RigMarketPH</a>
            </div>
            <div class="space-x-4 text-sm">
                <a href="about.php" class="hover:text-white transition">About Us</a>
            </div>
        </div>
    </footer>

    <!-- scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
