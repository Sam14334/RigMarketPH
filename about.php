<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RigMarket PH - About Us</title>
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
                <a href="about.php" class="text-brand font-semibold">About Us</a>
                <a href="contact.php" class="text-slate-300 hover:text-brand transition font-medium">Contact</a>
                <a href="login.php" class="bg-brand hover:bg-brandDark text-white px-5 py-2 rounded font-semibold transition shadow-sm"><i class="fas fa-user mr-1"></i> Login / Register</a>
            </div>
            <button id="mobile-menu-btn" class="md:hidden text-2xl focus:outline-none"><i class="fas fa-bars"></i></button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-slate-800 border-t border-slate-700 shadow-lg">
            <div class="flex flex-col px-4 py-2 space-y-3">
                <a href="index.php" class="block py-1 hover:text-brand text-slate-300">Home</a>
                <a href="products.php" class="block py-1 hover:text-brand text-slate-300">Browse Market</a>
                <a href="about.php" class="text-brand font-semibold block py-1">About Us</a>
                <a href="contact.php" class="block py-1 hover:text-brand text-slate-300">Contact</a>
                <a href="login.php" class="block py-1 text-brand font-semibold"><i class="fas fa-user mr-1"></i> Login / Register</a>
            </div>
        </div>
    </nav>

    <!-- header -->
    <header class="bg-brand text-white py-12 text-center">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold mb-2">About RigMarket PH</h1>
            <p class="text-xl text-blue-100">Built by gamers, for the community.</p>
        </div>
    </header>

    <main class="container mx-auto max-w-4xl px-4 py-12 flex-grow">
        <!-- vision -->
        <section class="bg-slate-800 rounded-lg shadow-sm border border-slate-700 p-8 mb-8">
            <div class="flex items-center mb-4">
                <i class="fas fa-eye text-3xl text-brand mr-4"></i>
                <h2 class="text-2xl font-bold text-white">Our Vision</h2>
            </div>
            <p class="text-slate-300 leading-relaxed mb-4">
                RigMarket PH was created to bridge the gap for Filipino students, hardcore gamers, and video editors who are looking for reliable, budget-friendly PC hardware. We noticed that finding good used parts on generic social media platforms can often feel sketchy and disorganized. 
            </p>
            <p class="text-slate-300 leading-relaxed">
                By providing a dedicated platform specifically for tech enthusiasts, we cut through the noise. Whether you are looking to upgrade your rig for your Tuesday deadline or sell your old ThinkPad to a student, RigMarket PH makes the peer-to-peer (P2P) classifieds experience seamless.
            </p>
        </section>

        <!-- safety guidelines -->
        <section class="bg-slate-800 rounded-lg shadow-sm border border-slate-700 p-8">
            <div class="flex items-center mb-4">
                <i class="fas fa-shield-alt text-3xl text-green-500 mr-4"></i>
                <h2 class="text-2xl font-bold text-white">Safety & Trust</h2>
            </div>
            <p class="text-slate-300 leading-relaxed mb-6">
                Because we operate as a P2P marketplace, ensuring safe transactions is our top priority. Here are our community guidelines for secure trading:
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-start">
                    <div class="bg-slate-700 p-3 rounded-full mr-4 text-brand">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white">Local Meetups</h3>
                        <p class="text-sm text-slate-300">We encourage safe public meetups at well-known locations (e.g., malls, or campuses like PUP Bi&ntilde;an) so you can inspect items thoroughly before buying.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-slate-700 p-3 rounded-full mr-4 text-brand">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white">Trusted Shipping</h3>
                        <p class="text-sm text-slate-300">For long-distance deals, rely on trusted local couriers like LBC or J&T Express. Always ask for waybills and real-time photos before sending payment.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-slate-700 p-3 rounded-full mr-4 text-brand">
                        <i class="fas fa-search"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white">Test the Parts</h3>
                        <p class="text-sm text-slate-300">For GPUs, processors, and laptops, request a benchmark video (like FurMark or Cinebench) with the seller's name written on a piece of paper in the frame.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="bg-slate-700 p-3 rounded-full mr-4 text-brand">
                        <i class="fas fa-flag"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white">Report Scammers</h3>
                        <p class="text-sm text-slate-300">If a deal feels too good to be true, it probably is. Use our contact page to report suspicious listings and protect the community.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- footer -->
    <footer class="bg-slate-900 text-slate-400 py-8 border-t border-slate-800 mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p class="text-sm">&copy; 2024 RigMarket PH. Designed for the Philippine PC Community.</p>
        </div>
    </footer>

    <!-- scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
