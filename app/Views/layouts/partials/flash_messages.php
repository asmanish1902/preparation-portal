<!-- Success Alert -->
<?php if (session('success')) : ?>
    <div x-data="{ show: true }"
        x-show="show"
        x-cloak
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="mb-6 flex items-center justify-between gap-3 rounded-xl bg-emerald-50 border border-emerald-200/60 text-emerald-800 px-4 py-3.5 text-sm shadow-sm">
        <div class="flex items-center gap-3">
            <i class="bx bx-check-circle text-xl text-emerald-600 shrink-0"></i>
            <span class="font-medium"><?= esc(session('success')) ?></span>
        </div>
        <button @click.prevent="show = false" type="button" class="text-emerald-500 hover:text-emerald-700 p-1 rounded-lg transition" title="Dismiss message">
            <i class="bx bx-x text-xl pointer-events-none"></i>
        </button>
    </div>
<?php endif; ?>

<!-- Single Error Alert -->
<?php if (session('error')) : ?>
    <div x-data="{ show: true }"
        x-show="show"
        x-cloak
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="mb-6 flex items-center justify-between gap-3 rounded-xl bg-rose-50 border border-rose-200/60 text-rose-800 px-4 py-3.5 text-sm shadow-sm">
        <div class="flex items-center gap-3">
            <i class="bx bx-error-circle text-xl text-rose-600 shrink-0"></i>
            <span class="font-medium"><?= esc(session('error')) ?></span>
        </div>
        <button @click.prevent="show = false" type="button" class="text-rose-500 hover:text-rose-700 p-1 rounded-lg transition" title="Dismiss message">
            <i class="bx bx-x text-xl pointer-events-none"></i>
        </button>
    </div>
<?php endif; ?>

<!-- Validation Error List Alert -->
<?php if (session('errors')) : ?>
    <div x-data="{ show: true }"
        x-show="show"
        x-cloak
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="mb-6 rounded-xl bg-rose-50 border border-rose-200/60 text-rose-800 px-4 py-3.5 text-sm shadow-sm">
        <div class="flex items-start justify-between gap-3 mb-2">
            <div class="flex items-center gap-2 font-semibold">
                <i class="bx bx-error text-xl text-rose-600 shrink-0"></i>
                Please check the form for errors:
            </div>
            <button @click.prevent="show = false" type="button" class="text-rose-500 hover:text-rose-700 p-1 rounded-lg transition" title="Dismiss message">
                <i class="bx bx-x text-xl pointer-events-none"></i>
            </button>
        </div>
        <ul class="list-disc list-inside space-y-1 text-xs text-rose-700 ml-7">
            <?php foreach ((array) session('errors') as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>