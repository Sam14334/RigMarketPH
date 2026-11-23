$(document).ready(async function() {
    const urlParamsGlobal = new URLSearchParams(window.location.search);
    if (urlParamsGlobal.get('login') === 'success') {
        $('body').prepend('<div id="login-notification" class="bg-green-500 text-white text-center py-2 font-bold shadow-md relative z-[60]">Successfully signed in! <button onclick="$(\'#login-notification\').slideUp()" class="absolute right-4 top-2 text-white hover:text-gray-200"><i class="fas fa-times"></i></button></div>');
        setTimeout(() => $('#login-notification').slideUp(), 3000);
    }
    
    // mobile menu & auth tabs
    $('#mobile-menu-btn').click(function() { $('#mobile-menu').slideToggle('fast'); });
    $('#filter-toggle-btn').click(function() { $('#sidebar-filters').slideToggle('fast'); });

    $('#tab-register').click(function() {
        $('#login-form').hide(); $('#register-form').fadeIn();
        $(this).addClass('text-brand border-b-2 border-brand bg-slate-800').removeClass('text-slate-400 hover:text-brand');
        $('#tab-login').removeClass('text-brand border-b-2 border-brand bg-slate-800').addClass('text-slate-400 hover:text-brand');
    });

    $('#tab-login').click(function() {
        $('#register-form').hide(); $('#login-form').fadeIn();
        $(this).addClass('text-brand border-b-2 border-brand bg-slate-800').removeClass('text-slate-400 hover:text-brand');
        $('#tab-register').removeClass('text-brand border-b-2 border-brand bg-slate-800').addClass('text-slate-400 hover:text-brand'); 
    });

    // default seed data
    const initialUsers = [
        {
            "email": "test@example.com",
            "password": "password123",
            "name": "Test User"
        },
        {
            "email": "admin@rigmarket.ph",
            "password": "admin",
            "name": "Admin"
        }
    ];
const initialProducts = [        { "id": 1, "title": "1TB NVMe M.2 SSD", "price": 3500, "category": "Peripherals", "condition": "Brand New", "brand": "Other", "location": "Metro Manila", "image": "images/1tb ssd m.2.jpg", "specs": "1TB Capacity, PCIe Gen 3.0 x4, up to 3500 MB/s read, M.2 2280 Form Factor", "description": "Fast and reliable 1TB M.2 SSD for gaming or productivity. Perfect for an OS drive.", "status": "Available", "sellerName": "Tech store PH", "datePosted": "Oct 23, 2024" },        { "id": 2, "title": "Acer Nitro V 16", "price": 45000, "category": "Laptops", "condition": "Brand New", "brand": "Acer", "location": "Quezon City", "image": "images/Acer-nitro-v-16-3.jpg", "specs": "AMD Ryzen 7 7840HS, NVIDIA RTX 4050, 16GB DDR5, 512GB SSD, 16-inch 165Hz", "description": "Latest Acer Nitro V 16. Powerful processor and GPU combo for AAA gaming.", "status": "Available", "sellerName": "PC Hub Reseller", "datePosted": "Oct 23, 2024" },        { "id": 3, "title": "Gigabyte Gaming A16 Laptop", "price": 52000, "category": "Laptops", "condition": "Like New", "brand": "Gigabyte", "location": "Makati City", "image": "images/GIGABYTE GAMING A16.jpg", "specs": "AMD Ryzen 7 7735HS, Radeon RX 7600S, 16GB RAM, 1TB SSD, 16\" 165Hz Display", "description": "All AMD advantage gaming laptop. Excellent thermals and performance.", "status": "Available", "sellerName": "Alex T.", "datePosted": "Oct 22, 2024" },        { "id": 4, "title": "Acer Nitro V 15", "price": 41000, "category": "Laptops", "condition": "Slightly Used", "brand": "Acer", "location": "Pasig City", "image": "images/acer nitro v15.jpg", "specs": "Intel Core i5-13420H, RTX 4050 6GB, 8GB DDR5, 512GB Gen4 SSD, 144Hz 15.6\"", "description": "Lightly used for office work and light gaming. Upgrading to a desktop soon.", "status": "Available", "sellerName": "Mark S.", "datePosted": "Oct 21, 2024" },        { "id": 5, "title": "AORUS FO32U2P OLED Gaming Monitor", "price": 65000, "category": "Monitors", "condition": "Brand New", "brand": "Gigabyte", "location": "Taguig", "image": "images/aorus fo32u2p gaming monitor.jpg", "specs": "32-inch 4K UHD (3840x2160), QD-OLED, 240Hz, 0.03ms, DisplayPort 2.1", "description": "The ultimate 4K OLED gaming experience. Brand new sealed with full warranty.", "status": "Available", "sellerName": "Gamer123", "datePosted": "Oct 20, 2024" },        { "id": 6, "title": "ASUS Prime B450M-K II Motherboard", "price": 2500, "category": "Processors", "condition": "Slightly Used", "brand": "Asus", "location": "Bi\u00f1an, Laguna", "image": "images/asus_prime_b450m-k_ii_csm_motherboard.jpg", "specs": "AMD AM4 Socket, Micro-ATX, PCIe 3.0, M.2 slot, DDR4 support", "description": "Budget motherboard. Fully working, just replaced with a B550.", "status": "Available", "sellerName": "John Doe", "datePosted": "Oct 19, 2024" },        { "id": 7, "title": "Attack Shark R2 Mouse", "price": 1800, "category": "Peripherals", "condition": "Brand New", "brand": "Other", "location": "Manila", "image": "images/attack shark r2 mouse.jpg", "specs": "Magnesium Alloy, Lightweight 40g, PAW3395 Sensor, 4K/8K Hz Polling Rate", "description": "Premium ultra-lightweight gaming mouse. Opened only for testing.", "status": "Available", "sellerName": "Jane Smith", "datePosted": "Oct 18, 2024" },        { "id": 8, "title": "Attack Shark R5 Mouse", "price": 1500, "category": "Peripherals", "condition": "Brand New", "brand": "Other", "location": "Cavite", "image": "images/attack shark r5 mouse.jpg", "specs": "Ultra-lightweight wireless, PAW3395 sensor, ergonomic shape", "description": "Great budget wireless mouse. Sealed box.", "status": "Sold", "sellerName": "Admin User", "datePosted": "Oct 17, 2024" },        { "id": 9, "title": "Crucial DDR5 Pro RAM 32GB (2x16GB)", "price": 6000, "category": "Peripherals", "condition": "Brand New", "brand": "Other", "location": "Muntinlupa", "image": "images/crucial ddr5 pro ram.jpg", "specs": "32GB (2x16GB) DDR5-5600, Low Profile Heatsink, Intel XMP 3.0 & AMD EXPO", "description": "Fast and reliable DDR5 memory kit. Unused.", "status": "Available", "sellerName": "Dave M.", "datePosted": "Oct 16, 2024" },        { "id": 10, "title": "Kingston 8GB DDR4 RAM", "price": 800, "category": "Peripherals", "condition": "Slightly Used", "brand": "Other", "location": "Metro Manila", "image": "images/ddr4 ram.jpg", "specs": "8GB DDR4 2666MHz, CL19, Non-ECC Unbuffered", "description": "Basic DDR4 stick. Good for office PCs or budget builds.", "status": "Available", "sellerName": "Kael", "datePosted": "Oct 15, 2024" },        { "id": 11, "title": "Nvidia GTX 1050 Ti 4GB", "price": 3500, "category": "Graphics Cards (GPU)", "condition": "Slightly Used", "brand": "NVIDIA", "location": "Quezon City", "image": "images/gtx 1050ti.jpg", "specs": "4GB GDDR5, 128-bit, PCIe 3.0, No external power needed", "description": "Classic budget GPU. Still runs eSports titles smoothly.", "status": "Available", "sellerName": "Nina", "datePosted": "Oct 14, 2024" },        { "id": 12, "title": "Koorui 34E6UC Ultrawide Monitor", "price": 12000, "category": "Monitors", "condition": "Like New", "brand": "Other", "location": "Makati City", "image": "images/koorui-34e6uc-gaming-monitor-review-ultrawide-at-180hz-on-budget_full.jpg", "specs": "34-inch VA Panel, 3440x1440p (WQHD), 165Hz (180Hz OC), 1500R Curved", "description": "Budget ultrawide king. No dead pixels.", "status": "Available", "sellerName": "PC Hub Reseller", "datePosted": "Oct 13, 2024" },        { "id": 13, "title": "Lenovo Legion 5 15\"", "price": 55000, "category": "Laptops", "condition": "Slightly Used", "brand": "Lenovo", "location": "Bi\u00f1an, Laguna", "image": "images/lenovo_legion_5_15_.jpg", "specs": "Ryzen 7 5800H, RTX 3060 130W, 16GB RAM, 1TB SSD, 165Hz FHD IPS", "description": "Legendary Legion 5. Thermals are fantastic. Minor scratches on chassis.", "status": "Pending", "sellerName": "Admin User", "datePosted": "Oct 12, 2024" },        { "id": 14, "title": "256GB M.2 SATA SSD", "price": 800, "category": "Peripherals", "condition": "Slightly Used", "brand": "Other", "location": "Manila", "image": "images/m.2ssd.jpg", "specs": "256GB Capacity, SATA III 6Gb/s, M.2 2280", "description": "Spare drive. Healthy condition in CrystalDiskInfo.", "status": "Available", "sellerName": "John Doe", "datePosted": "Oct 11, 2024" },        { "id": 15, "title": "Nvidia RTX 2060 6GB", "price": 7500, "category": "Graphics Cards (GPU)", "condition": "Slightly Used", "brand": "NVIDIA", "location": "Cavite", "image": "images/nvidia-rtx-2060.jpg", "specs": "6GB GDDR6, Ray Tracing, DLSS, 192-bit", "description": "Upgraded to 40-series. This card still holds up well at 1080p.", "status": "Available", "sellerName": "Jane Smith", "datePosted": "Oct 10, 2024" },        { "id": 16, "title": "Patriot Viper Steel 8GB DDR4", "price": 1000, "category": "Peripherals", "condition": "Brand New", "brand": "Other", "location": "San Pedro", "image": "images/patriot viper steel ram 8gb.jpg", "specs": "8GB DDR4 3200MHz CL16, Aluminum Heatshield", "description": "Brand new unopened RAM module.", "status": "Available", "sellerName": "Alex T.", "datePosted": "Oct 09, 2024" },        { "id": 17, "title": "AMD Ryzen 3 3200G APU", "price": 2800, "category": "Processors", "condition": "Slightly Used", "brand": "AMD", "location": "Pasig City", "image": "images/r3 3200g.jpg", "specs": "4 Cores, 4 Threads, 3.6 GHz Base Clock, Vega 8 Graphics", "description": "Perfect for a budget office PC or light gaming without a GPU.", "status": "Available", "sellerName": "Gamer123", "datePosted": "Oct 08, 2024" },        { "id": 18, "title": "AMD Ryzen 5 5600G APU", "price": 6000, "category": "Processors", "condition": "Like New", "brand": "AMD", "location": "Quezon City", "image": "images/r5 5600g.jpg", "specs": "6 Cores, 12 Threads, up to 4.4 GHz, Radeon Graphics", "description": "Used for a month before buying a dedicated GPU. Comes with stock cooler.", "status": "Available", "sellerName": "Mark S.", "datePosted": "Oct 07, 2024" },        { "id": 19, "title": "RAKK Mag-an Wireless Mouse", "price": 900, "category": "Peripherals", "condition": "Brand New", "brand": "Other", "location": "Taguig", "image": "images/rakk mag-an wireless mouse.jpg", "specs": "Pixart 3325 Sensor, 2.4GHz Wireless, RGB, Ergonomic", "description": "Local brand budget wireless mouse. Surprising quality.", "status": "Available", "sellerName": "Tech store PH", "datePosted": "Oct 06, 2024" },        { "id": 20, "title": "Royal Kludge RK L75", "price": 2200, "category": "Peripherals", "condition": "Brand New", "brand": "Other", "location": "Makati City", "image": "images/royal kludge l75 mechanical keyboard.jpg", "specs": "75% Layout, Low Profile Mechanical Switches, RGB, Hot-swappable", "description": "Sleek low profile keyboard for productivity and gaming.", "status": "Available", "sellerName": "Dave M.", "datePosted": "Oct 05, 2024" },        { "id": 21, "title": "Royal Kludge RK N80", "price": 2500, "category": "Peripherals", "condition": "Like New", "brand": "Other", "location": "Metro Manila", "image": "images/royal kludge n80 wireless mechanical keyboard.jpg", "specs": "75% Layout (80 keys), Rotary Knob, Tri-mode Wireless, Hot-swappable", "description": "Barely used. Replaced keycaps once, comes with original ones.", "status": "Available", "sellerName": "Nina", "datePosted": "Oct 04, 2024" },        { "id": 22, "title": "Royal Kludge S98", "price": 3200, "category": "Peripherals", "condition": "Brand New", "brand": "Other", "location": "Muntinlupa", "image": "images/royal kludge s98 wirelss mechanical keyboard.jpg", "specs": "96% Layout, Smart Display Screen, Tri-mode Wireless, Gasket Mount", "description": "Premium RK keyboard with a customizable smart screen.", "status": "Available", "sellerName": "Kael", "datePosted": "Oct 03, 2024" },        { "id": 23, "title": "Nvidia RTX 2060 Super 8GB", "price": 9500, "category": "Graphics Cards (GPU)", "condition": "Slightly Used", "brand": "NVIDIA", "location": "Bi\u00f1an, Laguna", "image": "images/rtx 2060 super.jpg", "specs": "8GB GDDR6, 256-bit, CUDA Cores: 2176, Boost Clock: 1650 MHz", "description": "Very capable 1080p and entry 1440p card. Repasted a month ago.", "status": "Sold", "sellerName": "Admin User", "datePosted": "Oct 02, 2024" },        { "id": 24, "title": "Nvidia RTX 4050 6GB (Desktop)", "price": 12000, "category": "Graphics Cards (GPU)", "condition": "Brand New", "brand": "NVIDIA", "location": "Manila", "image": "images/rtx 4050.jpg", "specs": "6GB GDDR6, DLSS 3, Frame Generation, Low Power Draw", "description": "Great for small form factor builds. DLSS 3 is amazing.", "status": "Available", "sellerName": "PC Hub Reseller", "datePosted": "Oct 01, 2024" },        { "id": 25, "title": "AMD Radeon RX 580 8GB 2048SP", "price": 3000, "category": "Graphics Cards (GPU)", "condition": "Slightly Used", "brand": "AMD", "location": "Cavite", "image": "images/rx-580-8gb-2048sp.jpg", "specs": "8GB GDDR5, 2048 Stream Processors, 256-bit", "description": "Budget king from a few years ago. Still runs eSports games perfectly.", "status": "Available", "sellerName": "John Doe", "datePosted": "Sep 30, 2024" },        { "id": 26, "title": "SATA & M.2 SSD Bundle", "price": 2000, "category": "Peripherals", "condition": "Slightly Used", "brand": "Other", "location": "San Pedro", "image": "images/sata & m.2 ssd bundle.jpg", "specs": "500GB SATA SSD + 256GB M.2 SATA SSD", "description": "Selling as bundle. Both are 100% healthy.", "status": "Available", "sellerName": "Jane Smith", "datePosted": "Sep 29, 2024" },        { "id": 27, "title": "VXE R1 Pro Wireless Mouse", "price": 2100, "category": "Peripherals", "condition": "Brand New", "brand": "Other", "location": "Pasig City", "image": "images/vxe_r1pro mouse.jpg", "specs": "PAW3395 Sensor, 48g Ultra-lightweight, Nordic MCU, 4K Compatible", "description": "One of the best budget mice of the year. Sealed box.", "status": "Available", "sellerName": "Gamer123", "datePosted": "Sep 28, 2024" },        { "id": 28, "title": "Wooting 60HE Keyboard", "price": 10500, "category": "Peripherals", "condition": "Like New", "brand": "Other", "location": "Quezon City", "image": "images/wooting 60he mechanical keyboard.jpg", "specs": "60% Layout, Lekker Linear Switches (Analog/Hall Effect), Rapid Trigger", "description": "The ultimate gaming keyboard. Only selling because I need a TKL.", "status": "Available", "sellerName": "Alex T.", "datePosted": "Sep 27, 2024" },        { "id": 29, "title": "XPG Lancer Blade RGB 32GB DDR5", "price": 6800, "category": "Peripherals", "condition": "Brand New", "brand": "Other", "location": "Makati City", "image": "images/xpg lancer blade rgb ddr5 6000 32 gp ram.jpg", "specs": "32GB (2x16GB) DDR5-6000MHz, CL30, Low Profile RGB, AMD EXPO", "description": "Sweet spot speed and latency for Ryzen 7000 series.", "status": "Available", "sellerName": "Mark S.", "datePosted": "Sep 26, 2024" }    ];

    // initialize local storage data
    async function initializeData() {
        let storedUsers = JSON.parse(localStorage.getItem('users'));
        let storedProducts = JSON.parse(localStorage.getItem('products'));
        let isSeeded = localStorage.getItem('seeded_v10');

        if (!isSeeded) {
            localStorage.setItem('users', JSON.stringify(initialUsers));
            localStorage.setItem('products', JSON.stringify(initialProducts));
            localStorage.setItem('seeded_v10', 'true');
        } else {
            if (!storedUsers || storedUsers.length === 0) localStorage.setItem('users', JSON.stringify(initialUsers));
            if (!storedProducts || storedProducts.length === 0) localStorage.setItem('products', JSON.stringify(initialProducts));
        }

        // hotfix: update image paths in localStorage without wiping data
        if (!localStorage.getItem('hotfix_images_path')) {
            let currentProducts = JSON.parse(localStorage.getItem('products'));
            if (currentProducts) {
                currentProducts.forEach(p => {
                    if (p.image && p.image.startsWith('../images/')) {
                        p.image = p.image.replace('../images/', 'images/');
                    }
                });
                localStorage.setItem('products', JSON.stringify(currentProducts));
            }
            localStorage.setItem('hotfix_images_path', 'true');
        }
    }

    await initializeData();
    let products = JSON.parse(localStorage.getItem('products')) || initialProducts;
    let users = JSON.parse(localStorage.getItem('users')) || initialUsers;
    let currentUser = JSON.parse(localStorage.getItem('currentUser'));

    // update navbar if logged in
    if (currentUser) {
        let authButtons = `<div class="flex items-center space-x-4">
            <a href="listing.php" class="bg-brand text-white px-4 py-2 rounded font-semibold hover:bg-brandDark transition mr-2"><i class="fas fa-plus-circle mr-1"></i> Make a Listing</a>
            <span class="text-slate-300 font-semibold"><i class="fas fa-user-circle text-brand mr-1"></i> ${currentUser.name}</span>
            <button id="logout-btn" class="text-slate-400 hover:text-red-600 px-3 py-2 font-medium transition">Logout</button>
        </div>`;
        $('.hidden.md\\:flex a[href="login.php"]').replaceWith(authButtons);
        $('#mobile-menu a[href="login.php"]').replaceWith(`<a href="listing.php" class="block py-1 text-blue-400 font-semibold mb-2"><i class="fas fa-plus-circle mr-1"></i> Make a Listing</a><button id="mobile-logout-btn" class="block py-1 text-red-600 w-full text-left font-semibold"><i class="fas fa-sign-out-alt mr-1"></i> Logout</button>`);
    }

    $(document).on('click', '#logout-btn, #mobile-logout-btn', function() {
        localStorage.removeItem('currentUser');
        window.location.reload();
    });



    // listing card template
    function generateProductCard(product) {
        let condBadgeClass = "bg-slate-700 text-slate-300";
        if (product.condition === "Brand New") condBadgeClass = "bg-green-100 text-green-700 border-green-200 border";
        if (product.condition === "Like New") condBadgeClass = "bg-blue-100 text-blue-700 border-blue-200 border";

        let statusBadge = "";
        if (product.status === "Sold") {
            statusBadge = `<div class="absolute inset-0 bg-slate-800/70 flex items-center justify-center z-10">
                              <span class="bg-red-600 text-white font-black uppercase text-xl px-4 py-2 rounded-lg transform -rotate-12 shadow-lg tracking-widest border-2 border-red-700">SOLD</span>
                           </div>`;
        } else if (product.status === "Pending") {
            statusBadge = `<div class="absolute top-2 left-2 bg-yellow-500 text-white text-xs px-2 py-1 rounded shadow font-bold z-10 uppercase tracking-wide">Pending</div>`;
        }

        return `
            <a href="details.php?id=${product.id}" class="bg-slate-800 border border-slate-700 rounded-lg overflow-hidden hover:shadow-xl hover:border-brand hover:-translate-y-1 transition-all duration-200 flex flex-col relative group cursor-pointer block">
                ${statusBadge}
                <div class="relative overflow-hidden">
                    <img src="${product.image}" alt="${product.title}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    <span class="absolute top-2 right-2 bg-slate-900 text-white text-xs px-2 py-1 rounded shadow">${product.category}</span>
                </div>
                <div class="p-4 flex-grow flex flex-col">
                    <h3 class="font-bold text-white mb-1 truncate text-lg group-hover:text-brand transition-colors" title="${product.title}">${product.title}</h3>
                    <p class="text-xs text-slate-400 mb-3 italic h-8 overflow-hidden line-clamp-2" title="${product.specs}">${product.specs}</p>
                    <p class="text-white font-bold text-xl mb-4">&#8369; ${parseInt(product.price).toLocaleString()}</p>
                    <div class="flex justify-between items-center text-xs text-slate-400 mt-auto pt-3 border-t border-slate-700">
                        <span class="${condBadgeClass} px-2 py-1 rounded font-medium">${product.condition}</span>
                        <span><i class="fas fa-map-marker-alt text-red-500"></i> ${product.location}</span>
                    </div>
                </div>
            </a>`;
    }

    // fresh listings on homepage
    if ($('#recent-listings-grid').length) {
        let currentCategory = 'All';
        let searchQuery = '';
        let searchLocation = '';

        let renderRecentListings = function() {
            let filtered = products;

            if (currentCategory !== 'All') {
                filtered = filtered.filter(p => p.category === currentCategory);
            }

            if (searchQuery) {
                filtered = filtered.filter(p => {
                    let titleMatch = p.title && p.title.toLowerCase().includes(searchQuery);
                    let specsMatch = p.specs && p.specs.toLowerCase().includes(searchQuery);
                    let descMatch = p.description && p.description.toLowerCase().includes(searchQuery);
                    let brandMatch = p.brand && p.brand.toLowerCase().includes(searchQuery);
                    let catMatch = p.category && p.category.toLowerCase().includes(searchQuery);
                    return titleMatch || specsMatch || descMatch || brandMatch || catMatch;
                });
            }

            if (searchLocation) {
                filtered = filtered.filter(p => {
                    if (!p.location) return false;
                    let normLoc = p.location.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                    return normLoc.includes(searchLocation);
                });
            }

            let recent = [...filtered].reverse().slice(0, 12);
            if (recent.length > 0) {
                $('#recent-listings-grid').html(recent.map(generateProductCard).join(''));
            } else {
                $('#recent-listings-grid').html('<div class="text-slate-400 col-span-full text-center py-12"><i class="fas fa-search text-4xl mb-3 block text-slate-500"></i><p class="text-lg font-semibold">No listings found</p><p class="text-sm text-slate-500">Try searching with different keywords or location.</p></div>');
            }
        };

        renderRecentListings();

        $('.home-category-btn').click(function() {
            $('.home-category-btn').removeClass('active-category border-brand text-brand').addClass('border-slate-600 text-slate-300');
            $(this).addClass('active-category border-brand text-brand').removeClass('border-slate-600 text-slate-300');
            
            currentCategory = $(this).attr('data-category');
            renderRecentListings();
        });

        // custom animated location dropdown
        const $customLocBtn = $('#custom-location-btn');
        const $customLocMenu = $('#custom-location-menu');
        const $customLocArrow = $('#custom-location-arrow');
        const $customLocLabel = $('#custom-location-selected-text');
        const $nativeLocSelect = $('#home-location-select');

        function openLocationDropdown() {
            $customLocMenu.removeClass('opacity-0 invisible -translate-y-2 pointer-events-none')
                          .addClass('opacity-100 visible translate-y-0 pointer-events-auto');
            $customLocArrow.addClass('rotate-180 text-brand').removeClass('text-slate-400');
        }

        function closeLocationDropdown() {
            $customLocMenu.addClass('opacity-0 invisible -translate-y-2 pointer-events-none')
                          .removeClass('opacity-100 visible translate-y-0 pointer-events-auto');
            $customLocArrow.removeClass('rotate-180 text-brand').addClass('text-slate-400');
        }

        $customLocBtn.on('click', function(e) {
            e.stopPropagation();
            if ($customLocMenu.hasClass('opacity-100')) {
                closeLocationDropdown();
            } else {
                openLocationDropdown();
            }
        });

        $('.custom-location-option').on('click', function(e) {
            e.stopPropagation();
            const val = $(this).attr('data-value') || '';
            const text = $(this).attr('data-text') || $(this).find('span').text();

            $customLocLabel.text(text);
            $nativeLocSelect.val(val).trigger('change');

            $('.custom-location-option').removeClass('bg-slate-700/50 text-white font-medium').addClass('text-slate-300');
            $('.custom-location-option .check-icon').addClass('hidden');

            $(this).addClass('bg-slate-700/50 text-white font-medium').removeClass('text-slate-300');
            $(this).find('.check-icon').removeClass('hidden');

            closeLocationDropdown();
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#custom-location-wrapper').length) {
                closeLocationDropdown();
            }
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLocationDropdown();
            }
        });

        $('#search-form').submit(function(e) {
            e.preventDefault();
            searchQuery = ($('#home-search-input').val() || '').trim().toLowerCase();
            searchLocation = ($('#home-location-select').val() || '').trim().toLowerCase();

            // reset category to all
            currentCategory = 'All';
            $('.home-category-btn').removeClass('active-category border-brand text-brand').addClass('border-slate-600 text-slate-300');
            $('.home-category-btn[data-category="All"]').addClass('active-category border-brand text-brand').removeClass('border-slate-600 text-slate-300');

            // update title
            if (searchQuery || searchLocation) {
                let tags = [];
                if (searchQuery) tags.push(`"${$('#home-search-input').val().trim()}"`);
                if (searchLocation) tags.push(`Location: ${$('#home-location-select option:selected').text()}`);
                $('#fresh-listings-title').text(`Search Results for ${tags.join(', ')}`);
            } else {
                $('#fresh-listings-title').text('Fresh Listings');
            }

            renderRecentListings();

            // scroll to results
            $('html, body').animate({ scrollTop: $('#recent-listings-grid').offset().top - 120 }, 250);
        });
    }

    // browse market filters and pagination
    if ($('#products-grid').length) {
        let currentPage = 1;
        const itemsPerPage = 12;
        let filteredData = [];

        // pre-fill search if in url
        const urlParamsMarket = new URLSearchParams(window.location.search);
        if (urlParamsMarket.get('search')) {
            $('#market-search-input').val(urlParamsMarket.get('search'));
        }

        function renderFilteredProducts() {
            let selectedCategories = $('.filter-category:checked').map(function(){ return $(this).val(); }).get();
            let selectedConditions = $('.filter-condition:checked').map(function(){ return $(this).val(); }).get();
            let selectedBrands = $('.filter-brand:checked').map(function(){ return $(this).val(); }).get();
            let minPrice = parseInt($('#min-price').val()) || 0;
            let maxPrice = parseInt($('#max-price').val()) || 9999999;

            let searchQuery = ($('#market-search-input').val() || '').trim().toLowerCase();
            let searchLocation = ($('#market-location-select').val() || '').trim().toLowerCase();

            filteredData = products.filter(p => {
                let catMatch = selectedCategories.length === 0 || selectedCategories.includes(p.category);
                let condMatch = selectedConditions.length === 0 || selectedConditions.includes(p.condition);
                let brandMatch = selectedBrands.length === 0 || selectedBrands.includes(p.brand);
                let priceMatch = p.price >= minPrice && p.price <= maxPrice;

                let searchMatch = true;
                if (searchQuery) {
                    let titleMatch = p.title && p.title.toLowerCase().includes(searchQuery);
                    let specsMatch = p.specs && p.specs.toLowerCase().includes(searchQuery);
                    let descMatch = p.description && p.description.toLowerCase().includes(searchQuery);
                    let brandMatchText = p.brand && p.brand.toLowerCase().includes(searchQuery);
                    let catMatchText = p.category && p.category.toLowerCase().includes(searchQuery);
                    searchMatch = titleMatch || specsMatch || descMatch || brandMatchText || catMatchText;
                }

                let locationMatch = true;
                if (searchLocation) {
                    if (!p.location) {
                        locationMatch = false;
                    } else {
                        let normLoc = p.location.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                        locationMatch = normLoc.includes(searchLocation);
                    }
                }

                return catMatch && condMatch && brandMatch && priceMatch && searchMatch && locationMatch;
            });

            let sortType = $('#sort-select').val();
            if (sortType === 'price-asc') {
                filteredData.sort((a, b) => a.price - b.price);
            } else if (sortType === 'price-desc') {
                filteredData.sort((a, b) => b.price - a.price);
            } else {
                filteredData.sort((a, b) => b.id - a.id);
            }

            const totalPages = Math.ceil(filteredData.length / itemsPerPage) || 1;
            if (currentPage > totalPages) currentPage = totalPages;

            let startIndex = (currentPage - 1) * itemsPerPage;
            let paginatedItems = filteredData.slice(startIndex, startIndex + itemsPerPage);

            if (paginatedItems.length > 0) {
                $('#products-grid').html(paginatedItems.map(generateProductCard).join(''));
            } else {
                $('#products-grid').html('<div class="text-slate-400 col-span-full text-center py-16"><i class="fas fa-search text-5xl mb-4 block text-slate-500"></i><p class="text-xl font-bold text-slate-300">No products match your criteria</p><p class="text-sm text-slate-500 mt-1">Try clearing or adjusting your search keywords, location, or sidebar filters.</p></div>');
            }

            let resultTitle = `All Results (${filteredData.length} items)`;
            if (searchQuery || searchLocation) {
                let tags = [];
                if (searchQuery) tags.push(`"${searchQuery}"`);
                if (searchLocation) tags.push(`Location: ${$('#market-location-select option:selected').text()}`);
                resultTitle = `Search Results for ${tags.join(', ')} (${filteredData.length} found)`;
            }
            $('h1:contains("All Results"), h1:contains("Search Results")').text(resultTitle);

            renderPaginationControls(totalPages);
        }

        function renderPaginationControls(totalPages) {
            let paginationHtml = '';
            
            if (currentPage > 1) {
                paginationHtml += `<button class="pagination-btn px-4 py-2 border rounded text-slate-300 bg-slate-800 hover:bg-slate-700" data-page="${currentPage - 1}">&laquo; Prev</button>`;
            } else {
                paginationHtml += `<button class="px-4 py-2 border rounded text-gray-400 bg-slate-800 cursor-not-allowed" disabled>&laquo; Prev</button>`;
            }

            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    paginationHtml += `<button class="px-4 py-2 border border-brand rounded bg-brand text-white font-bold">${i}</button>`;
                } else {
                    paginationHtml += `<button class="pagination-btn px-4 py-2 border rounded text-slate-300 bg-slate-800 hover:bg-slate-700" data-page="${i}">${i}</button>`;
                }
            }

            if (currentPage < totalPages) {
                paginationHtml += `<button class="pagination-btn px-4 py-2 border rounded text-slate-300 bg-slate-800 hover:bg-slate-700" data-page="${currentPage + 1}">Next &raquo;</button>`;
            } else {
                paginationHtml += `<button class="px-4 py-2 border rounded text-gray-400 bg-slate-800 cursor-not-allowed" disabled>Next &raquo;</button>`;
            }

            $('#pagination-controls').html(paginationHtml);
        }

        $(document).on('click', '.pagination-btn', function() {
            currentPage = parseInt($(this).attr('data-page'));
            renderFilteredProducts();
            $('html, body').animate({ scrollTop: $("#products-grid").offset().top - 100 }, 200);
        });

        renderFilteredProducts();
        $('.filter-category, .filter-condition, .filter-brand, #min-price, #max-price, #sort-select, #market-search-input, #market-location-select').on('change input', function() {
            currentPage = 1;
            renderFilteredProducts();
        });

        $('#market-search-form').submit(function(e) {
            e.preventDefault();
            currentPage = 1;
            renderFilteredProducts();
        });
    }

    // product details page
    if ($('#details-container').length) {
        const urlParams = new URLSearchParams(window.location.search);
        const productId = parseInt(urlParams.get('id'));
        const product = products.find(p => p.id === productId);

        if (product) {
            $('#details-container').removeClass('hidden');
            $('#detail-title').text(product.title);
            $('#detail-price').html('&#8369; ' + parseInt(product.price).toLocaleString());
            $('#detail-image').attr('src', product.image).attr('alt', product.title);
            $('#detail-category').text(product.category);
            $('#detail-specs').text(product.specs);
            $('#detail-description').text(product.description || "No additional details provided.");
            $('#detail-date').text("Posted on: " + (product.datePosted || "Unknown date"));
            $('#detail-condition').text(product.condition);
            $('#detail-brand').text(product.brand);
            $('#detail-seller').text(product.sellerName || "Anonymous User");
            $('#detail-location span').text(product.location);

            let statusEl = $('#detail-status');
            statusEl.text(product.status || "Available");
            if (product.status === "Available") statusEl.addClass("bg-green-500");
            else if (product.status === "Pending") statusEl.addClass("bg-yellow-500");
            else if (product.status === "Sold") statusEl.addClass("bg-red-600");
            else statusEl.addClass("bg-slate-800 text-white");
            
            if ($('#similar-listings-section').length) {
                let similar = products.filter(p => p.category === product.category && p.id !== product.id);
                let other = products.filter(p => p.category !== product.category && p.id !== product.id);

                $('#similar-category-name').text(product.category);

                if (similar.length > 0) {
                    $('#similar-listings-grid').html(similar.slice(0, 4).map(generateProductCard).join(''));
                    $('#similar-group').removeClass('hidden');
                } else {
                    $('#similar-group').addClass('hidden');
                }

                if (other.length > 0) {
                    $('#other-listings-grid').html(other.slice(0, 4).map(generateProductCard).join(''));
                    $('#other-group').removeClass('hidden');
                } else {
                    $('#other-group').addClass('hidden');
                }

                if (similar.length > 0 || other.length > 0) {
                    $('#similar-listings-section').removeClass('hidden');
                }
            }

            $(document).on('click', '#chat-seller-btn', function() {
                if (!currentUser) {
                    alert("You must be logged in to chat with a seller!");
                    window.location.href = "login.php";
                    return;
                }
                window.location.href = `chat.php?id=${product.id}`;
            });
        } else {
            $('#details-error').removeClass('hidden');
        }
    }

    // form submissions (login, register, add listing, contact)
    // $('#login-form').submit(function(e) {
    //     e.preventDefault();
    //     let email = $('#login-email').val().trim();
    //     let password = $('#login-password').val().trim();
    //     
    //     let user = users.find(u => u.email.toLowerCase() === email.toLowerCase() && u.password === password);
    //     if (user) {
    //         localStorage.setItem('currentUser', JSON.stringify(user));
    //         window.location.href = "index.php?login=success";
    //     } else {
    //         alert("Invalid email or password! Tip: Use admin@rigmarket.ph with password 'admin'");
    //     }
    // });

    // $('#register-form').submit(function(e) {
    //     e.preventDefault();
    //     let name = $('#reg-name').val().trim();
    //     let email = $('#reg-email').val().trim();
    //     let password = $('#reg-password').val().trim();
    //     
    //     let existingUser = users.find(u => u.email.toLowerCase() === email.toLowerCase());
    //     if (existingUser) {
    //         alert("An account with that email already exists. Please log in.");
    //         return;
    //     }
    //     let newUser = { email, password, name };
    //     users.push(newUser);
    //     localStorage.setItem('users', JSON.stringify(users));
    //     localStorage.setItem('currentUser', JSON.stringify(newUser));
    //     window.location.href = "index.php?login=success";
    // });

    $('#listing-form').submit(function(e) {
        e.preventDefault();
        if (!currentUser) {
            alert("You must be logged in to post a listing!");
            window.location.href = "login.php";
            return;
        }
        let customImg = $('#post-image').val().trim();
        let newProduct = {
            id: products.length + 1,
            title: $('#post-title').val().trim(),
            price: parseInt($('#post-price').val()),
            category: $('#post-category').val(),
            condition: $('#post-condition').val(),
            location: $('#post-location').val().trim(),
            specs: $('#post-specs').val().trim(),
            description: "No additional description provided.",
            brand: "Other", 
            image: customImg || "https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=400&h=300",
            status: "Available",
            sellerName: currentUser.name,
            datePosted: new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
        };
        products.push(newProduct);
        localStorage.setItem('products', JSON.stringify(products));
        
        alert("Listing successfully posted!");
        $(this)[0].reset();
        window.location.href = "products.php";
    });

    // $('#contact-form').submit(function(e) {
    //     e.preventDefault();
    //     alert("Thank you! Your message has been sent to our support team.");
    //     $(this)[0].reset();
    // });
});





