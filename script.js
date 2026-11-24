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

    // state
    let products = [];
    let currentUser = null;

    async function initializeData() {
        // 1. Fetch authenticated session from PHP backend
        try {
            const sessionRes = await fetch('api.php?action=session');
            if (sessionRes.ok) {
                const sessionData = await sessionRes.json();
                currentUser = sessionData.user || null;
            }
        } catch (e) {
            console.warn('Session check failed:', e);
        }

        // Fallback: check localStorage for cached user
        if (!currentUser) {
            try {
                currentUser = JSON.parse(localStorage.getItem('currentUser')) || null;
            } catch (e) {
                currentUser = null;
            }
        }

        // 2. Fetch live products from Supabase via api.php
        try {
            const productsRes = await fetch('api.php?action=products');
            if (productsRes.ok) {
                const productsData = await productsRes.json();
                products = productsData.data || [];
            }
        } catch (e) {
            console.error('Failed to load products from API:', e);
        }
    }

    await initializeData();

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
        const form = $('<form method="post" action="process.php" style="display:none"><input type="hidden" name="action" value="logout"></form>');
        $('body').append(form);
        form.submit();
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
        let product = products.find(p => p.id === productId);

        // if not found in loaded array, fetch directly from api.php
        if (!product && productId) {
            try {
                const res = await fetch(`api.php?action=product&id=${productId}`);
                if (res.ok) {
                    const json = await res.json();
                    product = json.data;
                }
            } catch (e) {
                console.error('Error fetching product details:', e);
            }
        }

        if (product) {
            $('#details-container').removeClass('hidden');
            $('#detail-title').text(product.title);
            $('#detail-price').html('&#8369; ' + parseInt(product.price).toLocaleString());
            $('#detail-image').attr('src', product.image).attr('alt', product.title);
            $('#detail-category').text(product.category);
            $('#detail-specs').text(product.specs);
            $('#detail-description').text(product.description || "No additional details provided.");
            $('#detail-date').text("Posted on: " + (product.date_posted || product.datePosted || "Unknown date"));
            $('#detail-condition').text(product.condition);
            $('#detail-brand').text(product.brand || "Other");
            $('#detail-seller').text(product.seller_name || product.sellerName || "Anonymous User");
            $('#detail-location span').text(product.location);

            // Thumbnail gallery support if multiple images exist
            if (product.listing_images && product.listing_images.length > 1) {
                let thumbsHtml = product.listing_images.map(img => `
                    <img src="${img.image_url}" class="w-14 h-14 object-cover rounded cursor-pointer border-2 border-slate-700 hover:border-brand transition gallery-thumb" alt="${product.title}">
                `).join('');
                if ($('#detail-gallery-strip').length === 0) {
                    $('#detail-image').after(`<div id="detail-gallery-strip" class="flex flex-wrap gap-2 p-3 w-full bg-slate-950/70 justify-center border-t border-slate-700">${thumbsHtml}</div>`);
                }
                $(document).on('click', '.gallery-thumb', function() {
                    $('.gallery-thumb').removeClass('border-brand').addClass('border-slate-700');
                    $(this).removeClass('border-slate-700').addClass('border-brand');
                    $('#detail-image').attr('src', $(this).attr('src'));
                });
            }

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

    $('#listing-form').submit(async function(e) {
        e.preventDefault();
        if (!currentUser) {
            alert("You must be logged in to post a listing!");
            window.location.href = "login.php";
            return;
        }

        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).text('Posting Listing...');

        let customImg = $('#post-image').val().trim();
        let payload = {
            title: $('#post-title').val().trim(),
            price: parseInt($('#post-price').val()),
            category: $('#post-category').val(),
            condition: $('#post-condition').val(),
            location: $('#post-location').val().trim(),
            specs: $('#post-specs').val().trim(),
            image: customImg
        };

        try {
            const res = await fetch('api.php?action=create_listing', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
            const result = await res.json();

            if (result.ok) {
                alert("Listing successfully posted!");
                window.location.href = "products.php";
            } else {
                alert(result.message || "Failed to post listing. Please try again.");
                submitBtn.prop('disabled', false).text('Post Listing');
            }
        } catch (err) {
            alert("An error occurred while posting your listing. Please try again.");
            submitBtn.prop('disabled', false).text('Post Listing');
        }
    });

    // $('#contact-form').submit(function(e) {
    //     e.preventDefault();
    //     alert("Thank you! Your message has been sent to our support team.");
    //     $(this)[0].reset();
    // });
});





