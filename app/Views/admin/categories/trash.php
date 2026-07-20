<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <!-- Action Header Area -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-3">
            <a href="<?= route_to('admin.categories.index') ?>" class="flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50" title="Back to categories">
                <i class="bx bx-left-arrow-alt text-xl"></i>
            </a>
            <div>
                <h1 class="heading-font text-2xl font-extrabold tracking-tight text-slate-900">
                    Trashed Categories
                </h1>
                <p class="text-sm text-slate-500">
                    Restore soft-deleted categories or permanently delete them from the database.
                </p>
            </div>
        </div>
    </div>

    <!-- Workspace Container -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm shadow-slate-100/40">
        <!-- Render Filters -->
        <?= view('admin/categories/_filters') ?>

        <!-- Render Table with Trash Flag Enabled -->
        <?= view('admin/categories/_table', [
            'categories' => $categories,
            'isTrash'    => true,
        ]) ?>

        <?php if (isset($pager) && $pager->getPageCount() > 1): ?>
            <div class="border-t border-slate-200 bg-slate-50/50 px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-slate-500 font-medium">
                    Showing page <?= $pager->getCurrentPage() ?> of <?= $pager->getPageCount() ?>
                </div>
                <div>
                    <?= $pager->only(['search', 'status', 'per_page'])->links('default', 'tailwind_full') ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

</div>
<?= $this->endSection() ?>