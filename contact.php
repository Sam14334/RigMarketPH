<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RigMarket PH - Contact Support</title>
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
                <a href="contact.php" class="text-brand font-semibold">Contact</a>
                <a href="login.php" class="bg-brand hover:bg-brandDark text-white px-5 py-2 rounded font-semibold transition shadow-sm"><i class="fas fa-user mr-1"></i> Login / Register</a>
            </div>
            <button id="mobile-menu-btn" class="md:hidden text-2xl"><i class="fas fa-bars"></i></button>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-slate-800 border-t border-slate-700 shadow-lg">
            <div class="flex flex-col px-4 py-2 space-y-3">
                <a href="index.php" class="block py-1 hover:text-brand text-slate-300">Home</a>
                <a href="products.php" class="block py-1 hover:text-brand text-slate-300">Browse Market</a>
                <a href="about.php" class="block py-1 hover:text-brand text-slate-300">About Us</a>
                <a href="contact.php" class="block py-1 text-brand font-semibold">Contact</a>
                <a href="login.php" class="block py-1 text-brand font-semibold"><i class="fas fa-user mr-1"></i> Login / Register</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-10 flex-grow">
        <div class="max-w-2xl mx-auto">
            <!-- contact form -->
            <div class="bg-slate-800 rounded-lg border border-slate-700 p-6 md:p-8 h-fit">
                <h2 class="text-2xl font-bold text-white mb-2 border-b border-slate-600 pb-4"><i class="fas fa-envelope text-slate-400 mr-2"></i>Contact Support</h2>
                <p class="text-sm text-slate-400 mb-6">Need help? Want to report a suspicious user? Send our admin team a message.</p>

                <!-- Alert Banner for AJAX feedback (hidden by default) -->
                <div id="alert-box" class="hidden mb-6 p-4 rounded-lg text-sm font-medium border flex items-start justify-between">
                    <div class="flex items-center space-x-3">
                        <i id="alert-icon" class="fas fa-info-circle text-lg"></i>
                        <span id="alert-message"></span>
                    </div>
                    <button type="button" id="alert-close" class="text-slate-400 hover:text-white transition">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <form id="contact-form" class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1">Your Name</label>
                        <input type="text" name="name" required placeholder="e.g. Juan dela Cruz" class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1">Email Address</label>
                        <input type="email" name="email" required placeholder="e.g. juan@example.com" class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand">
                    </div>

                    <!-- 2-Tier Cascading Dropdowns -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1">Support Category</label>
                            <select id="support-category" name="category" required class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2 focus:outline-none focus:border-brand bg-slate-800">
                                <option value="">Loading categories...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-300 mb-1">Specific Issue</label>
                            <select id="support-issue" name="issue" required disabled class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2 focus:outline-none focus:border-brand bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed">
                                <option value="">Select category first</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-300 mb-1">Message</label>
                        <textarea name="message" required rows="4" placeholder="Please describe your concern in detail..." class="w-full bg-slate-700 text-white border border-slate-600 rounded p-2 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand"></textarea>
                    </div>
                    
                    <button type="submit" id="submit-btn" class="w-full bg-brand text-white font-bold py-3 rounded hover:bg-brandDark transition shadow-md flex items-center justify-center space-x-2">
                        <i id="submit-spinner" class="fas fa-spinner fa-spin hidden"></i>
                        <span id="submit-text">Send Message</span>
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

    <!-- =========================================================================
         BEGINNER'S GUIDE TO AJAX WITH JQUERY:
         How the 2-Tier Dropdown & Form Submission Work Without Page Refresh
         ========================================================================= -->
    <script>
    // -------------------------------------------------------------------------
    // Helper Function 1: Rebuilding a <select> dropdown dynamically
    // -------------------------------------------------------------------------
    // What it does:
    // 1. Empties out the old <option> tags.
    // 2. Appends a top placeholder option (e.g. "-- Select Category --").
    // 3. Loops through the array of items and creates an <option> for each.
    // 4. Enables the dropdown so the user can click it.
    function fillSelect(selector, items, placeholder) {
        const $select = $(selector).empty();
        $select.append($('<option>').val('').text(placeholder));

        $.each(items, function (index, item) {
            $select.append($('<option>').val(item).text(item));
        });

        $select.prop('disabled', false);
    }

    // -------------------------------------------------------------------------
    // Helper Function 2: Showing an inline alert message on screen
    // -------------------------------------------------------------------------
    function showAlert(type, message) {
        const $box = $('#alert-box');
        const $icon = $('#alert-icon');
        const $msg = $('#alert-message');

        // Reset any previous alert styling
        $box.removeClass('bg-green-900/40 border-green-500 text-green-300 bg-red-900/40 border-red-500 text-red-300');

        if (type === 'success') {
            $box.addClass('bg-green-900/40 border-green-500 text-green-300');
            $icon.attr('class', 'fas fa-check-circle text-lg text-green-400');
        } else {
            $box.addClass('bg-red-900/40 border-red-500 text-red-300');
            $icon.attr('class', 'fas fa-exclamation-triangle text-lg text-red-400');
        }

        $msg.text(message);
        $box.removeClass('hidden');
    }

    // Dismiss alert banner when clicking 'x'
    $('#alert-close').on('click', function () {
        $('#alert-box').addClass('hidden');
    });

    // -------------------------------------------------------------------------
    // Main jQuery Script (runs after the HTML document is fully parsed)
    // -------------------------------------------------------------------------
    $(function () {

        // =====================================================================
        // STEP 1: Load Dropdown 1 (Categories) as soon as the page opens
        // =====================================================================
        $.ajax({
            url: 'api.php?action=support_data',
            method: 'POST',
            data: { type: 'categories' },
            dataType: 'json'
        })
        .done(function (response) {
            if (response.ok) {
                fillSelect('#support-category', response.items, 'Select Category...');
            }
        })
        .fail(function () {
            $('#support-category').html('<option value="">Error loading categories</option>');
        });

        // =====================================================================
        // STEP 2: When Category changes, fetch Dropdown 2 (Specific Issues)
        // =====================================================================
        $('#support-category').on('change', function () {
            const selectedCategory = $(this).val();

            // Disable Dropdown 2 while we wait for the server response
            const $issue = $('#support-issue')
                .prop('disabled', true)
                .empty()
                .append('<option value="">Loading issues...</option>');

            if (!selectedCategory) {
                // User reset category to empty option
                $issue.empty().append('<option value="">Select category first</option>');
                return;
            }

            // Ask api.php for the issues that belong to this category
            $.ajax({
                url: 'api.php?action=support_data',
                method: 'POST',
                data: {
                    type: 'issues',
                    category: selectedCategory
                },
                dataType: 'json'
            })
            .done(function (response) {
                if (response.ok) {
                    fillSelect('#support-issue', response.items, 'Select Specific Issue...');
                }
            })
            .fail(function () {
                $issue.empty().append('<option value="">Error loading issues</option>');
            });
        });

        // =====================================================================
        // STEP 3: AJAX Form Submission (No page refresh!)
        // =====================================================================
        $('#contact-form').on('submit', function (e) {
            // CRUCIAL: e.preventDefault() prevents the default HTML form action!
            // Without this, the browser would reload the page and wipe the screen.
            e.preventDefault();

            // Hide any previous alerts
            $('#alert-box').addClass('hidden');

            // 1. Show loading state on the button
            const $btn = $('#submit-btn').prop('disabled', true).addClass('opacity-75 cursor-not-allowed');
            const $spinner = $('#submit-spinner').removeClass('hidden');
            const $btnText = $('#submit-text').text('Sending Message...');

            // 2. Package all form inputs into a URL-encoded string (name=Val&email=Val...)
            const formData = $(this).serialize();

            // 3. Send data in the background to api.php?action=contact
            $.ajax({
                url: 'api.php?action=contact',
                method: 'POST',
                data: formData,
                dataType: 'json'
            })
            .done(function (response) {
                if (response.ok) {
                    // Show green success alert with ticket ID
                    showAlert('success', response.message);

                    // Clear the form fields
                    $('#contact-form')[0].reset();

                    // Reset Dropdown 2 back to disabled state
                    $('#support-issue')
                        .prop('disabled', true)
                        .empty()
                        .append('<option value="">Select category first</option>');
                } else {
                    // Show red error alert
                    showAlert('error', response.message || 'Something went wrong.');
                }
            })
            .fail(function (xhr) {
                // If server returned a 4xx or 5xx status code
                const errorMsg = (xhr.responseJSON && xhr.responseJSON.message) 
                    ? xhr.responseJSON.message 
                    : 'Failed to connect to server. Please try again later.';
                showAlert('error', errorMsg);
            })
            .always(function () {
                // ALWAYS restore the button whether the request succeeded or failed
                $btn.prop('disabled', false).removeClass('opacity-75 cursor-not-allowed');
                $spinner.addClass('hidden');
                $btnText.text('Send Message');
            });
        });

    });
    </script>
</body>
</html>
