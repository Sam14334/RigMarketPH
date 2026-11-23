<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RigMarket PH - Chat</title>
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
                <a href="login.php" class="bg-brand hover:bg-brandDark text-white px-5 py-2 rounded font-semibold transition shadow-sm">
                    <i class="fas fa-user mr-1"></i> Login / Register
                </a>
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

    <main class="container mx-auto px-4 py-8 flex-grow flex flex-col md:flex-row gap-6 max-w-6xl">
        <!-- chat list sidebar -->
        <aside class="w-full md:w-1/3 bg-slate-800 border border-slate-700 rounded-lg shadow-sm flex flex-col h-[75vh]">
            <div class="p-4 border-b border-slate-700 bg-slate-800">
                <h2 class="font-bold text-lg text-white"><i class="fas fa-inbox text-brand mr-2"></i>Messages</h2>
            </div>
            <div class="flex-grow overflow-y-auto p-2" id="chat-list"></div>
        </aside>

        <!-- active conversation -->
        <div class="w-full md:w-2/3 bg-slate-800 border border-slate-700 rounded-lg shadow-sm flex flex-col h-[75vh] hidden" id="chat-main">
            <div class="p-4 border-b border-slate-700 flex flex-col sm:flex-row items-start sm:items-center justify-between bg-slate-800">
                <div class="flex items-center space-x-3 mb-3 sm:mb-0">
                    <div class="w-10 h-10 bg-brand text-white rounded-full flex items-center justify-center font-bold text-lg">
                        <span id="chat-seller-initial">S</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-white" id="chat-seller-name">Seller Name</h3>
                        <p class="text-xs text-green-500 font-medium">Online</p>
                    </div>
                </div>
                
                <a id="chat-product-link" href="#" class="flex items-center space-x-3 bg-slate-800 border border-slate-700 p-2 rounded hover:bg-slate-700 transition max-w-sm w-full sm:w-auto">
                    <img id="chat-product-img" src="" alt="Product" class="w-12 h-12 object-cover rounded">
                    <div class="overflow-hidden">
                        <h4 class="text-sm font-bold text-white truncate" id="chat-product-title">Product Title</h4>
                        <p class="text-xs font-bold text-brand" id="chat-product-price">&#8369; 0</p>
                    </div>
                </a>
            </div>

            <!-- message history -->
            <div class="flex-grow overflow-y-auto p-6 space-y-4 bg-slate-900/60" id="chat-messages">
                <div class="flex justify-center mb-4">
                    <span class="text-xs bg-slate-800 text-slate-400 border border-slate-700 px-3 py-1 rounded-full">Today</span>
                </div>
            </div>

            <!-- message input -->
            <div class="p-4 border-t border-slate-700 bg-slate-800">
                <form id="chat-form" class="flex space-x-2">
                    <input type="text" id="chat-input" placeholder="Type a message..." required class="flex-grow bg-slate-700 text-white border border-slate-600 rounded-full px-4 py-2 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
                    <button type="submit" class="bg-brand text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-brandDark transition flex-shrink-0">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- empty state -->
        <div class="w-full md:w-2/3 bg-slate-800 border border-slate-700 rounded-lg shadow-sm flex flex-col items-center justify-center h-[75vh]" id="chat-empty">
            <div class="text-6xl text-slate-600 mb-4"><i class="far fa-comments"></i></div>
            <h2 class="text-xl font-bold text-slate-300">No Chat Selected</h2>
            <p class="text-slate-400 mt-2">Select a conversation or start a new one from a listing.</p>
        </div>
    </main>

    <!-- scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="script.js"></script>
    <script>
        $(document).ready(function() {
            let currentUser = JSON.parse(localStorage.getItem('currentUser'));
            if (!currentUser) {
                window.location.href = "login.php";
                return;
            }

            const urlParams = new URLSearchParams(window.location.search);
            const productId = parseInt(urlParams.get('id'));
            
            let products = JSON.parse(localStorage.getItem('products')) || [];
            let product = products.find(p => p.id === productId);

            if (product) {
                $('#chat-empty').addClass('hidden');
                $('#chat-main').removeClass('hidden');
                
                $('#chat-seller-name').text(product.sellerName || 'Seller');
                $('#chat-seller-initial').text((product.sellerName || 'S').charAt(0).toUpperCase());
                
                $('#chat-product-title').text(product.title);
                $('#chat-product-price').php('&#8369; ' + parseInt(product.price).toLocaleString());
                $('#chat-product-img').attr('src', product.image);
                $('#chat-product-link').attr('href', 'details.php?id=' + product.id);
                
                // initial greeting
                $('#chat-messages').append(`
                    <div class="flex justify-start">
                        <div class="bg-slate-800 border border-slate-700 text-white rounded-2xl rounded-tl-none px-4 py-2 max-w-[75%] shadow-sm">
                            <p class="text-sm">Hi ${currentUser.name.split(' ')[0]}, regarding the <strong>${product.title}</strong>, are you interested?</p>
                        </div>
                    </div>
                `);

                // active chat item
                $('#chat-list').append(`
                    <div class="p-3 bg-slate-700/80 hover:bg-slate-700 border-l-4 border-brand cursor-pointer flex items-center space-x-3 mb-1 rounded-r transition">
                        <div class="w-10 h-10 bg-brand text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">
                            ${(product.sellerName || 'S').charAt(0).toUpperCase()}
                        </div>
                        <div class="flex-grow overflow-hidden">
                            <h4 class="font-bold text-sm text-white truncate">${product.sellerName || 'Seller'}</h4>
                            <p class="text-xs text-slate-300 truncate">${product.title}</p>
                        </div>
                    </div>
                `);

            } else {
                $('#chat-list').php('<p class="text-sm text-slate-400 p-4 text-center">No active conversations.</p>');
            }

            // send message
            $('#chat-form').submit(function(e) {
                e.preventDefault();
                let msg = $('#chat-input').val().trim();
                if (msg) {
                    $('#chat-messages').append(`
                        <div class="flex justify-end mt-4">
                            <div class="bg-brand text-white rounded-2xl rounded-tr-none px-4 py-2 max-w-[75%] shadow-sm">
                                <p class="text-sm">${msg}</p>
                            </div>
                        </div>
                    `);
                    $('#chat-input').val('');
                    let chatBox = document.getElementById('chat-messages');
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
            });
        });
    </script>
</body>
</html>
