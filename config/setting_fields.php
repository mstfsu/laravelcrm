<?php

return [
    'app' => [
        'title' => 'General',
        'desc'  => ' ',
        'icon'  => 'fas fa-cube',

        'elements' => [



            [
                'type'  => 'text', // input fields type
                'data'  => 'string', // data type, string, int, boolean
                'name'  => 'organization_name', // unique name for field
                'label' => 'Organization Name'    , // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Zapbytes', // default value if you want
            ],

            [
                'type'  => 'text', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'zone_name', // unique name for field
                'label' => 'Zone Name', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Zapbytes', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'email', // unique name for field
                'label' => 'Email', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'meta_bannerslogan', // unique name for field
                'label' => 'Banner Slogan', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'phone', // unique name for field
                'label' => 'Phone', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'footer_text', // unique name for field
                'label' => 'Footer Text', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'CopyRights 2021 Zapbytes All rights Reserved ', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'int', // data type, string, int, boolean
                'name'  => 'default_import_plan', // unique name for field
                'label' => 'Import Plan', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '1', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'int', // data type, string, int, boolean
                'name'  => 'add_revenue_balance', // unique name for field
                'label' => 'Add Revenue To balance', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'send_release_request', // unique name for field
                'label' => 'Send Release Request', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want
            ],

            [
                'type'  => 'text', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'revenue_share_type_reseller', // unique name for field
                'label' => 'revenue_share_type_reseller', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'fixed', // default value if you want
            ],

            [
                'type'  => 'text', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'currency', // unique name for field
                'label' => 'currency', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'INR', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'int', // data type, string, int, boolean
                'name'  => 'tax_value', // unique name for field
                'label' => 'tax', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'int', // data type, string, int, boolean
                'name'  => 'grace_period', // unique name for field
                'label' => 'Grace', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '10', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'int', // data type, string, int, boolean
                'name'  => 'grace_times_monthly', // unique name for field
                'label' => 'grace_times_monthly', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '10', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'int', // data type, string, int, boolean
                'name'  => 'revert_period', // unique name for field
                'label' => 'revert_period', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '10', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'int', // data type, string, int, boolean
                'name'  => 'invoice_should_paid_in', // unique name for field
                'label' => 'invoice_should_paid_in', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '10', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'int', // data type, string, int, boolean
                'name'  => 'disable_account_due_unpaid_invoice', // unique name for field
                'label' => 'disable_account_due_unpaid_invoice', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'generate_invoice_at', // unique name for field
                'label' => 'generate_invoice_at', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '00:00', // default value if you want
            ],


            [
                'type'  => 'text', // input fields type
                'data'  => 'int', // data type, string, int, boolean
                'name'  => 'accept_rejected_customers', // unique name for field
                'label' => 'accept_rejected_customers', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '0', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'int', // data type, string, int, boolean
                'name'  => 'blocked_new_customers_plan', // unique name for field
                'label' => 'blocked_new_customers_plan', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '1', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'int', // data type, string, int, boolean
                'name'  => 'add_user_to_blocked_plan_after', // unique name for field
                'label' => 'add_user_to_blocked_plan_after', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '1000', // default value if you want
            ],



        ],
    ],
    'register' => [
        'title' => 'Register',
        'desc'  => ' ',
        'icon'  => 'fas fa-book-open',

        'elements' => [
            [
                'type'  => 'select', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'is_id_number', // unique name for field
                'label' => 'TC Kontrolü', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'options' => ['0'=>'Hayır','1'=>'Evet'], // default value if you want
            ],
            [
                'type'  => 'select', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'mail_code_control', // unique name for field
                'label' => 'Mail Kod Kontrolü', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'options' => ['0'=>'Hayır','1'=>'Evet'], // default value if you want
            ],
            [
                'type'  => 'select', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'control_KVKK', // unique name for field
                'label' => 'KVKK kontrolü', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'options' => ['0'=>'Hayır','1'=>'Evet'], // default value if you want
            ],
            [
                'type'  => 'select', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'control_user_photo', // unique name for field
                'label' => 'Fotoğraf Kontrolü', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'options' => ['0'=>'Hayır','1'=>'Evet'], // default value if you want
            ],
            [
                'type'  => 'select', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'control_user_identity', // unique name for field
                'label' => 'Kimlik Kontrolü', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'options' => ['0'=>'Hayır','1'=>'Evet'], // default value if you want
            ],
            [
                'type'  => 'select', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'control_safe_exam_browser', // unique name for field
                'label' => 'Güvenli Sınav Tarayıcısı Kontrolü', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'options' => ['0'=>'Hayır','1'=>'Evet'], // default value if you want
            ],
            [
                'type'  => 'select', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'trial_exam', // unique name for field
                'label' => 'Kullanıcı Deneme Sınavı Olacak mı?', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
                'options' => ['0'=>'Hayır','1'=>'Evet'], // default value if you want
            ],
            [
                'type'  => 'select2', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'trial_exam_id', // unique name for field
                'label' => 'Deneme Sınavı', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
        ],
    ],

    'mail_template_settings' => [
        'title' => 'mail_template_settings',
        'desc'  => ' ',
        'icon'  => 'fas fa-book-open',

        'elements' => [
            [
                'type'  => 'mail_select2', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'register_mail_template', // unique name for field
                'label' => 'register_mail_template', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
            [
                'type'  => 'mail_select2', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'con_resend_mail_template', // unique name for field
                'label' => 'email Confirmation Resend', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
            [
                'type'  => 'mail_select2', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'exam_mail_template', // unique name for field
                'label' => 'exam_mail_template', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
            [
                'type'  => 'mail_select2', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'new_user_import_mail_template', // unique name for field
                'label' => 'new_user_import_mail_template', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
            [
                'type'  => 'mail_select2', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'reset_password_mail_template', // unique name for field
                'label' => 'reset_password_mail_template', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
        ],
    ],

    'sms_template_settings' => [
        'title' => 'sms_template_settings',
        'desc'  => ' ',
        'icon'  => 'fas fa-book-open',

        'elements' => [
            [
                'type'  => 'mail_select2', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'register_sms_template', // unique name for field
                'label' => 'register_sms_template', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
            [
                'type'  => 'mail_select2', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'con_resend_sms_template', // unique name for field
                'label' => 'sms Confirmation Resend', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
            [
                'type'  => 'mail_select2', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'exam_sms_template', // unique name for field
                'label' => 'exam_sms_template', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
            [
                'type'  => 'mail_select2', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'new_user_import_sms_template', // unique name for field
                'label' => 'new_user_import_sms_template', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
            [
                'type'  => 'mail_select2', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'reset_password_sms_template', // unique name for field
                'label' => 'reset_password_sms_template', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '', // default value if you want
            ],
        ],
    ],
    'email' => [
        'title' => 'Email',
        'desc'  => ' ',
        'icon'  => 'fas fa-envelope',

        'elements' => [
            [
                'type'  => 'email', // input fields type
                'data'  => 'string', // data type, string, int, boolean
                'name'  => 'email', // unique name for field
                'label' => 'Email', // you know what label it is
                'rules' => 'email', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'info@example.com', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'meta_site_name', // unique name for field
                'label' => 'Site Adı', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Awesome Laravel | A Laravel Starter Project', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'meta_description', // unique name for field
                'label' => 'Site Açıklaması', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Laravel Starter Application. A boilarplate to all type of application.', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'meta_keyword', // unique name for field
                'label' => 'Anahtar Kelimeler', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Web Application, Laravel,Laravel starter,Bootstrap,Admin,Template,Open,Source, nasir khan, nasirkhan', // default value if you want
            ],
        ],

    ],
    'exam_rules' => [
        'title' => 'Sınav Kuralları',
        'desc'  => ' ',
        'icon'  => 'fas fa-book',

        'elements' => [
            [
                'type'  => 'textarea', // input fields type
                'data'  => 'string', // data type, string, int, boolean
                'name'  => 'exam_rules', // unique name for field
                'label' => 'Sınav Kuralları', // you know what label it is
                'rules' => 'nullable|', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],



        ],

    ],
    'tubitak' => [
        'title' => 'Tübitak Tarih Zaman Damgası',
        'desc'  => ' ',
        'icon'  => 'fas fa-cog',

        'elements' => [
            [
                'type'  => 'text', // input fields type
                'data'  => 'string', // data type, string, int, boolean
                'name'  => 'tubitak_user', // unique name for field
                'label' => 'Kullanıcı Adı', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Kullanıcı Adı', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'tubitak_pass', // unique name for field
                'label' => 'Parola', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Parola', // default value if you want
            ],


        ],

    ],
    'social' => [
        'title' => 'Social Profiles',
        'desc'  => ' ',
        'icon'  => 'fas fa-users',

        'elements' => [
            [
                'type'  => 'text', // input fields type
                'data'  => 'string', // data type, string, int, boolean
                'name'  => 'facebook_url', // unique name for field
                'label' => 'Facebook Profil Linki', // you know what label it is
                'rules' => 'nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'string', // data type, string, int, boolean
                'name'  => 'twitter_url', // unique name for field
                'label' => 'Twitter Profil Linki', // you know what label it is
                'rules' => 'nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'string', // data type, string, int, boolean
                'name'  => 'linkedin_url', // unique name for field
                'label' => 'LinkedIn Profil Linki', // you know what label it is
                'rules' => 'nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
            [
                'type'  => 'text', // input fields type
                'data'  => 'string', // data type, string, int, boolean
                'name'  => 'youtube_url', // unique name for field
                'label' => 'Youtube Kanal Linki', // you know what label it is
                'rules' => 'nullable|max:191', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '#', // default value if you want
            ],
        ],

    ],
    'images' => [
        'title' => 'images',
        'desc'  => ' ',
        'icon'  => 'fas fa-image',

        'elements' => [
            [
                'type'  => 'file', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'meta_image', // unique name for field
                'label' => 'Site Logo', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'img/default_banner.jpg', // default value if you want
            ],
            [
                'type'  => 'file', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'meta_login', // unique name for field
                'label' => 'Giriş Ekran Resmi', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'img/default_banner.jpg', // default value if you want
            ],
            [
                'type'  => 'file', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'meta_register', // unique name for field
                'label' => 'Kayıt Ekranı Resmi', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'img/default_banner.jpg', // default value if you want
            ],
            [
                'type'  => 'file', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'meta_favicon', // unique name for field
                'label' => 'Site Favicon', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'img/default_banner.jpg', // default value if you want
            ],
            [
                'type'  => 'file', // input fields type
                'data'  => 'text', // data type, string, int, boolean
                'name'  => 'meta_banner', // unique name for field
                'label' => 'Site Banner Resmi', // you know what label it is
                'rules' => '', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'img/default_banner.jpg', // default value if you want
            ],
        ],

    ],
    'meta' => [
        'title' => 'Meta ',
        'desc'  => ' ',
        'icon'  => 'fas fa-globe-asia',

        'elements' => [



        ],

    ],
];
