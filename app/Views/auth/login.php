<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="min-h-screen flex flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">

        <!-- Premium Branding & Header Section -->
        <div class="text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 shadow-lg shadow-indigo-200">
                <!-- Boxicons Modern Shield Lock Icon -->
                <i class="bx bx-shield-quarter text-white text-xl"></i>
            </div>

            <h1 class="heading-font mt-6 text-3xl font-extrabold tracking-tight text-slate-900">
                Welcome back
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                Sign in to manage the <span class="font-semibold text-slate-700">Testing Portal</span>
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

            <form action="<?= route_to('admin.login.submit') ?>" method="post" class="space-y-6">
                <?= csrf_field() ?>

                <!-- Identity Field -->
                <div>
                    <label for="login" class="block text-sm font-semibold text-slate-700 mb-2">
                        Email or Username
                    </label>
                    <div class="relative flex items-center">
                        <i class="bx bx-user text-slate-400 text-lg absolute left-4 pointer-events-none"></i>
                        <input
                            id="login"
                            type="text"
                            name="login"
                            value="<?= old('login') ?>"
                            placeholder="admin@portal.com"
                            class="w-full rounded-xl border border-slate-300/80 bg-slate-50/50 pl-11 pr-4 py-3 text-slate-900 transition-all duration-200 placeholder:text-slate-400 outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 <?= session('errors.login') ? 'border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>">
                    </div>
                    <?php if (session('errors.login')) : ?>
                        <p class="mt-1.5 text-xs font-medium text-rose-600 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                            <?= session('errors.login') ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                        Password
                    </label>
                    <div class="relative flex items-center">
                        <i class="bx bx-lock-alt text-slate-400 text-lg absolute left-4 pointer-events-none"></i>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full rounded-xl border border-slate-300/80 bg-slate-50/50 pl-11 pr-4 py-3 text-slate-900 transition-all duration-200 placeholder:text-slate-400 outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 <?= session('errors.password') ? 'border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>">
                    </div>
                    <?php if (session('errors.password')) : ?>
                        <p class="mt-1.5 text-xs font-medium text-rose-600 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                            <?= session('errors.password') ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Utilities Row -->
                <div class="flex justify-between items-center text-sm">
                    <label class="flex items-center gap-2.5 cursor-pointer group select-none">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                            class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500/30 cursor-pointer">
                        <span class="text-slate-600 group-hover:text-slate-900 transition-colors">
                            Remember me
                        </span>
                    </label>
                    <a href="#" class="font-medium text-indigo-600 hover:text-indigo-700 hover:underline underline-offset-4 transition">
                        Forgot password?
                    </a>
                </div>

                <!-- Form Submit Action -->
                <button
                    type="submit"
                    class="relative w-full flex justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 py-3.5 px-4 text-sm font-semibold text-white shadow-md shadow-indigo-200/50 hover:from-indigo-500 hover:to-violet-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all active:scale-[0.98]">
                    Sign In to Dashboard
                </button>
            </form>

        </div>
    </div>
</div>
<?= $this->endSection() ?>