<div class="overflow-x-auto">
    <table class="w-full text-left text-sm text-slate-600">
        <thead class="bg-slate-50/80 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
            <tr>
                <th class="px-6 py-4">Option Choice</th>
                <th class="px-6 py-4">Question Prompt</th>
                <th class="px-6 py-4">Is Correct</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            <?php if (empty($options)): ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                        <i class="bx bx-folder-open text-4xl mb-2"></i>
                        <p class="font-medium">No options found.</p>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($options as $opt): ?>
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 max-w-xs md:max-w-md">
                            <div class="font-semibold text-slate-900 line-clamp-2"><?= esc($opt['option_text']) ?></div>
                            <?php if (!empty($opt['explanation'])): ?>
                                <div class="text-xs text-slate-400 line-clamp-1 mt-0.5"><?= esc($opt['explanation']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <div class="text-xs text-slate-700 line-clamp-2 font-medium">
                                #<?= $opt['question_id'] ?> - <?= esc($opt['question_text'] ?? 'Unassigned') ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ((int) $opt['is_correct'] === 1): ?>
                                <span class="inline-flex items-center gap-1 rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 border border-emerald-200/60">
                                    <i class="bx bx-check-circle"></i> Correct
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1 rounded-md bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600 border border-slate-200">
                                    <i class="bx bx-x-circle"></i> Incorrect
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ((int) $opt['status'] === 1): ?>
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
                            <?= view('admin/options/_actions', ['option' => $opt, 'isTrash' => $isTrash ?? false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>