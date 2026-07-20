<form action="<?= $action ?>" method="<?= $method ?>" class="space-y-6">
    <?= csrf_field() ?>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        <!-- Subject Name -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="name" class="block text-sm font-semibold text-slate-700">
                Subject Name <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="name" id="name" required
                value="<?= old('name', $subject['name'] ?? '') ?>"
                placeholder="e.g. PHP, Laravel, MySQL"
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
        </div>

        <!-- Subject Code -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="code" class="block text-sm font-semibold text-slate-700">
                Subject Code
            </label>
            <input type="text" name="code" id="code"
                value="<?= old('code', $subject['code'] ?? '') ?>"
                placeholder="e.g. PHP-101, LAR-200"
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
        </div>

        <!-- Sort Order -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="sort_order" class="block text-sm font-semibold text-slate-700">
                Sort Order
            </label>
            <input type="number" name="sort_order" id="sort_order" min="0"
                value="<?= old('sort_order', $subject['sort_order'] ?? 0) ?>"
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
        </div>

        <!-- Status -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="status" class="block text-sm font-semibold text-slate-700">
                Status
            </label>
            <?php $currentStatus = (int) old('status', $subject['status'] ?? 1); ?>
            <select name="status" id="status" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                <option value="1" <?= $currentStatus === 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= $currentStatus === 0 ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>

        <!-- Description -->
        <div class="col-span-2 space-y-2">
            <label for="description" class="block text-sm font-semibold text-slate-700">
                Description
            </label>
            <textarea name="description" id="description" rows="3"
                placeholder="Provide a brief overview of what this subject covers..."
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition"><?= old('description', $subject['description'] ?? '') ?></textarea>
        </div>

    </div>

    <!-- Form Submit Button Bar -->
    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
        <a href="<?= route_to('admin.subjects.index') ?>" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
            Cancel
        </a>
        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-600/10 hover:bg-indigo-500 transition active:scale-[0.98]">
            <i class="bx bx-check-circle text-lg"></i>
            <?= isset($subject['id']) ? 'Update Subject' : 'Save Subject' ?>
        </button>
    </div>
</form>