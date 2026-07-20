<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="min-h-screen flex flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">

        <!-- Premium Branding & Header Section -->
        <div class="text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 shadow-lg shadow-indigo-200">
                <!-- Boxicons Security Key Keyring Icon -->
                <i class="bx bx-key text-white text-xl"></i>
            </div>

            <h1 class="heading-font mt-6 text-3xl font-extrabold tracking-tight text-slate-900">
                Reset password
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                Enter your details to receive a secure recovery link
            </p>
        </div>

        <!-- Modern Interface Card -->
        <div class="bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-100/40 p-8 sm:p-10">

            <!-- CodeIgniter Session Flash Alerts -->
            <?php if (session('success')) : ?>
                <div class="mb-6 flex items-center gap-3 rounded-xl bg-emerald-50 border border-emerald-200/60 text-emerald-800 px-4 py-3.5 text-sm shadow-sm">
                    <i class="bx bx-check-circle text-emerald-600 text-lg shrink-0"></i>
                    <span><?= esc(session('success')) ?></span>
                </div>
            <?php endif; ?>

            <?php if (session('error')) : ?>
                <div class="mb-6 flex items-center gap-3 rounded-xl bg-rose-50 border border-rose-200/60 text-rose-800 px-4 py-3.5 text-sm shadow-sm">
                    <i class="bx bx-x-circle text-rose-600 text-lg shrink-0"></i>
                    <span><?= esc(session('error')) ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= route_to('password.request.submit') ?>" method="post" class="space-y-6">
                <?= csrf_field() ?>

                <!-- Email Address Field -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="<?= old('email') ?>"
                            placeholder="admin@portal.com"
                            required
                            class="w-full rounded-xl border border-slate-300/80 bg-slate-50/50 px-4 py-3 text-slate-900 transition-all duration-200 placeholder:text-slate-400 outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 <?= session('errors.email') ? 'border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>">
                    </div>

                    <?php if (session('errors.email')) : ?>
                        <p class="mt-1.5 text-xs font-medium text-rose-600 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                            <?= session('errors.email') ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Form Submit Action -->
                <button
                    type="submit"
                    class="relative w-full flex justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 py-3.5 px-4 text-sm font-semibold text-white shadow-md shadow-indigo-200/50 hover:from-indigo-500 hover:to-violet-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all active:scale-[0.98]">
                    Send Recovery Email
                </button>
            </form>

            <!-- Back to Login Navigation Anchor -->
            <div class="mt-6 text-center">
                <a href="<?= route_to('admin.login') ?>" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-indigo-600 transition group">
                    <!-- Font Awesome Animated Navigation Arrow -->
                    <i class="fa-solid fa-arrow-left text-xs transition-transform group-hover:-translate-x-0.5"></i>
                    Back to login
                </a>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>