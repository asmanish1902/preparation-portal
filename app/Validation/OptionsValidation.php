<?php

namespace App\Validation;

class OptionsValidation
{
    /**
     * Rules for creating/updating a single option
     */
    public static function singleRules(): array
    {
        return [
            'question_id' => [
                'rules'  => 'required|is_natural_no_zero|is_not_unique[questions.id,id]',
                'errors' => [
                    'required'           => 'Target question selection is required.',
                    'is_natural_no_zero' => 'Please select a valid target question.',
                    'is_not_unique'      => 'The selected question does not exist.',
                ],
            ],
            'option_text' => [
                'rules'  => 'required|string|min_length[1]|max_length[2000]',
                'errors' => [
                    'required'   => 'Option text is required.',
                    'min_length' => 'Option text must contain at least 1 character.',
                    'max_length' => 'Option text cannot exceed 2000 characters.',
                ],
            ],
            'is_correct' => [
                'rules'  => 'required|in_list[0,1]',
                'errors' => [
                    'required' => 'Correct choice designation is required.',
                    'in_list'  => 'Correct status must be either 1 or 0.',
                ],
            ],
            'explanation' => [
                'rules'  => 'permit_empty|string|max_length[2000]',
                'errors' => [
                    'max_length' => 'Explanation text cannot exceed 2000 characters.',
                ],
            ],
            'status' => [
                'rules'  => 'required|in_list[0,1]',
                'errors' => [
                    'required' => 'Status selection is required.',
                    'in_list'  => 'Status must be Active (1) or Inactive (0).',
                ],
            ],
        ];
    }

    /**
     * Rules for batch creating/updating multiple options
     */
    public static function batchRules(): array
    {
        return [
            'question_id' => [
                'rules'  => 'required|is_natural_no_zero|is_not_unique[questions.id,id]',
                'errors' => [
                    'required'           => 'Target question selection is required.',
                    'is_natural_no_zero' => 'Please select a valid target question.',
                    'is_not_unique'      => 'The selected question does not exist.',
                ],
            ],
            // 🟢 FIXED: Removed min_length[1] rule for array
            'options' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Please add at least one option choice.',
                ],
            ],
            'options.*.id' => [
                'rules' => 'permit_empty|is_natural_no_zero',
            ],
            'options.*.option_text' => [
                'rules'  => 'required|string|min_length[1]|max_length[2000]',
                'errors' => [
                    'required'   => 'Option text is required for all choices.',
                    'min_length' => 'Option text must contain at least 1 character.',
                    'max_length' => 'Option text cannot exceed 2000 characters.',
                ],
            ],
            'options.*.is_correct' => [
                'rules'  => 'required|in_list[0,1]',
                'errors' => [
                    'required' => 'Correct choice designation is required.',
                    'in_list'  => 'Correct choice value must be 0 or 1.',
                ],
            ],
            'options.*.explanation' => [
                'rules'  => 'permit_empty|string|max_length[2000]',
                'errors' => [
                    'max_length' => 'Explanation cannot exceed 2000 characters.',
                ],
            ],
            'status' => [
                'rules'  => 'required|in_list[0,1]',
                'errors' => [
                    'required' => 'Status selection is required.',
                    'in_list'  => 'Status must be Active (1) or Inactive (0).',
                ],
            ],
        ];
    }
}
