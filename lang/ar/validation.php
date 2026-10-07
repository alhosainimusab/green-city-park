<?php

return [
    'required' => 'حقل :attribute مطلوب.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيحاً.',
    'min' => [
        'string' => 'يجب أن يحتوي :attribute على الأقل :min حرفاً.',
    ],
    'max' => [
        'string' => 'يجب ألا يتجاوز :attribute :max حرفاً.',
    ],
    'unique' => ':attribute مستخدم من قبل.',
    'confirmed' => 'تأكيد :attribute لا يتطابق.',
    'date' => 'يجب أن يكون :attribute تاريخاً صحيحاً.',
    'after_or_equal' => 'يجب أن يكون :attribute بتاريخ مساوٍ أو بعد :date.',
    'integer' => 'يجب أن يكون :attribute عدداً صحيحاً.',
    'min_num' => 'يجب أن يكون :attribute على الأقل :min.',
    'in' => 'القيمة المحددة لـ :attribute غير صالحة.',
    'attributes' => [
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'password' => 'كلمة المرور',
        'phone' => 'الهاتف',
        'visit_date' => 'تاريخ الزيارة',
        'ticket_type' => 'نوع التذكرة',
        'quantity' => 'الكمية',
        'payment_method' => 'طريقة الدفع',
        'reference_no' => 'رقم المرجع',
    ],
];
