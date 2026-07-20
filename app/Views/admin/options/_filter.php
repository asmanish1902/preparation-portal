<div class="border-b border-slate-200 bg-slate-50/50 p-4">
    <form action="<?= current_url() ?>" method="get" class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">

        <div class="relative flex-1 max-w-md">
            <i class="bx bx-search text-slate-400 text-lg absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            <input
                type="text"
                name="search"
                value="<?= esc(request()->getGet('search') ?? '') ?>"
                placeholder="<?= esc($searchPlaceholder ?? 'Search options...') ?>"
                class="w-full rounded-xl border border-slate-300/80 bg-white pl-10 pr-4 py-2 text-sm text-slate-900 transition placeholder:text-slate-400 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <?php if (!empty($questions)): ?>
                <div class="relative max-w-xs">
                    <?php $currentQ = request()->getGet('question_id'); ?>
                    <select name="question_id" onchange="this.form.submit()" class="appearance-none rounded-xl border border-slate-300/80 bg-white pl-3.5 pr-8 py-2 text-sm text-slate-700 transition outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                        <option value="">All Questions</option>
                        <?php foreach ($questions as $q): ?>
                            <option value="<?= $q['id'] ?>" <?= (string) $currentQ === (string) $q['id'] ? 'selected' : '' ?>>
                                #<?= $q['id'] ?> - <?= esc(character_limiter($q['question_text'], 30)) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <i class="bx bx-chevron-down text-slate-400 text-base absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>
            <?php endif; ?>

            <!-- Correctness Filter -->
            <div class="relative">
                <?php $currentCorrect = request()->getGet('is_correct'); ?>
                <select name="is_correct" onchange="this.form.submit()" class="appearance-none rounded-xl border border-slate-300/80 bg-white pl-3.5 pr-8 py-2 text-sm text-slate-700 transition outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                    <option value="">All Choices</option>
                    <option value="1" <?= $currentCorrect === '1' ? 'selected' : '' ?>>Correct Answers</option>
                    <option value="0" <?= $currentCorrect === '0' ? 'selected' : '' ?>>Incorrect Choices</option>
                </select>
                <i class="bx bx-chevron-down text-slate-400 text-base absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            </div>

            <!-- Status Filter -->
            <div class="relative">
                <?php $currentStatus = request()->getGet('status'); ?>
                <select name="status" onchange="this.form.submit()" class="appearance-none rounded-xl border border-slate-300/80 bg-white pl-3.5 pr-8 py-2 text-sm text-slate-700 transition outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                    <option value="">All Statuses</option>
                    <option value="1" <?= $currentStatus === '1' ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= $currentStatus === '0' ? 'selected' : '' ?>>Inactive</option>
                </select>
                <i class="bx bx-chevron-down text-slate-400 text-base absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            </div>

            <!-- Per Page -->
            <div class="relative">
                <?php $currentPerPage = (int) (request()->getGet('per_page') ?: 10); ?>
                <select name="per_page" onchange="this.form.submit()" class="appearance-none rounded-xl border border-slate-300/80 bg-white pl-3.5 pr-8 py-2 text-sm text-slate-700 transition outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10">
                    <option value="10" <?= $currentPerPage === 10 ? 'selected' : '' ?>>10 per page</option>
                    <option value="15" <?= $currentPerPage === 15 ? 'selected' : '' ?>>15 per page</option>
                    <option value="25" <?= $currentPerPage === 25 ? 'selected' : '' ?>>25 per page</option>
                    <option value="50" <?= $currentPerPage === 50 ? 'selected' : '' ?>>50 per page</option>
                </select>
                <i class="bx bx-chevron-down text-slate-400 text-base absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            </div>

            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-800 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-700 transition active:scale-[0.98]">
                <i class="bx bx-filter-alt"></i>
                Filter
            </button>

            <?php
            $hasSearch  = !empty(request()->getGet('search'));
            $hasStatus  = $currentStatus !== null && $currentStatus !== '';
            $hasQ       = !empty(request()->getGet('question_id'));
            $hasCorrect = $currentCorrect !== null && $currentCorrect !== '';
            ?>
            <?php if ($hasSearch || $hasStatus || $hasQ || $hasCorrect): ?>
                <a href="<?= current_url() ?>" class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white p-2 text-slate-500 hover:bg-slate-50 transition" title="Clear Filters">
                    <i class="bx bx-x text-lg"></i>
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>