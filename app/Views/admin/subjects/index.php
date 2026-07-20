<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <!-- Action Header Area -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="heading-font text-2xl font-extrabold tracking-tight text-slate-900">
                Subjects
            </h1>
            <p class="text-sm text-slate-500">
                Manage subject disciplines, codes, and sorting arrangements across the system portal.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <!-- Trash View Anchor Link -->
            <a href="<?= route_to('admin.subjects.trash') ?>"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition active:scale-[0.98]">
                <i class="bx bx-trash text-slate-400 text-lg"></i>
                Trash Bin
            </a>

            <!-- Add Subject Button -->
            <a href="<?= route_to('admin.subjects.create') ?>"
                class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-600/10 hover:bg-indigo-500 transition active:scale-[0.98]">
                <i class="bx bx-plus-circle text-lg"></i>
                Add New Subject
            </a>
        </div>
    </div>

    <!-- Data Container Shell -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-100/40">
        <!-- Render Filters Partial -->
        <?= view('admin/subjects/_filter', ['searchPlaceholder' => 'Search subjects or codes...']) ?>

        <!-- Render Subjects Data Table -->
        <?= view('admin/subjects/_table', ['subjects' => $subjects, 'isTrash' => false]) ?>

        <!-- Pagination Footer -->
        <?php if (isset($pager) && !empty($subjects)): ?>
            <div class="border-t border-slate-200 bg-slate-50/50 px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-slate-500 font-medium">
                    Showing page <?= $pager->getCurrentPage() ?> of <?= max(1, $pager->getPageCount()) ?>
                </div>
                <?php if ($pager->getPageCount() > 1): ?>
                    <div>
                        <?= $pager->only(['search', 'status', 'per_page'])->links('default', 'tailwind_full') ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection() ?>