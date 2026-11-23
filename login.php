<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RigMarket PH - Login</title>
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

    <main class="container mx-auto px-4 py-12 flex-grow flex items-center justify-center">
        <div class="bg-slate-800 rounded-lg shadow-md border border-slate-700 w-full max-w-md overflow-hidden">
            <!-- auth tabs -->
            <div class="flex border-b border-slate-700">
                <button id="tab-login" class="w-1/2 py-4 font-bold text-brand border-b-2 border-brand bg-slate-800 focus:outline-none transition">Login</button>
                <button id="tab-register" class="w-1/2 py-4 font-bold text-slate-400 hover:text-brand bg-slate-900 focus:outline-none transition">Register</button>
            </div>

            <div class="p-8">
                <!-- login form -->
                <form id="login-form" action="process.php" method="post" class="space-y-5 block">
                    <input type="hidden" name="action" value="login">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-white">Welcome Back</h2>
                        <p class="text-sm text-slate-400">Sign in to buy and sell parts.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1">Email Address</label>
                        <input id="login-email" type="email" name="email" required placeholder="admin@rigmarket.ph" class="w-full border border-slate-600 bg-slate-700 text-white rounded p-2 focus:outline-none focus:border-brand placeholder-slate-400">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1">Password</label>
                        <input id="login-password" type="password" name="password" required placeholder="admin" class="w-full border border-slate-600 bg-slate-700 text-white rounded p-2 focus:outline-none focus:border-brand placeholder-slate-400">
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <label class="flex items-center text-slate-400"><input type="checkbox" class="mr-2 rounded text-brand border-slate-600 bg-slate-700"> Remember me</label>
                        <a href="#" class="text-brand hover:underline">Forgot password?</a>
                    </div>
                    <button type="submit" class="w-full bg-brand text-white font-bold py-3 rounded hover:bg-brandDark transition shadow-md">
                        Sign In
                    </button>
                </form>

                <!-- register form -->
                <form id="register-form" action="process.php" method="post" class="space-y-4 hidden">
                    <input type="hidden" name="action" value="register">
                    <div class="text-center mb-4">
                        <h2 class="text-2xl font-bold text-white">Create an Account</h2>
                        <p class="text-sm text-slate-400">Join the PC community today.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1">Full Name</label>
                        <input id="reg-name" type="text" name="name" required placeholder="Juan Dela Cruz" class="w-full border border-slate-600 bg-slate-700 text-white rounded p-2 focus:outline-none focus:border-brand placeholder-slate-400">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1">Email Address</label>
                        <input id="reg-email" type="email" name="email" required placeholder="you@example.com" class="w-full border border-slate-600 bg-slate-700 text-white rounded p-2 focus:outline-none focus:border-brand placeholder-slate-400">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1">Password</label>
                        <input id="reg-password" type="password" name="password" required placeholder="&bull;&bull;&bull;&bull;&bull;&bull;&bull;&bull;" class="w-full border border-slate-600 bg-slate-700 text-white rounded p-2 focus:outline-none focus:border-brand placeholder-slate-400">
                    </div>
                    <button type="submit" class="w-full bg-brand text-white font-bold py-3 mt-2 rounded hover:bg-brandDark transition shadow-md">
                        Sign Up
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
