<form action="<?= $action ?>" method="<?= $method ?>" class="space-y-6">
    <?= csrf_field() ?>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        <!-- Category Dropdown -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="category_id" class="block text-sm font-semibold text-slate-700">
                Category <span class="text-rose-500">*</span>
            </label>
            <?php $selectedCat = (int) old('category_id', $exam['category_id'] ?? 0); ?>
            <select name="category_id" id="category_id" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= $selectedCat === (int) $category['id'] ? 'selected' : '' ?>>
                        <?= esc($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Subject Dropdown -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="subject_id" class="block text-sm font-semibold text-slate-700">
                Subject <span class="text-rose-500">*</span>
            </label>
            <?php $selectedSub = (int) old('subject_id', $exam['subject_id'] ?? 0); ?>
            <select name="subject_id" id="subject_id" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                <option value="">Select Subject</option>
                <?php foreach ($subjects as $subject): ?>
                    <option value="<?= $subject['id'] ?>" <?= $selectedSub === (int) $subject['id'] ? 'selected' : '' ?>>
                        <?= esc($subject['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Exam Title -->
        <div class="col-span-2 space-y-2">
            <label for="title" class="block text-sm font-semibold text-slate-700">
                Exam Title <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="title" id="title" required
                value="<?= old('title', $exam['title'] ?? '') ?>"
                placeholder="e.g. PHP Advanced Certification Exam 2026"
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
        </div>

        <!-- Duration (Minutes) -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="duration_minutes" class="block text-sm font-semibold text-slate-700">
                Duration (Minutes) <span class="text-rose-500">*</span>
            </label>
            <input type="number" name="duration_minutes" id="duration_minutes" min="1" required
                value="<?= old('duration_minutes', $exam['duration_minutes'] ?? 60) ?>"
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
        </div>

        <!-- Total Marks -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="total_marks" class="block text-sm font-semibold text-slate-700">
                Total Marks <span class="text-rose-500">*</span>
            </label>
            <input type="number" name="total_marks" id="total_marks" min="1" required
                value="<?= old('total_marks', $exam['total_marks'] ?? 100) ?>"
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
        </div>

        <!-- Passing Marks -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="pass_mark" class="block text-sm font-semibold text-slate-700">
                Pass Mark <span class="text-rose-500">*</span>
            </label>
            <input type="number" name="pass_mark" id="pass_mark" min="0" required
                value="<?= old('pass_mark', $exam['pass_mark'] ?? 50) ?>"
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
        </div>

        <!-- Status -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="status" class="block text-sm font-semibold text-slate-700">
                Status
            </label>
            <?php $currentStatus = (int) old('status', $exam['status'] ?? 1); ?>
            <select name="status" id="status" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                <option value="1" <?= $currentStatus === 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= $currentStatus === 0 ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>

        <!-- Description -->
        <div class="col-span-2 space-y-2">
            <label for="description" class="block text-sm font-semibold text-slate-700">
                Description / Instructions
            </label>
            <textarea name="description" id="description" rows="3"
                placeholder="Enter exam guidelines or notes for candidates..."
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition"><?= old('description', $exam['description'] ?? '') ?></textarea>
        </div>

    </div>

    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
        <a href="<?= route_to('admin.exams.index') ?>" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
            Cancel
        </a>
        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-600/10 hover:bg-indigo-500 transition active:scale-[0.98]">
            <i class="bx bx-check-circle text-lg"></i>
            <?= isset($exam['id']) ? 'Update Exam' : 'Save Exam' ?>
        </button>
    </div>
</form>