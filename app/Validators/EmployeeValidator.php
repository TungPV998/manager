<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class EmployeeValidator.
 *
 * @package namespace App\Validators;
 */
class EmployeeValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'ten' => 'required|string|max:255',
            'diachi' => 'required|string|max:255',
            'sodienthoai' => 'required|numeric',
           'img'=>"required|image|mimes:jpeg,png,jpg,gif,svg"
        ],
        ValidatorInterface::RULE_UPDATE => [
            'ten' => 'required|string|max:255',
            'diachi' => 'required|string|max:255',
            'sodienthoai' => 'required|string|max:11|unique:employees,sodienthoai',
            'imgProfile'=>"file|image|mimes:jpeg,png,jpg,gif,svg"
        ],
    ];
    protected $messages = [
        'ten.required' => 'Tên trường không được để trống',
        'diachi.required' => 'Tên trường không được để trống',
        'sodienthoai.required' => 'Tên trường không được để trống',
        'sodienthoai.max' => 'Số điện thoại chỉ được phép tối đa là 11 số',
        'sodienthoai.min' => 'Số điện thoại chỉ được phép tối thiểu là 10 số',
        'ten.string' => 'Tên trường phải là chuoi',
        'sodienthoai.numeric' => 'Tên trường phai la so',
        'img.image' => 'Chỉ được phép là ảnh',
        'imgProfile.required' => 'Anh khong duoc de trong',
        'imgProfile.mimes' => 'Anh chi co dinh dang la jpeg,png,jpg,svg',
        'sodienthoai.unique' => 'Số điên thoại đã bị tồn tại',
    ];
}
