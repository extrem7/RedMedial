<?php

use App\Http\Middleware\Admin;

return [
    'sections' => [
        'app' => [
            'title' => 'General Settings',
            'descriptions' => 'Application general settings.',
            'icon' => 'fa fa-cog',
            'inputs' => [
                [
                    'name' => 'app_name',
                    'type' => 'text',
                    'label' => 'App Name',
                    'placeholder' => 'MiMedio',
                    'class' => 'form-control',
                    'style' => '',
                    'rules' => 'required',
                    'value' => 'MiMedio',
                    'hint' => 'You can set the site name here'
                ],
            ]
        ],
        'email' => [
            'title' => 'Email Settings',
            'icon' => 'fa fa-envelope',

            'inputs' => [
                [
                    'name' => 'emails_for_messages',
                    'type' => 'text',
                    'label' => 'Emails to receive messages',
                    'rules' => ['required', 'string'],
                ]
            ]
        ]
    ],

    'url' => '/settings',
    'middleware' => [Admin::class],

    'setting_page_view' => 'admin.settings',
    'flash_partial' => 'app_settings::_flash',

    'section_class' => 'card mb-3',
    'section_heading_class' => 'card-header',
    'section_body_class' => 'card-body',

    'input_wrapper_class' => 'form-group',
    'input_class' => 'form-control',
    'input_error_class' => 'has-error',
    'input_invalid_class' => 'is-invalid',
    'input_hint_class' => 'form-text text-muted',
    'input_error_feedback_class' => 'text-danger',

    'submit_btn_text' => 'Save',
    'submit_success_message' => 'Settings has been saved.',

    'remove_abandoned_settings' => false,

    'controller' => '\App\Http\Controllers\Admin\AppSettingController',

    'setting_group' => 'default'
];
