<div class="overflow-x-auto">
    <table class="w-full text-left text-sm text-slate-600">
        <thead class="bg-slate-50/80 text-xs uppercase font-semibold text-slate-500 border-b border-slate-200">
            <tr>
                <th class="px-6 py-4">Sort</th>
                <th class="px-6 py-4">Subject Name</th>
                <th class="px-6 py-4">Slug</th>
                <th class="px-6 py-4">Code</th>
                <th class="px-6 py-4">Status</th>
                <th class="px-6 py-4">Created At</th>
                <th class="px-6 py-4">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
            <?php if (empty($subjects)): ?>
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                        <i class="bx bx-folder-open text-4xl mb-2"></i>
                        <p class="font-medium">No subjects found.</p>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($subjects as $subject): ?>
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 font-mono text-xs text-slate-400">
                            #<?= esc($subject['sort_order']) ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-900"><?= esc($subject['name']) ?></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs text-slate-400 font-mono"><?= esc($subject['slug']) ?></div>
                        </td>
                        <td class="px-6 py-4">
                            <?php if (!empty($subject['code'])): ?>
                                <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-mono font-medium text-slate-600 border border-slate-200">
                                    <?= esc($subject['code']) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-xs text-slate-400">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ($subject['status'] == 1): ?>
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
                        <td class="whitespace-nowrap px-6 py-4 text-slate-500 text-xs">
                            <?= date('d M Y', strtotime($subject['created_at'])) ?>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-center">
                            <?= view('admin/subjects/_actions', [
                                'subject' => $subject,
                                'isTrash'  => $isTrash ?? false,
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>