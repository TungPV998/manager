<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class DepartmentValidator.
 *
 * @package namespace App\Validators;
 */
class DepartmentValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'txtPhongBan' => 'string|max:255|unique:departments,tenphongban'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'txtPhongBan' => 'string|max:255|unique:departments,tenphongban'
        ],
    ];
    protected $messages = [
        'txtPhongBan.required' => 'Tên trường không được để trống',
        'txtPhongBan.string' => 'Tên trường phải là chữ',
        'txtPhongBan.unique' => 'Tên trường đã tồn tại',
    ];
}
