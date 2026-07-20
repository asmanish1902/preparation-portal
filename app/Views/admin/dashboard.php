<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="space-y-8">

    <!-- Dashboard Welcoming & Context Header -->
    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="heading-font text-2xl font-extrabold tracking-tight text-slate-900">
                Performance Overview
            </h1>
            <p class="text-sm text-slate-500">
                Monitor live portal metrics, student engagements, and examination metrics.
            </p>
        </div>

        <!-- Live Timestamp Tracker -->
        <div class="inline-flex items-center gap-2 rounded-xl bg-white border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 shadow-sm">
            <i class="bx bx-refresh text-indigo-500 text-lg animate-spin-slow"></i>
            <span>Live Sync: Active</span>
        </div>
    </div>

    <!-- Advanced Analytics Metrics Grid -->
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

        <!-- Card: Total Students -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-100/50 transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">Total Students</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                    <i class="bx bx-group text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="heading-font text-3xl font-bold tracking-tight text-slate-900">1,248</span>
                <span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">
                    <i class="fa-solid fa-arrow-trend-up text-[10px]"></i>
                    12%
                </span>
            </div>
            <p class="mt-1 text-xs text-slate-400">vs historical baseline past month</p>
        </div>

        <!-- Card: Active Exams -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-100/50 transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">Active Exams</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <i class="bx bx-time-five text-xl animate-pulse"></i>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="heading-font text-3xl font-bold tracking-tight text-slate-900">42</span>
                <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-600">
                    Live Now
                </span>
            </div>
            <p class="mt-1 text-xs text-slate-400">Concurrent active session loads</p>
        </div>

        <!-- Card: Completed Submissions -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-100/50 transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">Submissions Today</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i class="bx bx-file-find text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="heading-font text-3xl font-bold tracking-tight text-slate-900">384</span>
                <span class="inline-flex items-center gap-0.5 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">
                    <i class="fa-solid fa-arrow-trend-up text-[10px]"></i>
                    8.4%
                </span>
            </div>
            <p class="mt-1 text-xs text-slate-400">Evaluated portal submissions</p>
        </div>

        <!-- Card: Average Score Metric -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm shadow-slate-100/50 transition-all hover:shadow-md">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">Average Score</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                    <i class="bx bx-medal text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="heading-font text-3xl font-bold tracking-tight text-slate-900">76.8%</span>
                <span class="inline-flex items-center gap-0.5 rounded-full bg-rose-50 px-2 py-0.5 text-xs font-medium text-rose-700">
                    <i class="fa-solid fa-arrow-trend-down text-[10px]"></i>
                    1.2%
                </span>
            </div>
            <p class="mt-1 text-xs text-slate-400">Cumulative performance cross-portal</p>
        </div>
    </div>

    <!-- Secondary Workspace Information Grid (Charts & Recent Activity) -->
    <div class="grid gap-6 lg:grid-cols-3">

        <!-- Large Analytics Area Blueprint -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h3 class="heading-font font-bold text-slate-800">Registration & Activity Trends</h3>
                <span class="text-xs text-slate-400">Updated hourly</span>
            </div>
            <!-- Interactive Target Workspace for Charts (ApexCharts / Chart.js) -->
            <div class="flex h-64 items-center justify-center rounded-xl border-2 border-dashed border-slate-200 bg-slate-50/50 text-slate-400 gap-2">
                <i class="bx bx-bar-chart-alt-2 text-2xl"></i>
                <p class="text-sm font-medium">Chart execution viewport placeholder</p>
            </div>
        </div>

        <!-- Right Side: Feed/Activity Tracking Node -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm flex flex-col">
            <div class="mb-4">
                <h3 class="heading-font font-bold text-slate-800">Recent System Activities</h3>
            </div>
            <div class="flex-1 space-y-4">
                <!-- Activity Node -->
                <div class="flex gap-3 text-sm">
                    <div class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 shrink-0">
                        <i class="bx bx-plus-circle text-base"></i>
                    </div>
                    <div class="space-y-0.5">
                        <p class="font-medium text-slate-800">New exam published</p>
                        <p class="text-xs text-slate-400">Advanced Backend Node.js Module</p>
                    </div>
                </div>
                <!-- Activity Node -->
                <div class="flex gap-3 text-sm">
                    <div class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 shrink-0">
                        <i class="bx bx-user-plus text-base"></i>
                    </div>
                    <div class="space-y-0.5">
                        <p class="font-medium text-slate-800">Student registration complete</p>
                        <p class="text-xs text-slate-400">User account verified under roll-ID #9482</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<?= $this->endSection() ?>