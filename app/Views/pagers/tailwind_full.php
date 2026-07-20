<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Pagination" class="inline-flex items-center gap-1">
    <!-- First Page -->
    <?php if ($pager->hasPrevious()) : ?>
        <a href="<?= $pager->getFirst() ?>" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition" title="First Page">
            <i class="bx bx-chevrons-left text-lg"></i>
        </a>
    <?php endif ?>

    <!-- Previous Page -->
    <?php if ($pager->hasPreviousPage()) : ?>
        <a href="<?= $pager->getPreviousPage() ?>" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition" title="Previous Page">
            <i class="bx bx-chevron-left text-lg"></i>
        </a>
    <?php endif ?>

    <!-- Page Links -->
    <?php foreach ($pager->links() as $link) : ?>
        <a href="<?= $link['uri'] ?>"
            class="inline-flex h-9 min-w-[36px] px-2.5 items-center justify-center rounded-lg border text-xs font-semibold transition <?= $link['active'] ? 'border-indigo-600 bg-indigo-600 text-white shadow-sm' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50' ?>">
            <?= $link['title'] ?>
        </a>
    <?php endforeach ?>

    <!-- Next Page -->
    <?php if ($pager->hasNextPage()) : ?>
        <a href="<?= $pager->getNextPage() ?>" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition" title="Next Page">
            <i class="bx bx-chevron-right text-lg"></i>
        </a>
    <?php endif ?>

    <!-- Last Page -->
    <?php if ($pager->hasNext()) : ?>
        <a href="<?= $pager->getLast() ?>" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition" title="Last Page">
            <i class="bx bx-chevrons-right text-lg"></i>
        </a>
    <?php endif ?>
</nav>