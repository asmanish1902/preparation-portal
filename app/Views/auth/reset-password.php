<?= $this->extend('layouts/auth') ?>

<?= $this->section('content') ?>
<div class="min-h-screen flex flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8">

        <!-- Premium Branding & Header Section -->
        <div class="text-center">
            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 shadow-lg shadow-indigo-200">
                <!-- Boxicons Lock Open Variant Icon -->
                <i class="bx bx-lock-open-alt text-white text-xl"></i>
            </div>

            <h1 class="heading-font mt-6 text-3xl font-extrabold tracking-tight text-slate-900">
                Set new password
            </h1>
            <p class="mt-2 text-sm text-slate-500">
                Please choose a strong, unique password for your account
            </p>
        </div>

        <!-- Modern Interface Card -->
        <div class="bg-white/80 backdrop-blur-md rounded-2xl border border-slate-200/60 shadow-xl shadow-slate-100/40 p-8 sm:p-10">

            <!-- CodeIgniter Session Flash Alerts -->
            <?php if (session('error')) : ?>
                <div class="mb-6 flex items-center gap-3 rounded-xl bg-rose-50 border border-rose-200/60 text-rose-800 px-4 py-3.5 text-sm shadow-sm">
                    <i class="bx bx-x-circle text-rose-600 text-lg shrink-0"></i>
                    <span><?= esc(session('error')) ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= route_to('password.reset.update') ?>" method="post" class="space-y-6">
                <?= csrf_field() ?>

                <!-- Hidden token field passed down from the controller/URL route -->
                <input type="hidden" name="token" value="<?= esc($token ?? '') ?>">

                <!-- New Password Field -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">
                        New Password
                    </label>
                    <div class="relative flex items-center">
                        <i class="bx bx-lock-alt text-slate-400 text-lg absolute left-4 pointer-events-none"></i>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            class="w-full rounded-xl border border-slate-300/80 bg-slate-50/50 pl-11 pr-4 py-3 text-slate-900 transition-all duration-200 placeholder:text-slate-400 outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 <?= session('errors.password') ? 'border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>">
                    </div>

                    <?php if (session('errors.password')) : ?>
                        <p class="mt-1.5 text-xs font-medium text-rose-600 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                            <?= session('errors.password') ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirm" class="block text-sm font-semibold text-slate-700 mb-2">
                        Confirm New Password
                    </label>
                    <div class="relative flex items-center">
                        <i class="bx bx-lock-alt text-slate-400 text-lg absolute left-4 pointer-events-none"></i>
                        <input
                            id="password_confirm"
                            type="password"
                            name="password_confirm"
                            placeholder="••••••••"
                            required
                            class="w-full rounded-xl border border-slate-300/80 bg-slate-50/50 pl-11 pr-4 py-3 text-slate-900 transition-all duration-200 placeholder:text-slate-400 outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 <?= session('errors.password_confirm') ? 'border-rose-400 bg-rose-50/20 focus:border-rose-500 focus:ring-rose-500/10' : '' ?>">
                    </div>

                    <?php if (session('errors.password_confirm')) : ?>
                        <p class="mt-1.5 text-xs font-medium text-rose-600 flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                            <?= session('errors.password_confirm') ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Form Submit Action -->
                <button
                    type="submit"
                    class="relative w-full flex justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 py-3.5 px-4 text-sm font-semibold text-white shadow-md shadow-indigo-200/50 hover:from-indigo-500 hover:to-violet-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all active:scale-[0.98]">
                    Update Password
                </button>
            </form>

        </div>
    </div>
</div>
<?= $this->endSection() ?>