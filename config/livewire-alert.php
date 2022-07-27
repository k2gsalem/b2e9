<?php

/*
 * For more details about the configuration, see:
 * https://sweetalert2.github.io/#configuration
 */
return [
    'alert' => [
        'position' => 'center',
        'timer' => 3000,
        'toast' => true,
        'text' => null,
        'showCancelButton' => false,
        'showConfirmButton' => false,
        'timerProgressBar' => true,
        'customClass' => [
            'container' => '',
            'popup' => '',
            'header' => '',
            'title' => '',
            'closeButton' => '',
            'icon' => '',
            'image' => '',
            'content' => '',
            'htmlContainer' => '',
            'input' => '',
            'inputLabel' => '',
            'validationMessage' => '',
            'actions' => '',
            'confirmButton' => '',
            'denyButton' => '',
            'cancelButton' => '',
            'loader' => '',
            'footer' => ''
        ]
    ],
    'confirm' => [
        'icon' => 'warning',
        'position' => 'center',
        'toast' => false,
        'timer' => null,
        'showConfirmButton' => true,
        'showCancelButton' => true,
        'cancelButtonText' => 'No',
        'confirmButtonColor' => '#3085d6',
        'cancelButtonColor' => '#d33'
    ]
];
