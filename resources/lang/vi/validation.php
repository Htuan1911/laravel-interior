<?php

return [
    'accepted' => 'Trường :attribute phải được chấp nhận.',
    'active_url' => 'Trường :attribute không phải là một URL hợp lệ.',
    'after' => 'Trường :attribute phải là một ngày sau :date.',
    'after_or_equal' => 'Trường :attribute phải là một ngày sau hoặc bằng :date.',
    'alpha' => 'Trường :attribute chỉ có thể chứa các chữ cái.',
    'alpha_dash' => 'Trường :attribute chỉ có thể chứa chữ cái, số, dấu gạch ngang và gạch dưới.',
    'alpha_num' => 'Trường :attribute chỉ có thể chứa chữ cái và số.',
    'array' => 'Trường :attribute phải là một mảng.',
    'before' => 'Trường :attribute phải là một ngày trước :date.',
    'before_or_equal' => 'Trường :attribute phải là một ngày trước hoặc bằng :date.',
    'between' => [
        'numeric' => 'Trường :attribute phải nằm trong khoảng :min và :max.',
        'file' => 'Tập tin :attribute phải có dung lượng trong khoảng :min và :max kilobytes.',
        'string' => 'Trường :attribute phải có độ dài từ :min đến :max ký tự.',
        'array' => 'Trường :attribute phải có từ :min đến :max phần tử.',
    ],
    'boolean' => 'Trường :attribute phải là true hoặc false.',
    'confirmed' => 'Giá trị xác nhận :attribute không khớp.',
    'date' => 'Trường :attribute không phải là ngày hợp lệ.',
    'date_equals' => 'Trường :attribute phải là một ngày bằng :date.',
    'date_format' => 'Trường :attribute không đúng định dạng :format.',
    'different' => 'Trường :attribute và :other phải khác nhau.',
    'digits' => 'Trường :attribute phải có :digits chữ số.',
    'digits_between' => 'Trường :attribute phải có từ :min đến :max chữ số.',
    'dimensions' => 'Trường :attribute có kích thước hình ảnh không hợp lệ.',
    'distinct' => 'Trường :attribute có giá trị trùng lặp.',
    'email' => 'Trường :attribute phải là một địa chỉ email hợp lệ.',
    'exists' => 'Giá trị đã chọn của :attribute không hợp lệ.',
    'file' => 'Trường :attribute phải là một tập tin.',
    'filled' => 'Trường :attribute là bắt buộc.',
    'gt' => [
        'numeric' => ':attribute phải lớn hơn :value.',
        'file' => ':attribute phải lớn hơn :value kilobytes.',
        'string' => ':attribute phải lớn hơn :value ký tự.',
        'array' => ':attribute phải có nhiều hơn :value phần tử.',
    ],
    'gte' => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'file' => ':attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'string' => ':attribute phải lớn hơn hoặc bằng :value ký tự.',
        'array' => ':attribute phải có từ :value phần tử trở lên.',
    ],
    'in' => 'Giá trị đã chọn của :attribute không hợp lệ.',
    'in_array' => 'Trường :attribute không tồn tại trong :other.',
    'integer' => 'Trường :attribute phải là số nguyên.',
    'ip' => 'Trường :attribute phải là một địa chỉ IP hợp lệ.',
    'ipv4' => 'Trường :attribute phải là một địa chỉ IPv4 hợp lệ.',
    'ipv6' => 'Trường :attribute phải là một địa chỉ IPv6 hợp lệ.',
    'json' => 'Trường :attribute phải là chuỗi JSON hợp lệ.',
    'lt' => [
        'numeric' => ':attribute phải nhỏ hơn :value.',
        'file' => ':attribute phải nhỏ hơn :value kilobytes.',
        'string' => ':attribute phải nhỏ hơn :value ký tự.',
        'array' => ':attribute phải có ít hơn :value phần tử.',
    ],
    'lte' => [
        'numeric' => ':attribute phải nhỏ hơn hoặc bằng :value.',
        'file' => ':attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
        'string' => ':attribute phải nhỏ hơn hoặc bằng :value ký tự.',
        'array' => ':attribute không được có nhiều hơn :value phần tử.',
    ],
    'max' => [
        'numeric' => 'Trường :attribute không được lớn hơn :max.',
        'file' => 'Tập tin :attribute không được lớn hơn :max kilobytes.',
        'string' => 'Trường :attribute không được lớn hơn :max ký tự.',
        'array' => 'Trường :attribute không được có nhiều hơn :max phần tử.',
    ],
    'min' => [
        'numeric' => 'Trường :attribute phải có ít nhất :min.',
        'file' => 'Tập tin :attribute phải có ít nhất :min kilobytes.',
        'string' => 'Trường :attribute phải có ít nhất :min ký tự.',
        'array' => 'Trường :attribute phải có ít nhất :min phần tử.',
    ],
    'not_in' => 'Giá trị đã chọn của :attribute không hợp lệ.',
    'not_regex' => 'Định dạng của trường :attribute không hợp lệ.',
    'numeric' => 'Trường :attribute phải là một số.',
    'present' => 'Trường :attribute phải được cung cấp.',
    'regex' => 'Định dạng của trường :attribute không hợp lệ.',
    'required' => 'Trường :attribute là bắt buộc.',
    'required_if' => 'Trường :attribute là bắt buộc khi :other là :value.',
    'required_unless' => 'Trường :attribute là bắt buộc trừ khi :other nằm trong :values.',
    'required_with' => 'Trường :attribute là bắt buộc khi có :values.',
    'required_with_all' => 'Trường :attribute là bắt buộc khi có tất cả :values.',
    'required_without' => 'Trường :attribute là bắt buộc khi không có :values.',
    'required_without_all' => 'Trường :attribute là bắt buộc khi không có bất kỳ :values nào.',
    'same' => 'Trường :attribute và :other phải giống nhau.',
    'size' => [
        'numeric' => 'Trường :attribute phải bằng :size.',
        'file' => 'Tập tin :attribute phải có dung lượng :size kilobytes.',
        'string' => 'Trường :attribute phải có độ dài :size ký tự.',
        'array' => 'Trường :attribute phải chứa :size phần tử.',
    ],
    'starts_with' => 'Trường :attribute phải bắt đầu với một trong những giá trị sau: :values.',
    'string' => 'Trường :attribute phải là chuỗi.',
    'timezone' => 'Trường :attribute phải là múi giờ hợp lệ.',
    'unique' => 'Trường :attribute đã có trong hệ thống.',
    'uploaded' => 'Tải lên :attribute thất bại.',
    'url' => 'Định dạng :attribute không hợp lệ.',
    'uuid' => 'Trường :attribute phải là UUID hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    */
    'custom' => [
        'discount_percent' => [
            'both_discount' => 'Không được nhập cả % và số tiền giảm cùng lúc.',
        ],
        'expires_at' => [
            'after' => 'Ngày hết hạn phải sau hôm nay.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */
    'attributes' => [
        'expires_at' => 'ngày hết hạn',
        'discount_percent' => 'phần trăm giảm giá',
        'discount_amount' => 'số tiền giảm giá',
        'name' => 'tên',
        'email' => 'email',
        'password' => 'mật khẩu',
        // Thêm các field khác nếu cần
    ],
];
