<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-full">

    <!-- Page Header -->
    <div class="flex items-center gap-3">
        <a href="<?= route_to('admin.options.index') ?>" class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50">
            <i class="bx bx-left-arrow-alt text-xl"></i>
        </a>
        <div>
            <h1 class="heading-font text-2xl font-extrabold tracking-tight text-slate-900">
                Batch Edit Options for Question #<?= esc($question['id']) ?>
            </h1>
            <p class="text-sm text-slate-500">Manage, re-order, or add multiple choice responses simultaneously.</p>
        </div>
    </div>

    <!-- Target Question Card Banner -->
    <div class="rounded-2xl border border-indigo-100 bg-indigo-50/50 p-4 sm:p-5">
        <div class="flex items-start gap-3">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-indigo-600 text-white font-bold text-xs shadow-sm">
                #<?= esc($question['id']) ?>
            </div>
            <div class="space-y-1">
                <span class="text-xs font-semibold uppercase tracking-wider text-indigo-600">Target Question</span>
                <p class="text-sm font-medium text-slate-800 leading-relaxed">
                    <?= esc($question['question_text']) ?>
                </p>
            </div>
        </div>
    </div>

    <!-- Form Card Container -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
        <?= view('admin/options/_batch_form', [
            'question'   => $question,
            'option'     => ['question_id' => $question['id'], 'status' => $question['status'] ?? 1],
            'oldOptions' => $oldOptions,
            'questions'  => $questions,
            'action'     => route_to('admin.options.updateBatch', $question['id']),
            'method'     => 'POST',
        ]) ?>
    </div>

</div>
<?= $this->endSection() ?>