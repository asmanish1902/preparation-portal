<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-full">

    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="<?= route_to('admin.options.index') ?>" class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50" title="Back to list">
                <i class="bx bx-left-arrow-alt text-xl"></i>
            </a>
            <div>
                <h1 class="heading-font text-2xl font-extrabold tracking-tight text-slate-900">
                    Batch Create Options
                </h1>
                <p class="text-sm text-slate-500">
                    Rapidly add multiple choices and answer rationale for a single targeted exam question.
                </p>
            </div>
        </div>

        <a href="<?= route_to('admin.options.createSingle') ?>" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">
            Switch to single choice creation <i class="bx bx-right-arrow-alt text-base"></i>
        </a>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm shadow-slate-100/40">
        <?= view('admin/options/_batch_form', [
            'option'    => $option ?? null,
            'questions' => $questions,
            'action'    => route_to('admin.options.store'),
            'method'    => 'POST',
        ]) ?>
    </div>

</div>
<?= $this->endSection() ?>