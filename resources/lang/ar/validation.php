<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'يجب ان تكون :attribute  مقبولة',
    'active_url' => ' ليس  :attribute رابط صالح.',
    'after' => ' يجب ان يكون تاريخ  :attribute بعد اليوم  .',
    'after_or_equal' => ' يجب ان تكون تاريخ :attribute بعد او مساو ل :date.',
    'alpha' => ' قد تحتوي :attribute  علي حروف فقط.',
    'alpha_dash' => ' قد تحتوي  :attribute علي حروف او ارقام او شرطات او شرطات سفلية فقط',
    'alpha_num' => ' قد تحتوي :attribute علي حروف او ارقام فقط .',
    'array' => ' يجب ان تكون :attribute مصفوفة.',
    'before' => ' يجب ان تكون :attribute تاريخ قبل :date.',
    'before_or_equal' => ' :يجب ان تكون تاريخ قبل او مساو :date.',
    'between' => [
        'numeric' => ' يجب ان :attribute تكون بين :min and :max.',
        'file' => ' يجب ان تكون :attribute بين :min و :max كيلو بايت.',
        'string' => ' يجب ان تكون :attribute  بين :min و :max حروف.',
        'array' => ' يجب ان تكون :attribute بين :min و :max عناصر.',
    ],
    'boolean' => ' يجب ان يكون :attribute حقل صواب او خطأ.',
    'confirmed' => '  :attribute  غير مطابق للتأكيد.',
    'date' => ' تاريخ :attribute غير صالح.',
    'date_equals' => ' يجب ان يكون :attribute تاريخ مساو الي :date.',
    'date_format' => ' :attribute لا يطابق التنسيق:format.',
    'different' => ' و :other يجب ان :attribute  تكون مختلفة.',
    'digits' => ' يجب ان :attribute  :digits عدد.',
    'digits_between' => ' :attribute يجب أن تكون بين :min و :max عدد.',
    'dimensions' => ' :attribute لها أبعاد غير صالحة',
    'distinct' => ' حقل :attribute له قيمة مكررة.',
    'email' => ' يحب ان يكون :attribute بريد الكتروني صالح.',
    'ends_with' => ' يجب ان ينتهي  :attribute بواحد مما يلي: :values',
    'exists' => 'المختار :attribute غير صالح.',
    'file' => ' :attribute يجب ان تكون ملفا.',
    'filled' => ' يجب ان تكون :attribute ذو قيمة.',
    'gt' => [
        'numeric' => ' يجب ان يكون :attribute اكبر من:value.',
        'file' => ' يجب ان يكون :attribute اكبر من :value كيلو بايت.',
        'string' => ' يجب ان يكون :attribute اكبر من :value حروف.',
        'array' => ' يجب ان يكون :attribute  اكبر من  :value عناصر.',
    ],
    'gte' => [
        'numeric' => ' يجب ان يكون :attribute  اكبر من او مساو الي :value.',
        'file' => ' يجب ان يكون :attribute اكبر من او مساو الي :value kilobytes.',
        'string' => ' يجب ان يكون :attribute  اكبر من او مساو الي :value characters.',
        'array' => ':attribute يجب ان يملك :value عناصر او اكثر.',
    ],
    'image' => ' يجب ان يكون :attribute  صورة.',
    'in' => ' صورة :attribute  المختارة غير صالحة.',
    'in_array' => ' حقل :attribute غير موجود في :other.',
    'integer' => ' يجب ان تكون  :attribute عددا صحيحا.',
    'ip' => '  يجب ان يكون عنوان :attribute IP صالحا.',
    'ipv4' => ' يجب ان يكون عنوان :attribute   IPv4 صالحا.',
    'ipv6' => ' يجب ان يكون عنوان :attribute IPv6 صالحا.',
    'json' => ' يجب ان تكون :attribute كلمة صالحة JSON.',
    'lt' => [
        'numeric' => ' يجب ان تكون :attribute اقل من :value.',
        'file' => ' يجب ان تكون :attribute اقل من :value كيلوبايت.',
        'string' => ' يجب ان يكون :attribute اقل من :value حروف.',
        'array' => ' يجب ان يكون :attribute  اقل من :value عناصر.',
    ],
    'lte' => [
        'numeric' => ' :attribute يجب ان يكون اقل من او مساو الي  :value.',
        'file' => ' :attribute يجب ان يكون اقل من او مساو الي :value كيلو بايت.',
        'string' => ' :attribute يجب ان يكون اقل من او مساو :value حروف.',
        'array' => ' :attribute يجب الا يكون اكثر من :value عناصر.',
    ],
    'max' => [
        'numeric' => '  قد لا يكون  :attribute اكبر :max.',
        'file' => ' قد لا يكون :attribute اكبر من :max كيلو بايت.',
        'string' => ' قد لا يكون :attribute اكبر من :max حروف.',
        'array' => ' :attribute قد لا يكون اكبر من :max عناصر.',
    ],
    'mimes' => ' يجب ان يكون :attribute  ملف من نوع: :values.',
    'mimetypes' => ' يجب ان يكون :attribute ملف من نوع : :values.',
    'min' => [
        'numeric' => ' يجب ان يكون :attribute علي الاقل :min.',
        'file' => ' يجب ان يكون :attribute علي الاقل :min كيلو بايت.',
        'string' => ' يجب ان يكون :attribute علي الاقل :min حروف.',
        'array' => ' يجب ان يكون :attributeعلي الاقل  must have at least :min عناصر.',
    ],
    'not_in' => ':attribute المختار غير صالح.',
    'not_regex' => ' تنسيق :attribute  غير صالح.',
    'numeric' => ' :attribute يجب ان تكون رقما.',
    'present' => ' يجب ان يكون حقل :attribute حاضرا.',
    'regex' => ' تنسيق :attribute غير صالح.',
    'required' => '  حقل :attribute مطلوب.',
    'required_if' => ' حقل  :attribute مطلوب عندما :other يكون :value.',
    'required_unless' => ' حقل :attribute مطلوب ما لم :other يكون هناك :values.',
    'required_with' => ' حقل:attribute يكون مطلوب عندما :values يكون حالي.',
    'required_with_all' => ' حقل :attribute  يكون مطلوب عندما :values يكون حالي.',
    'required_without' => ' حقل  :attribute يكون مطلوب عندما :values is غير حالي.',
    'required_without_all' => ' حقل  :attribute يكون مطلوب عندما لا    :values يكون حالي.',
    'same' => ' و :other  :attribute يجب ان تتطابق.',
    'size' => [
        'numeric' => ':attribute يجب أن يكون :size.',
        'file' => ' :attribute يجب ان يكون :size كيلو بايت.',
        'string' => ' :attribute يجب ان يكون :size حروف.',
        'array' => ' :attribute يجب ان يحتوي :size عناصر.',
    ],
    'starts_with' => ' يجب ان يبدأ :attribute بواحد مما يلي: :values',
    'string' => ' يجب ان تكون  :attribute كلمة.',
    'timezone' => ' يجب ان تكون :attribute  منطقة صالحة.',
    'unique' => ' :attribute اخذت بالفعل.',
    'uploaded' => ' فشل :attribute  في التحميل.',
    'url' => ' تنسيق :attribute غير صالح.',
    'uuid' => ' :attribute يجب ان يكون صالح UUID.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
      'name'=>'الاسم',
      'email'=>'البريد الالكتروني',
      'price'=>'السعر',
      'date'=>'التاريخ',
      'quantity'=>'الكمية',
      'quantity_type'=>'نوع الكمية',
      'details'=>'التفاصيل',
      'expire_date'=>'تاريخ الانتهاء',
      'type'=>'النوع',
      'phone'=>'رقم التليفون',
      'address'=>'العنوان',
      'contact_type'=>'نوع المتصل',
      'material_name'=>'اسم الخامة',
      'supplier_name'=>'اسم المورد',
      'date_of_order'=>'تاريخ الطلب',
      'process_number'=>'رقم العملية',
      'reason'=>'السبب',
      'indirect_cost_id'=>'رقم التكلفة غير المباشرة',
      'store_id'=>'رقم المتجر',
      'store_cost_id'=>'رقم تكلفة المتجر',
      'position_id'=>'اسم المنصب',
      'salary'=>'الراتب',
      'precentage'=>'النسبة',
      'seller_id'=>'رقم البائع',
      'description'=>'الوصف',
      'material_type_id' => 'نوع الخامة',
      'cancel_reason'  => 'رقم العملية',
      'deliver_name'    => 'اسم المستلم',
    ],

];
