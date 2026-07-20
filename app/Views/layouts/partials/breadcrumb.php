<nav class="flex mb-6" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 text-sm font-medium text-slate-500">
        <li class="inline-flex items-center">
            <a href="<?= route_to('admin.dashboard') ?>" class="inline-flex items-center gap-1.5 hover:text-indigo-600 transition-colors">
                <i data-lucide="layout-dashboard" class="w-4 h-4 text-slate-400"></i>
                Dashboard
            </a>
        </li>
        <?php if (isset($segments) && is_array($segments)): ?>
            <?php foreach ($segments as $name => $url): ?>
                <li class="flex items-center gap-2">
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                    <?php if ($url): ?>
                        <a href="<?= $url ?>" class="hover:text-indigo-600 transition-colors"><?= esc($name) ?></a>
                    <?php else: ?>
                        <span class="text-slate-800 font-semibold select-none" aria-current="page"><?= esc($name) ?></span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ol>
</nav>