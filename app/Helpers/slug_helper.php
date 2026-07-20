<?php

use App\Models\CategoryModel;

if (! function_exists('generate_slug')) {

    function generate_slug(string $text): string
    {
        helper('text');
        return url_title(trim($text), '-', true);
    }
}

if (! function_exists('generate_unique_category_slug')) {

    function generate_unique_category_slug(
        CategoryModel $model,
        string $name,
        ?int $ignoreId = null
    ): string {

        $slug = generate_slug($name);
        $original = $slug;
        $counter = 1;

        while (true) {

            $builder = $model->where('slug', $slug);

            if ($ignoreId !== null) {
                $builder->where('id !=', $ignoreId);
            }

            if (! $builder->first()) {
                break;
            }

            $slug = "{$original}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
