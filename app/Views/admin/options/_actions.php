<div class="flex items-center justify-center gap-1.5">
    <?php if (isset($isTrash) && $isTrash): ?>
        <!-- Restore Option -->
        <form action="<?= route_to('admin.options.restore', $option['id']) ?>" method="post" class="inline-block">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PATCH">
            <button type="submit"
                class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-600"
                title="Restore Option">
                <i class="bx bx-undo text-base"></i>
            </button>
        </form>

        <!-- Force Delete Option -->
        <form action="<?= route_to('admin.options.forceDelete', $option['id']) ?>" method="post" class="inline-block" onsubmit="return confirmForceDelete(event)">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit"
                class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600"
                title="Delete Permanently">
                <i class="bx bx-trash-alt text-base"></i>
            </button>
        </form>
    <?php else: ?>
        <!-- Single Edit Button -->
        <a href="<?= route_to('admin.options.edit', $option['id']) ?>"
            class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-600"
            title="Edit Single Option">
            <i class="bx bx-edit-alt text-base"></i>
        </a>

        <!-- Batch Edit Question Choices Button -->
        <a href="<?= route_to('admin.options.editBatch', $option['question_id']) ?>"
            class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-amber-200 hover:bg-amber-50 hover:text-amber-600"
            title="Batch Edit All Choices for Question #<?= $option['question_id'] ?>">
            <i class="bx bx-layer text-base"></i>
        </a>

        <!-- Soft Delete Button -->
        <form action="<?= route_to('admin.options.delete', $option['id']) ?>" method="post" class="inline-block" onsubmit="return confirmSoftDelete(event)">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit"
                class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600"
                title="Move to Trash">
                <i class="bx bx-trash text-base"></i>
            </button>
        </form>
    <?php endif; ?>
</div>