<?php

namespace App\Validation;

class CategoryValidation
{
    /**
     * Common base rules shared across create and update actions.
     */
    private static function baseRules(): array
    {
        return [
            'description' => [
                'label' => 'Description',
                'rules' => 'permit_empty|max_length[500]',
            ],
            'sort_order' => [
                'label' => 'Sort Order',
                'rules' => 'permit_empty|integer|greater_than_equal_to[0]',
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'required|in_list[0,1]',
            ],
        ];
    }

    /**
     * Validation rules for creating a category.
     */
    public static function create(): array
    {
        return array_merge(self::baseRules(), [
            'name' => [
                'label' => 'Category Name',
                'rules' => 'required|min_length[3]|max_length[150]|is_unique[categories.name,id,{id},deleted_at,NULL]',
            ],
        ]);
    }

    /**
     * Validation rules for updating a category.
     */
    public static function update(int $id): array
    {
        return array_merge(self::baseRules(), [
            'name' => [
                'label' => 'Category Name',
                'rules' => "required|min_length[3]|max_length[150]|is_unique[categories.name,id,{$id}]",
            ],
        ]);
    }

    /**
     * Custom validation messages.
     */
    public static function messages(): array
    {
        return [
            'name' => [
                'required'  => 'Category name is required.',
                'is_unique' => 'Category already exists.',
            ],
            'sort_order' => [
                'integer' => 'Sort order must be a valid number.',
            ],
            'status' => [
                'required' => 'Please select a status.',
            ],
        ];
    }
}
