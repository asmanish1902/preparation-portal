<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-slate-200 text-sm">
        <thead class="bg-slate-50/70 heading-font">
            <tr>
                <th scope="col" class="w-16 px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider">ID</th>
                <th scope="col" class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider">Name</th>
                <th scope="col" class="px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider">Slug</th>
                <th scope="col" class="w-32 px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider">Status</th>
                <th scope="col" class="w-32 px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider">Sort Order</th>
                <th scope="col" class="w-40 px-6 py-4 text-left font-bold text-slate-500 uppercase tracking-wider">Created</th>
                <th scope="col" class="w-28 px-6 py-4 text-center font-bold text-slate-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
            <?php if (! empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <tr class="transition-colors duration-150 hover:bg-slate-50/60">
                        <td class="whitespace-nowrap px-6 py-4 font-mono text-xs font-semibold text-slate-400">
                            #<?= esc($category['id']) ?>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-semibold text-slate-900">
                            <?= esc($category['name']) ?>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-mono text-xs text-slate-500 bg-slate-50/30">
                            <?= esc($category['slug']) ?>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <?php if ($category['status'] == 1): ?>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-600/10">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600 ring-1 ring-inset ring-slate-500/10">
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                    Inactive
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-medium text-slate-600">
                            <span class="inline-flex items-center gap-1 text-xs px-2 py-0.5 rounded-lg border border-slate-200 bg-slate-50 font-mono">
                                <i class="bx bx-sort text-slate-400"></i>
                                <?= esc($category['sort_order']) ?>
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-slate-500 text-xs">
                            <?= date('d M Y', strtotime($category['created_at'])) ?>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 text-center">
                            <?= view('admin/categories/_actions', [
                                'category' => $category,
                                'isTrash'  => $isTrash ?? false,
                            ]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-50 border border-slate-100 text-slate-400">
                                <i class="bx bx-folder-open text-2xl"></i>
                            </div>
                            <div class="space-y-0.5">
                                <p class="font-semibold text-slate-800">No categories found</p>
                                <p class="text-xs text-slate-400">Try adjusting your filters or search query.</p>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>