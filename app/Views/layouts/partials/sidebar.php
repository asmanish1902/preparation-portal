<?php
$current_url = current_url(true)->getPath();
$isActive    = fn(string $segment) => str_contains($current_url, $segment);
?>

<!-- Backdrop for Mobile -->
<div x-show="sidebarOpen"
    @click="sidebarOpen = false"
    x-transition.opacity
    class="fixed inset-0 z-20 bg-slate-900/50 lg:hidden"></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed lg:static inset-y-0 left-0 z-30 w-64 bg-slate-900 text-slate-300 flex flex-col shrink-0 border-r border-slate-800 transition-transform duration-200 ease-in-out">

    <!-- Brand Space -->
    <div class="h-16 flex items-center gap-2.5 px-6 border-b border-slate-800 bg-slate-950/40">
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-tr from-indigo-600 to-violet-500 shadow-md">
            <i class="fa-solid fa-graduation-cap text-white text-sm"></i>
        </div>
        <span class="heading-font text-base font-bold tracking-tight text-white">
            Test<span class="text-indigo-400">Portal</span>
        </span>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 space-y-1 px-4 py-6 overflow-y-auto">
        <!-- Dashboard -->
        <a href="<?= route_to('admin.dashboard') ?>"
            class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 <?= $isActive('dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'hover:bg-slate-800/60 hover:text-white' ?>">
            <i class="bx bxs-dashboard text-xl"></i>
            Dashboard
        </a>

        <!-- Categories -->
        <a href="<?= route_to('admin.categories.index') ?>"
            class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 <?= $isActive('categories') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'hover:bg-slate-800/60 hover:text-white' ?>">
            <i class="bx bx-category text-xl"></i>
            Categories
        </a>

        <!-- Subjects -->
        <a href="<?= route_to('admin.subjects.index') ?>"
            class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 <?= $isActive('subjects') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'hover:bg-slate-800/60 hover:text-white' ?>">
            <i class="bx bx-category text-xl"></i>
            Subjects
        </a>

        <!-- Exams -->
        <a href="<?= route_to('admin.exams.index') ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 <?= $isActive('exams') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'hover:bg-slate-800/60 hover:text-white' ?>">
            <i class="bx bx-file text-xl"></i>
            Exams
        </a>

        <!-- Questions -->
        <a href="<?= route_to('admin.questions.index') ?>" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 <?= $isActive('questions') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/10' : 'hover:bg-slate-800/60 hover:text-white' ?>">
            <i class="bx bx-help-circle text-xl"></i>
            Questions
        </a>

        <!-- Students -->
        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-slate-800/60 hover:text-white">
            <i class="bx bx-user text-xl"></i>
            Students
        </a>

        <!-- Reports -->
        <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 hover:bg-slate-800/60 hover:text-white">
            <i class="bx bx-bar-chart-alt-2 text-xl"></i>
            Reports
        </a>
    </nav>
</aside>