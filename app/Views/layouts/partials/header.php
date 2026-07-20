<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin Panel') ?></title>

    <!-- FOUC Prevention Layer -->
    <style>
        html {
            opacity: 0;
            transition: opacity 0.1s ease;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.documentElement.style.opacity = "1";
        });
    </script>

    <!-- High-Priority Network Preloading for Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- External Icon Sheets (Boxicons & FontAwesome) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">


    <!-- SweetAlert2 CSS & JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Dynamic Vite Pipeline Integration -->
    <?php if (ENVIRONMENT === 'development'): ?>
        <script type="module" src="http://localhost:5173/@vite/client"></script>
        <script type="module" src="http://localhost:5173/resources/js/app.js"></script>
    <?php else: ?>
        <link rel="stylesheet" href="<?= base_url('build/assets/app.css') ?>">
        <script type="module" src="<?= base_url('build/assets/app.js') ?>"></script>
    <?php endif; ?>

    <!-- Core Layout Styling -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .heading-font {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .bx,
        .fa-solid,
        .fa,
        [class^="bx-"],
        [class*=" bx-"] {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            width: 1em !important;
            height: 1em !important;
            max-width: 24px !important;
            max-height: 24px !important;
            overflow: hidden !important;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>