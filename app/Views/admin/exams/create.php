<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6 max-w-full">

    <!-- Section Context Header -->
    <div class="flex items-center gap-3">
        <a href="<?= route_to('admin.exams.index') ?>" class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50" title="Back to list">
            <i class="bx bx-left-arrow-alt text-xl"></i>
        </a>
        <div>
            <h1 class="heading-font text-2xl font-extrabold tracking-tight text-slate-900">
                Create New Exam
            </h1>
            <p class="text-sm text-slate-500">
                Setup exam parameters, duration, score thresholds, and target subjects.
            </p>
        </div>
    </div>

    <!-- Premium Card Workspace Shell -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm shadow-slate-100/40">
        <?= view('admin/exams/_form', [
            'exam'       => $exam ?? null,
            'categories' => $categories,
            'subjects'   => $subjects,
            'action'     => route_to('admin.exams.store'),
            'method'     => 'POST',
        ]) ?>
    </div>

</div>
<?= $this->endSection() ?>