<!DOCTYPE html>
<html lang="en" class="h-full scroll-smooth">

<!-- Header Partial Include (Contains <head>, Tailwind/Vite CSS, Meta tags) -->
<?= view('layouts/partials/header') ?>

<body class="h-full bg-slate-50 text-slate-900 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen overflow-hidden">

        <!-- Sidebar Partial Include -->
        <?= view('layouts/partials/sidebar') ?>

        <!-- Main Workspace Container -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

            <!-- Navbar Partial Include -->
            <?= view('layouts/partials/navbar') ?>

            <!-- Workspace Output Context -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto flex flex-col justify-between">

                <div class="flex-1">
                    <!-- Breadcrumbs Partial Include -->
                    <?= view('layouts/partials/breadcrumb') ?>

                    <!-- Flash Messages Partial Include -->
                    <?= view('layouts/partials/flash_messages') ?>

                    <!-- Primary Content Area -->
                    <div class="animate-fade-in py-2">
                        <?= $this->renderSection('content') ?>
                    </div>
                </div>

                <!-- Footer Partial Include -->
                <?= view('layouts/partials/footer') ?>
            </main>
        </div>

    </div>

    <!-- Script Stack for Page-Specific JS -->
    <?= $this->renderSection('scripts') ?>

    <script>
        // Initialize Lucide Icons globally
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>

    <script>
        function confirmSoftDelete(event) {
            event.preventDefault();
            const form = event.target;

            Swal.fire({
                title: 'Move to Trash?',
                text: 'This record will be moved to the trash bin.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, trash it!',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-4 py-2 text-sm font-semibold',
                    cancelButton: 'rounded-xl px-4 py-2 text-sm font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

            return false;
        }

        function confirmForceDelete(event) {
            event.preventDefault();
            const form = event.target;

            Swal.fire({
                title: 'Permanently Delete?',
                text: 'This action cannot be undone!',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Yes, delete forever!',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-4 py-2 text-sm font-semibold',
                    cancelButton: 'rounded-xl px-4 py-2 text-sm font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

            return false;
        }
    </script>
</body>

</html>