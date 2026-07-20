<div class="overflow-x-auto">
    <table class="w-full text-left text-sm text-slate-600">
        <thead class="bg-slate-50/80 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
            <tr>
                <th class="px-6 py-4">Question Prompt</th>
                <th class="px-6 py-4">Assigned Exam</th>
                <th class="px-6 py-4">Type</th>
                <th class="px-6 py-4">Marks</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            <?php if (empty($questions)): ?>
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <i class="bx bx-folder-open text-4xl mb-2"></i>
                        <p class="font-medium">No questions found.</p>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($questions as $q): ?>
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 max-w-xs md:max-w-md">
                            <div class="font-semibold text-slate-900 line-clamp-2"><?= esc($q['question_text'] ?? ($q['question'] ?? '')) ?></div>
                            <?php if (!empty($q['explanation'])): ?>
                                <div class="text-xs text-slate-400 line-clamp-1 mt-0.5"><?= esc($q['explanation']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 w-fit rounded-md bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700 border border-indigo-200/60">
                                <i class="bx bx-certification text-xs"></i> <?= esc($q['exam_title'] ?? 'Unassigned') ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <?php if (($q['question_type'] ?? '') === 'single'): ?>
                                <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-0.5 text-xs font-mono font-medium text-slate-700 border border-slate-200">
                                    Single
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-0.5 text-xs font-mono font-medium text-amber-700 border border-amber-200/60">
                                    Multiple
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-800">
                            <?= esc($q['marks']) ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ((int) $q['status'] === 1): ?>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 border border-emerald-200/60">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600 border border-slate-200">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                    Inactive
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?= view('admin/questions/_actions', ['question' => $q, 'isTrash' => $isTrash ?? false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>