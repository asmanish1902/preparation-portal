<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="heading-font text-2xl font-extrabold tracking-tight text-slate-900">
                Question Bank
            </h1>
            <p class="text-sm text-slate-500">
                Manage reusable examination questions, point weightings, and explanations.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="<?= route_to('admin.questions.trash') ?>"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition active:scale-[0.98]">
                <i class="bx bx-trash text-slate-400 text-lg"></i>
                Trash Bin
            </a>

            <a href="<?= route_to('admin.questions.create') ?>"
                class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-600/10 hover:bg-indigo-500 transition active:scale-[0.98]">
                <i class="bx bx-plus-circle text-lg"></i>
                Add New Question
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-100/40">
        <?= view('admin/questions/_filter', [
            'searchPlaceholder' => 'Search question text or explanation...',
            'exams'             => $exams,
        ]) ?>

        <?= view('admin/questions/_table', ['questions' => $questions, 'isTrash' => false]) ?>

        <?php if (isset($pager) && !empty($questions)): ?>
            <div class="border-t border-slate-200 bg-slate-50/50 px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-slate-500 font-medium">
                    Showing page <?= $pager->getCurrentPage() ?> of <?= max(1, $pager->getPageCount()) ?>
                </div>
                <?php if ($pager->getPageCount() > 1): ?>
                    <div>
                        <?= $pager->only(['search', 'status', 'exam_id', 'per_page'])->links('default', 'tailwind_full') ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection() ?>