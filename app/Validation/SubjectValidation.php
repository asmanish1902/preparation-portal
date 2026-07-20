<?php

namespace App\Validation;

class SubjectValidation
{
    public static function rules(?int $id = null): array
    {
        return [
            'name'       => "required|min_length[2]|max_length[255]|is_unique[subjects.name,id,{$id}]",
            'code'       => "permit_empty|max_length[50]|is_unique[subjects.code,id,{$id}]",
            'sort_order' => 'required|integer|greater_than_equal_to[0]',
            'status'     => 'required|in_list[0,1]',
        ];
    }
}
