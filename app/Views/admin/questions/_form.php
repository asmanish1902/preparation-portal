<form action="<?= $action ?>" method="<?= $method ?>" class="space-y-6">
    <?= csrf_field() ?>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        <!-- Exam Dropdown -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="exam_id" class="block text-sm font-semibold text-slate-700">
                Exam <span class="text-rose-500">*</span>
            </label>
            <?php $selectedExam = (int) old('exam_id', $question['exam_id'] ?? 0); ?>
            <select name="exam_id" id="exam_id" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                <option value="">Select Target Exam</option>
                <?php foreach ($exams as $exam): ?>
                    <option value="<?= $exam['id'] ?>" <?= $selectedExam === (int) $exam['id'] ? 'selected' : '' ?>>
                        <?= esc($exam['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Question Type -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="question_type" class="block text-sm font-semibold text-slate-700">
                Question Type <span class="text-rose-500">*</span>
            </label>
            <?php $currentType = old('question_type', $question['question_type'] ?? 'single'); ?>
            <select name="question_type" id="question_type" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                <option value="single" <?= $currentType === 'single' ? 'selected' : '' ?>>Single Choice (Radio)</option>
                <option value="multiple" <?= $currentType === 'multiple' ? 'selected' : '' ?>>Multiple Choice (Checkbox)</option>
            </select>
        </div>

        <!-- Question Text -->
        <div class="col-span-2 space-y-2">
            <label for="question_text" class="block text-sm font-semibold text-slate-700">
                Question Text <span class="text-rose-500">*</span>
            </label>
            <textarea name="question_text" id="question_text" rows="4" required
                placeholder="Enter the full question prompt here..."
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition"><?= old('question_text', $question['question_text'] ?? ($question['question'] ?? '')) ?></textarea>
        </div>

        <!-- Marks -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="marks" class="block text-sm font-semibold text-slate-700">
                Marks / Weight <span class="text-rose-500">*</span>
            </label>
            <input type="number" name="marks" id="marks" min="1" required
                value="<?= old('marks', $question['marks'] ?? 1) ?>"
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
        </div>

        <!-- Status -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="status" class="block text-sm font-semibold text-slate-700">
                Status
            </label>
            <?php $currentStatus = (int) old('status', $question['status'] ?? 1); ?>
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
                placeholder="Provide reasoning or answer details to display during candidate result review..."
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition"><?= old('explanation', $question['explanation'] ?? '') ?></textarea>
        </div>

    </div>

    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
        <a href="<?= route_to('admin.questions.index') ?>" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
            Cancel
        </a>
        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-600/10 hover:bg-indigo-500 transition active:scale-[0.98]">
            <i class="bx bx-check-circle text-lg"></i>
            <?= isset($question['id']) ? 'Update Question' : 'Save Question' ?>
        </button>
    </div>
</form>