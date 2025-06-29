<?php

/*
 * For more details about the configuration, see:
 * https://sweetalert2.github.io/#configuration
 */

use Jantinnerezo\LivewireAlert\Enums\Position;

return [
    'alert' => [
        // 'position' => 'bottom-start',
        // 'position' => Position::Center,
        'position' => Position::BottomStart,
        'timer' => 3000,
        'toast' => true,
        'text' => null,
    'confirmButtonText' => 'Yes',
    'cancelButtonText' => 'Cancel',
    'denyButtonText' => 'No',
    'showCancelButton' => false,
    'showConfirmButton' => false,
    'backdrop' => true,
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
