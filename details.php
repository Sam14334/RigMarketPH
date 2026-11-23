<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RigMarket PH - Listing Details</title>
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
<body class="bg-slate-900 text-slate-100 font-sans flex flex-col min-h-screen">

    <!-- navbar -->
    <nav class="bg-slate-900 text-white border-b border-slate-800 shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold text-brand tracking-tight">
                <i class="fas fa-microchip mr-2"></i>RigMarket<span class="text-white">PH</span>
            </a>
            <div class="hidden md:flex space-x-6 items-center">
                <a href="index.php" class="text-slate-300 hover:text-brand transition font-medium">Home</a>
                <a href="products.php" class="text-slate-300 hover:text-brand transition font-medium">Browse Market</a>
                <a href="about.php" class="text-slate-300 hover:text-brand transition font-medium">About Us</a>
                <a href="contact.php" class="text-slate-300 hover:text-brand transition font-medium">Contact</a>
                <a href="login.php" class="bg-brand hover:bg-brandDark px-4 py-2 rounded-md font-semibold transition text-white">
                    <i class="fas fa-user mr-1"></i> Login / Register
                </a>
            </div>
            <button id="mobile-menu-btn" class="md:hidden text-2xl focus:outline-none"><i class="fas fa-bars"></i></button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-slate-800 border-t border-slate-700 shadow-lg">
            <div class="flex flex-col px-4 py-2 space-y-3">
                <a href="index.php" class="block py-1 text-slate-300 hover:text-brand">Home</a>
                <a href="products.php" class="block py-1 text-slate-300 hover:text-brand">Browse Market</a>
                <a href="about.php" class="block py-1 text-slate-300 hover:text-brand">About Us</a>
                <a href="contact.php" class="block py-1 hover:text-brand text-slate-300">Contact</a>
                <a href="login.php" class="block py-1 text-brand font-semibold"><i class="fas fa-user mr-1"></i> Login / Register</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8 max-w-6xl flex-grow">
        <a href="products.php" class="inline-block mb-6 text-brand hover:underline font-semibold">
            <i class="fas fa-arrow-left mr-1"></i> Back to Listings
        </a>

        <!-- product details card -->
        <div id="details-container" class="bg-slate-800 rounded-xl shadow-md border border-slate-700 overflow-hidden flex flex-col md:flex-row hidden">
            <div class="md:w-1/2 bg-slate-900 flex items-center justify-center border-r border-slate-700">
                <img id="detail-image" src="" alt="Product Image" class="w-full h-full object-cover max-h-[500px]">
            </div>
            
            <div class="md:w-1/2 p-6 md:p-10 flex flex-col">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center space-x-2">
                        <span id="detail-category" class="text-xs text-slate-300 font-bold uppercase tracking-wider bg-slate-700 px-2 py-1 rounded"></span>
                        <span id="detail-date" class="text-xs text-slate-400 font-medium"></span>
                    </div>
                    <span id="detail-status" class="px-3 py-1 rounded-full text-xs font-bold text-white shadow-sm"></span>
                </div>
                
                <h1 id="detail-title" class="text-3xl md:text-4xl font-bold text-white mb-2 leading-tight"></h1>
                <p id="detail-price" class="text-3xl font-extrabold text-brand mb-6"></p>

                <div class="mb-6">
                    <h3 class="text-lg font-bold border-b border-slate-700 pb-2 mb-3 text-slate-200">Specifications</h3>
                    <p id="detail-specs" class="text-slate-300 leading-relaxed text-sm mb-4"></p>
                    
                    <h3 class="text-md font-bold text-slate-200 mb-2">Description / Notes</h3>
                    <p id="detail-description" class="text-slate-400 leading-relaxed text-sm italic bg-slate-900 p-3 rounded border border-slate-700"></p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-slate-900 p-4 rounded-lg border border-slate-700">
                        <span class="block text-xs text-slate-400 uppercase tracking-wide font-bold mb-1">Condition</span>
                        <span id="detail-condition" class="font-bold text-white text-lg"></span>
                    </div>
                    <div class="bg-slate-900 p-4 rounded-lg border border-slate-700">
                        <span class="block text-xs text-slate-400 uppercase tracking-wide font-bold mb-1">Brand</span>
                        <span id="detail-brand" class="font-bold text-white text-lg"></span>
                    </div>
                </div>

                <div class="mt-auto bg-slate-900 border border-slate-700 rounded-xl p-5 flex flex-col space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-400 uppercase font-bold tracking-wide mb-1">Listed by</p>
                            <p class="font-bold text-white text-lg flex items-center">
                                <i class="fas fa-user-circle text-brand mr-2 text-2xl"></i> <span id="detail-seller"></span>
                            </p>
                            <p class="text-xs text-slate-500 mt-1">Joined 2024 &bull; 100% Positive Feedback</p>
                            <p id="detail-location" class="text-sm text-slate-400 mt-2 flex items-center font-medium">
                                <i class="fas fa-map-marker-alt text-red-500 mr-2"></i> <span></span>
                            </p>
                        </div>
                        <button id="chat-seller-btn" class="bg-brand text-white px-6 py-3 rounded-lg font-bold hover:bg-brandDark transition shadow-md flex items-center">
                            <i class="fas fa-comment-dots mr-2"></i> Chat
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- related listings -->
        <section id="similar-listings-section" class="mt-12 hidden">
            <div id="similar-group" class="mb-12">
                <div class="flex justify-between items-end mb-6 pb-3 border-b border-slate-800">
                    <div>
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <i class="fas fa-tags text-brand mr-2 text-xl"></i> Similar Listings
                        </h2>
                        <p class="text-sm text-slate-400 mt-1">More products in <span id="similar-category-name" class="text-brand font-semibold"></span></p>
                    </div>
                    <a href="products.php" class="text-brand hover:underline font-semibold text-sm">View More <i class="fas fa-arrow-right text-xs"></i></a>
                </div>
                <div id="similar-listings-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"></div>
            </div>

            <div id="other-group">
                <div class="flex justify-between items-end mb-6 pb-3 border-b border-slate-800">
                    <div>
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <i class="fas fa-fire text-brand mr-2 text-xl"></i> Other Listings You May Like
                        </h2>
                        <p class="text-sm text-slate-400 mt-1">Popular hardware and components across the marketplace</p>
                    </div>
                    <a href="products.php" class="text-brand hover:underline font-semibold text-sm">Browse All <i class="fas fa-arrow-right text-xs"></i></a>
                </div>
                <div id="other-listings-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"></div>
            </div>
        </section>
        
        <!-- error state -->
        <div id="details-error" class="text-center py-20 hidden">
            <h2 class="text-2xl font-bold text-slate-400">Listing not found.</h2>
            <p class="text-slate-500 mt-2">The item may have been removed or the ID is invalid.</p>
            <a href="products.php" class="inline-block mt-4 bg-brand text-white px-6 py-2 rounded font-bold hover:bg-brandDark">Browse Market</a>
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
