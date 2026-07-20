<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="min-h-screen flex flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">

        <!-- Premium Branding & Warning Header Section -->
        <div class="text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-tr from-amber-500 to-rose-500 shadow-lg shadow-rose-100 animate-pulse">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                </svg>
            </div>

            <h1 class="heading-font mt-6 text-3xl font-extrabold tracking-tight text-slate-900">
                Access Denied
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                Error Code: <span class="font-mono font-semibold text-slate-700">403 Restricted</span>
            </p>
        </div>

        <!-- Modern Interface Card -->
        <div class="bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-100/40 p-8 sm:p-10 text-center">

            <p class="text-slate-600 text-sm leading-relaxed mb-8">
                You do not have the required administrative permissions to access this zone. If you believe this is an error, please contact your systems administrator or verify your login credentials.
            </p>

            <div class="space-y-3">
                <!-- Primary Action: Go Back -->
                <a
                    href="javascript:history.back()"
                    class="w-full flex justify-center rounded-xl bg-gradient-to-r from-slate-800 to-slate-900 py-3.5 px-4 text-sm font-semibold text-white shadow-md hover:from-slate-700 hover:to-slate-800 transition-all active:scale-[0.98]">
                    Return to Previous Page
                </a>

                <!-- Secondary Action: Re-authenticate -->
                <a
                    href="<?= route_to('admin.login') ?>"
                    class="w-full flex justify-center rounded-xl border border-slate-300 bg-white py-3.5 px-4 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition-all active:scale-[0.98]">
                    Sign In with Different Account
                </a>
            </div>

            <!-- Minimalist Support Link Anchor -->
            <div class="mt-8 border-t border-slate-100 pt-6">
                <a href="#" class="text-xs font-medium text-indigo-600 hover:text-indigo-700 transition">
                    Need assistance? Contact support portal
                </a>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>