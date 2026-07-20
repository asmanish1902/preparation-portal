<div class="overflow-x-auto">
    <table class="w-full text-left text-sm text-slate-600">
        <thead class="bg-slate-50/80 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
            <tr>
                <th class="px-6 py-4">Exam Title</th>
                <th class="px-6 py-4">Category / Subject</th>
                <th class="px-6 py-4">Duration</th>
                <th class="px-6 py-4">Passing Criteria</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            <?php if (empty($exams)): ?>
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <i class="bx bx-folder-open text-4xl mb-2"></i>
                        <p class="font-medium">No exams found.</p>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($exams as $exam): ?>
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-900"><?= esc($exam['title']) ?></div>
                            <div class="text-xs text-slate-400 font-mono"><?= esc($exam['slug']) ?></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1">
                                <span class="inline-flex items-center gap-1 w-fit rounded-md bg-indigo-50 px-2 py-0.5 text-xs font-medium text-indigo-700 border border-indigo-200/60">
                                    <i class="bx bx-folder text-xs"></i> <?= esc($exam['category_name'] ?? 'N/A') ?>
                                </span>
                                <span class="inline-flex items-center gap-1 w-fit rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700 border border-slate-200">
                                    <i class="bx bx-book-open text-xs"></i> <?= esc($exam['subject_name'] ?? 'N/A') ?>
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-700">
                            <i class="bx bx-time-five text-slate-400 align-middle"></i>
                            <?= esc($exam['duration_minutes']) ?> mins
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs text-slate-700">
                                <span class="font-semibold text-emerald-600"><?= esc($exam['pass_mark']) ?></span> / <?= esc($exam['total_marks']) ?> Marks
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ((int) $exam['status'] === 1): ?>
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
                            <?= view('admin/exams/_actions', ['exam' => $exam, 'isTrash' => $isTrash ?? false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>