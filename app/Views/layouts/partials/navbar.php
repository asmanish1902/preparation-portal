<header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-8 shrink-0">
    <div class="flex items-center gap-3">
        <!-- Mobile Sidebar Toggle -->
        <button @click="sidebarOpen = !sidebarOpen" type="button" class="lg:hidden text-slate-600 p-2 rounded-lg hover:bg-slate-100 focus:outline-none">
            <i class="bx bx-menu text-2xl"></i>
        </button>

        <h2 class="heading-font text-base sm:text-lg font-bold text-slate-800">
            <?= esc($title ?? 'Dashboard') ?>
        </h2>
    </div>

    <div class="flex items-center gap-3 sm:gap-4">
        <!-- User Profile Pill -->
        <div class="flex items-center gap-2.5 py-1.5 pl-3 pr-1.5 rounded-xl border border-slate-200 bg-slate-50">
            <span class="text-xs sm:text-sm font-semibold text-slate-700 select-none">
                <?= esc(auth()->user()->username ?? 'Admin') ?>
            </span>
            <div class="h-7 w-7 rounded-lg bg-indigo-600 flex items-center justify-center text-xs font-bold text-white uppercase tracking-wider">
                <?= esc(substr(auth()->user()->username ?? 'A', 0, 2)) ?>
            </div>
        </div>

        <!-- Logout Button -->
        <a href="<?= route_to('admin.logout') ?>"
            class="inline-flex items-center justify-center text-xs sm:text-sm font-semibold text-rose-600 bg-rose-50 border border-rose-200/60 rounded-xl px-3 sm:px-4 py-2 hover:bg-rose-100 hover:text-rose-700 transition-colors active:scale-[0.98]">
            Logout
        </a>
    </div>
</header>