<form action="<?= $action ?>" method="post" class="space-y-6">
    <?= csrf_field() ?>

    <!-- Method Spoofing for PUT/PATCH/DELETE -->
    <?php if (isset($method) && strtoupper($method) !== 'POST'): ?>
        <input type="hidden" name="_method" value="<?= strtoupper($method) ?>">
    <?php endif; ?>

    <!-- Two Column Input Row -->
    <div class="grid gap-6 sm:grid-cols-2">
        <!-- Category Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                Category Name <span class="text-rose-500">*</span>
            </label>
            <div class="relative flex items-center">
                <i class="bx bx-folder text-slate-400 text-lg absolute left-4 pointer-events-none"></i>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="<?= old('name', $category['name'] ?? '') ?>"
                    placeholder="e.g., Advanced JavaScript Frameworks"
                    class="w-full rounded-xl border border-slate-300/80 bg-slate-50/50 pl-11 pr-4 py-2.5 text-slate-900 transition-all duration-200 placeholder:text-slate-400 outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10"
                    required>
            </div>
            <?php if (session('errors.name')) : ?>
                <p class="mt-1.5 text-xs font-medium text-rose-600 flex items-center gap-1">
                    <i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                    <?= session('errors.name') ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Slug (Readonly) -->
        <div>
            <label for="slug" class="block text-sm font-semibold text-slate-700 mb-2">
                URL Slug
            </label>
            <div class="relative flex items-center">
                <i class="bx bx-link text-slate-400 text-lg absolute left-4 pointer-events-none"></i>
                <input
                    type="text"
                    name="slug"
                    id="slug"
                    value="<?= old('slug', $category['slug'] ?? '') ?>"
                    placeholder="auto-generated-slug-path"
                    class="w-full rounded-xl border border-slate-200 bg-slate-100 pl-11 pr-4 py-2.5 text-slate-500 font-mono text-xs select-all outline-none"
                    readonly>
            </div>
        </div>
    </div>

    <!-- Description Text Area -->
    <div>
        <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">
            Description
        </label>
        <textarea
            name="description"
            id="description"
            rows="4"
            placeholder="Provide a brief summary detailing the scope of examinations structured under this classification node..."
            class="w-full rounded-xl border border-slate-300/80 bg-slate-50/50 px-4 py-2.5 text-slate-900 transition-all duration-200 placeholder:text-slate-400 outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10"><?= old('description', $category['description'] ?? '') ?></textarea>
    </div>

    <!-- Two Column Utility Row -->
    <div class="grid gap-6 sm:grid-cols-2">
        <!-- Sort Order -->
        <div>
            <label for="sort_order" class="block text-sm font-semibold text-slate-700 mb-2">
                Sort Order Position
            </label>
            <div class="relative flex items-center">
                <i class="bx bx-sort text-slate-400 text-lg absolute left-4 pointer-events-none"></i>
                <input
                    type="number"
                    name="sort_order"
                    id="sort_order"
                    value="<?= old('sort_order', $category['sort_order'] ?? 0) ?>"
                    class="w-full rounded-xl border border-slate-300/80 bg-slate-50/50 pl-11 pr-4 py-2.5 text-slate-900 transition-all duration-200 outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10">
            </div>
        </div>

        <!-- Status -->
        <div>
            <label for="status" class="block text-sm font-semibold text-slate-700 mb-2">
                Deployment Status
            </label>
            <div class="relative flex items-center">
                <i class="bx bx-toggle-left text-slate-400 text-lg absolute left-4 pointer-events-none"></i>
                <select
                    name="status"
                    id="status"
                    class="w-full appearance-none rounded-xl border border-slate-300/80 bg-slate-50/50 pl-11 pr-10 py-2.5 text-slate-900 transition-all duration-200 outline-none focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-500/10">
                    <option value="1" <?= old('status', $category['status'] ?? 1) == 1 ? 'selected' : '' ?>>Active (Visible Cross-Portal)</option>
                    <option value="0" <?= old('status', $category['status'] ?? 1) == 0 ? 'selected' : '' ?>>Inactive (Hidden / Draft Mode)</option>
                </select>
                <i class="bx bx-chevron-down text-slate-400 text-lg absolute right-4 pointer-events-none"></i>
            </div>
        </div>
    </div>

    <!-- Divider Line Layout -->
    <div class="border-t border-slate-200 pt-5 mt-8 flex items-center justify-end gap-3">
        <!-- Cancel Action Anchor -->
        <a href="<?= route_to('admin.categories.index') ?>" class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition-all active:scale-[0.98]">
            Cancel
        </a>

        <!-- Primary Execution Submit Trigger -->
        <button
            type="submit"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-200/50 hover:from-indigo-500 hover:to-violet-500 transition-all active:scale-[0.98]">
            <i class="bx bx-save text-lg"></i>
            <?= isset($category) ? 'Save Internal Changes' : 'Create Grouping Category' ?>
        </button>
    </div>
</form>