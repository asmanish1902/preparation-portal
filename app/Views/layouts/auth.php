<!doctype html>
<html lang="en" class="h-full scroll-smooth bin-features">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Testing Portal') ?></title>

    <!-- Premium Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Development Vite Assets -->
    <script type="module" src="http://localhost:5173/@vite/client"></script>
    <script type="module" src="http://localhost:5173/resources/js/app.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .heading-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="h-full bg-gradient-to-br from-slate-50 via-indigo-50/30 to-slate-100 text-slate-900 antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Modern App Shell Wrapper -->
    <div class="flex min-h-screen flex-col">

        <!-- Premium Glassmorphic Navigation Header -->
        <header class="sticky top-0 z-40 w-full border-b border-slate-200/80 bg-white/75 backdrop-blur-md transition-all duration-300">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

                <!-- Logo / Brand Identity -->
                <div class="flex items-center gap-2.5">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 shadow-md shadow-indigo-200">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0112 3m0 0c2.917 0 5.747.294 8.5.862m-21 10.398c0-.552.448-1 1-1h6.25a1 1 0 011 1v3.83a1 1 0 01-1 1H2.5a1 1 0 01-1-1v-3.83z" />
                        </svg>
                    </div>
                    <span class="heading-font text-lg font-bold tracking-tight text-slate-900">
                        Test<span class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Portal</span>
                    </span>
                </div>

                <!-- Contextual Header Center (e.g., Global Search or Live Timer Anchor) -->
                <div class="hidden md:flex items-center gap-6">
                    <!-- Target for dynamic exam tracking or navigational links -->
                </div>

                <!-- User Interface controls & Profile Dropdown -->
                <div class="flex items-center gap-4">
                    <!-- Status Badge -->
                    <div class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Portal Active
                    </div>

                    <!-- Profile Avatar Skeleton (Modern Round-Square) -->
                    <button type="button" class="group flex items-center gap-x-2 rounded-xl p-1.5 transition-all duration-200 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500/20">
                        <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-indigo-100 to-slate-200 p-0.5 group-hover:scale-105 transition-transform">
                            <div class="flex h-full w-full items-center justify-center rounded-[6px] bg-white font-semibold text-xs text-indigo-600">
                                AP
                            </div>
                        </div>
                    </button>
                </div>

            </div>
        </header>

        <!-- Main Workspace Area -->
        <main class="mx-auto w-full max-w-7xl flex-1 px-4 py-8 sm:px-6 lg:px-8">
            <div class="animate-fade-in transition-opacity duration-300">
                <?= $this->renderSection('content') ?>
            </div>
        </main>

        <!-- Minimalist Footer -->
        <footer class="mt-auto border-t border-slate-200/60 bg-white/40 py-4 text-center text-xs text-slate-500 backdrop-blur-sm">
            &copy; <?= date('Y') ?> Testing Portal. All rights reserved.
        </footer>
    </div>

    <!-- Production Compiled Assets -->
    <?= vite_js() ?>
</body>

</html>