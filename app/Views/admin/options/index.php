<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="heading-font text-2xl font-extrabold tracking-tight text-slate-900">
                Question Options
            </h1>
            <p class="text-sm text-slate-500">
                Manage choice responses, designate correct answers, and provide detailed explanations.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="<?= route_to('admin.options.trash') ?>"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 transition active:scale-[0.98]">
                <i class="bx bx-trash text-slate-400 text-lg"></i>
                Trash Bin
            </a>

            <!-- Quick Add Single Choice -->
            <a href="<?= route_to('admin.options.createSingle') ?>"
                class="inline-flex items-center gap-2 rounded-xl border border-indigo-200 bg-indigo-50/60 px-4 py-2.5 text-sm font-semibold text-indigo-700 shadow-sm hover:bg-indigo-100/80 transition active:scale-[0.98]">
                <i class="bx bx-plus text-lg"></i>
                Add Single Choice
            </a>

            <!-- Batch Add Choices (Default) -->
            <a href="<?= route_to('admin.options.create') ?>"
                class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-indigo-600/10 hover:bg-indigo-500 transition active:scale-[0.98]">
                <i class="bx bx-layer text-lg"></i>
                Batch Add Options
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-100/40">
        <?= view('admin/options/_filter', [
            'searchPlaceholder' => 'Search option text or explanation...',
            'questions'         => $questions,
        ]) ?>

        <?= view('admin/options/_table', ['options' => $options, 'isTrash' => false]) ?>

        <?php if (isset($pager) && !empty($options)): ?>
            <div class="border-t border-slate-200 bg-slate-50/50 px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-slate-500 font-medium">
                    Showing page <?= $pager->getCurrentPage() ?> of <?= max(1, $pager->getPageCount()) ?>
                </div>
                <?php if ($pager->getPageCount() > 1): ?>
                    <div>
                        <?= $pager->only(['search', 'status', 'question_id', 'is_correct', 'per_page'])->links('default', 'tailwind_full') ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection() ?>