<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="heading-font text-2xl font-extrabold tracking-tight text-slate-900 flex items-center gap-2">
                <i class="bx bx-trash text-rose-500"></i> Trashed Options
            </h1>
            <p class="text-sm text-slate-500">
                Restore soft-deleted answer choices or purge them permanently.
            </p>
        </div>

        <div>
            <a href="<?= route_to('admin.options.index') ?>"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition active:scale-[0.98]">
                <i class="bx bx-arrow-back text-lg"></i>
                Back to Options
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-100/40">
        <?= view('admin/options/_filter', [
            'searchPlaceholder' => 'Search trashed options...',
            'questions'         => $questions ?? [],
        ]) ?>

        <?= view('admin/options/_table', ['options' => $options, 'isTrash' => true]) ?>

        <?php if (isset($pager) && !empty($options)): ?>
            <div class="border-t border-slate-200 bg-slate-50/50 px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-slate-500 font-medium">
                    Showing trashed page <?= $pager->getCurrentPage() ?> of <?= max(1, $pager->getPageCount()) ?>
                </div>
                <?php if ($pager->getPageCount() > 1): ?>
                    <div>
                        <?= $pager->only(['search', 'status', 'question_id', 'per_page'])->links('default', 'tailwind_full') ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection() ?>