<form action="<?= $action ?>" method="<?= $method ?>" class="space-y-6">
    <?= csrf_field() ?>
    <input type="hidden" name="mode" value="single">

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        <!-- Question Dropdown -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="question_id" class="block text-sm font-semibold text-slate-700">
                Question <span class="text-rose-500">*</span>
            </label>
            <?php $selectedQ = (int) old('question_id', $option['question_id'] ?? 0); ?>
            <select name="question_id" id="question_id" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                <option value="">Select Target Question</option>
                <?php foreach ($questions as $q): ?>
                    <option value="<?= $q['id'] ?>" <?= $selectedQ === (int) $q['id'] ? 'selected' : '' ?>>
                        #<?= $q['id'] ?> - <?= esc(mb_strimwidth($q['question_text'], 0, 60, '...')) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Is Correct Choice -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="is_correct" class="block text-sm font-semibold text-slate-700">
                Is Correct Answer? <span class="text-rose-500">*</span>
            </label>
            <?php $isCorrectVal = (int) old('is_correct', $option['is_correct'] ?? 0); ?>
            <select name="is_correct" id="is_correct" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                <option value="0" <?= $isCorrectVal === 0 ? 'selected' : '' ?>>No (Incorrect Choice)</option>
                <option value="1" <?= $isCorrectVal === 1 ? 'selected' : '' ?>>Yes (Correct Answer)</option>
            </select>
        </div>

        <!-- Option Text -->
        <div class="col-span-2 space-y-2">
            <label for="option_text" class="block text-sm font-semibold text-slate-700">
                Option Text <span class="text-rose-500">*</span>
            </label>
            <textarea name="option_text" id="option_text" rows="3" required
                placeholder="Enter the option choice text..."
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition"><?= old('option_text', $option['option_text'] ?? '') ?></textarea>
        </div>

        <!-- Status -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="status" class="block text-sm font-semibold text-slate-700">
                Status
            </label>
            <?php $currentStatus = (int) old('status', $option['status'] ?? 1); ?>
            <select name="status" id="status" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                <option value="1" <?= $currentStatus === 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= $currentStatus === 0 ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>

        <!-- Explanation -->
        <div class="col-span-2 space-y-2">
            <label for="explanation" class="block text-sm font-semibold text-slate-700">
                Explanation / Answer Rationale
            </label>
            <textarea name="explanation" id="explanation" rows="3"
                placeholder="Optional explanation for why this choice is right or wrong..."
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition"><?= old('explanation', $option['explanation'] ?? '') ?></textarea>
        </div>

    </div>

    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
        <a href="<?= route_to('admin.options.index') ?>" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
            Cancel
        </a>
        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-600/10 hover:bg-indigo-500 transition active:scale-[0.98]">
            <i class="bx bx-check-circle text-lg"></i>
            <?= isset($option['id']) ? 'Update Option' : 'Save Option' ?>
        </button>
    </div>
</form>