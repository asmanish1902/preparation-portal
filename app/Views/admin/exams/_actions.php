<div class="flex items-center justify-center gap-1.5">
    <?php if (isset($isTrash) && $isTrash): ?>
        <!-- Restore Button -->
        <form action="<?= route_to('admin.exams.restore', $exam['id']) ?>" method="post" class="inline-block">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PATCH">
            <button type="submit"
                class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-600"
                title="Restore Exam">
                <i class="bx bx-undo text-base"></i>
            </button>
        </form>

        <!-- Permanent Delete Button -->
        <form action="<?= route_to('admin.exams.forceDelete', $exam['id']) ?>" method="post" class="inline-block" onsubmit="return confirmForceDelete(event)">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit"
                class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600"
                title="Delete Permanently">
                <i class="bx bx-trash-alt text-base"></i>
            </button>
        </form>
    <?php else: ?>
        <!-- Edit Button -->
        <a href="<?= route_to('admin.exams.edit', $exam['id']) ?>"
            class="flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:border-indigo-200 hover:bg-indigo-50 hover:text-indigo-600"
            title="Edit Exam">
            <i class="bx bx-edit-alt text-base"></i>
        </a>

        <!-- Soft Delete Button -->
        <form action="<?= route_to('admin.exams.delete', $exam['id']) ?>" method="post" class="inline-block" onsubmit="return confirmSoftDelete(event)">
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