<form action="<?= $action ?>" method="<?= $method ?>" class="space-y-6">
    <?= csrf_field() ?>
    <input type="hidden" name="mode" value="batch">

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        <!-- Target Question Dropdown -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="question_id" class="block text-sm font-semibold text-slate-700">
                Select Target Question <span class="text-rose-500">*</span>
            </label>
            <?php
            $selectedQ = (int) old('question_id', $question['id'] ?? ($option['question_id'] ?? 0));
            ?>
            <select name="question_id" id="question_id" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                <option value="">-- Choose Question --</option>
                <?php foreach ($questions as $q): ?>
                    <option value="<?= $q['id'] ?>" <?= $selectedQ === (int) $q['id'] ? 'selected' : '' ?>>
                        #<?= $q['id'] ?> - <?= esc(mb_strimwidth($q['question_text'], 0, 70, '...')) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Global Status -->
        <div class="col-span-2 sm:col-span-1 space-y-2">
            <label for="status" class="block text-sm font-semibold text-slate-700">
                Status
            </label>
            <?php $currentStatus = (int) old('status', $question['status'] ?? ($option['status'] ?? 1)); ?>
            <select name="status" id="status" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                <option value="1" <?= $currentStatus === 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= $currentStatus === 0 ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>

    </div>

    <hr class="border-slate-200 my-4" />

    <!-- Dynamic Options List Container -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-800">
                Answer Choices & Explanations
            </h3>
            <button type="button" id="add-option-btn" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-100 px-3.5 py-2 text-xs font-semibold text-indigo-600 border border-slate-200 hover:bg-indigo-50 hover:border-indigo-200 transition">
                <i class="bx bx-plus text-base"></i> Add Choice
            </button>
        </div>

        <div id="options-container" class="space-y-4">
            <?php
            // 🟢 Fix: Prioritize old post submission data, then existing options array, then default empty choices
            $rowsToRender = old('options', $oldOptions ?? (isset($option) && !empty($option) ? [$option] : [
                ['option_text' => '', 'is_correct' => 1, 'explanation' => ''],
                ['option_text' => '', 'is_correct' => 0, 'explanation' => ''],
                ['option_text' => '', 'is_correct' => 0, 'explanation' => ''],
                ['option_text' => '', 'is_correct' => 0, 'explanation' => ''],
            ]));
            ?>

            <?php foreach ($rowsToRender as $index => $row): ?>
                <div class="option-row relative rounded-2xl border border-slate-200 bg-slate-50/50 p-4 transition space-y-3">

                    <!-- Hidden ID input for updates -->
                    <?php if (!empty($row['id'])): ?>
                        <input type="hidden" name="options[<?= $index ?>][id]" value="<?= $row['id'] ?>">
                    <?php endif; ?>

                    <div class="flex items-center justify-between gap-3">
                        <span class="option-number font-mono text-xs font-bold text-slate-400 uppercase tracking-wider">
                            Choice #<?= $index + 1 ?>
                        </span>
                        <button type="button" class="remove-row-btn text-slate-400 hover:text-rose-500 transition p-1" title="Remove choice">
                            <i class="bx bx-trash text-lg"></i>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                        <!-- Option Text -->
                        <div class="md:col-span-8">
                            <input type="text" name="options[<?= $index ?>][option_text]" required
                                value="<?= esc($row['option_text'] ?? '') ?>"
                                placeholder="Enter choice text..."
                                class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                        </div>

                        <!-- Is Correct Choice -->
                        <div class="md:col-span-4">
                            <select name="options[<?= $index ?>][is_correct]" required class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                                <option value="0" <?= ((int) ($row['is_correct'] ?? 0)) === 0 ? 'selected' : '' ?>>Incorrect Choice</option>
                                <option value="1" <?= ((int) ($row['is_correct'] ?? 0)) === 1 ? 'selected' : '' ?>>Correct Answer</option>
                            </select>
                        </div>

                        <!-- Explanation -->
                        <div class="md:col-span-12">
                            <input type="text" name="options[<?= $index ?>][explanation]"
                                value="<?= esc($row['explanation'] ?? '') ?>"
                                placeholder="Optional explanation for this choice..."
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 text-xs text-slate-600 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Submit Section -->
    <div class="flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
        <a href="<?= route_to('admin.options.index') ?>" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition">
            Cancel
        </a>
        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-600/10 hover:bg-indigo-500 transition active:scale-[0.98]">
            <i class="bx bx-check-circle text-lg"></i>
            Save Options
        </button>
    </div>
</form>

<!-- Vanilla JS for Dynamic Row Management -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('options-container');
        const addBtn = document.getElementById('add-option-btn');

        function updateRowNumbers() {
            const rows = container.querySelectorAll('.option-row');
            rows.forEach((row, idx) => {
                const numLabel = row.querySelector('.option-number');
                if (numLabel) numLabel.textContent = 'Choice #' + (idx + 1);

                row.querySelectorAll('input, select').forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace(/options\[\d+\]/, 'options[' + idx + ']'));
                    }
                });
            });
        }

        addBtn.addEventListener('click', function() {
            const rowCount = container.querySelectorAll('.option-row').length;
            const template = `
            <div class="option-row relative rounded-2xl border border-slate-200 bg-slate-50/50 p-4 transition space-y-3">
                <div class="flex items-center justify-between gap-3">
                    <span class="option-number font-mono text-xs font-bold text-slate-400 uppercase tracking-wider">
                        Choice #${rowCount + 1}
                    </span>
                    <button type="button" class="remove-row-btn text-slate-400 hover:text-rose-500 transition p-1" title="Remove choice">
                        <i class="bx bx-trash text-lg"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                    <div class="md:col-span-8">
                        <input type="text" name="options[${rowCount}][option_text]" required
                               placeholder="Enter choice text..."
                               class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                    </div>

                    <div class="md:col-span-4">
                        <select name="options[${rowCount}][is_correct]" required class="w-full rounded-xl border border-slate-300 bg-white px-3.5 py-2 text-sm text-slate-900 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                            <option value="0">Incorrect Choice</option>
                            <option value="1">Correct Answer</option>
                        </select>
                    </div>

                    <div class="md:col-span-12">
                        <input type="text" name="options[${rowCount}][explanation]"
                               placeholder="Optional explanation for this choice..."
                               class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-1.5 text-xs text-slate-600 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition">
                    </div>
                </div>
            </div>
            `;
            container.insertAdjacentHTML('beforeend', template);
            updateRowNumbers();
        });

        container.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.remove-row-btn');
            if (removeBtn) {
                const rows = container.querySelectorAll('.option-row');
                if (rows.length <= 1) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Action Denied',
                            text: 'At least one option row must remain.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500
                        });
                    } else {
                        alert('At least one option row must remain.');
                    }
                    return;
                }
                removeBtn.closest('.option-row').remove();
                updateRowNumbers();
            }
        });
    });
</script>