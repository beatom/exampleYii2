<?php
return [
    'guest' => [
        'type' => 1,
        'ruleName' => 'userRole',
    ],
    'confirmed' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'confirmPhone',
            'enterNewPhone',
            'confirmPhoneResendCodeShowLink',
        ],
    ],
    'user' => [
        'type' => 1,
        'ruleName' => 'userRole',
        'children' => [
            'addProposition',
            'changePropositionInterest',
            'removePhoneResendCodeShowLink',
        ],
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userRole',
    ],
    'addProposition' => [
        'type' => 2,
        'ruleName' => 'addProposition',
    ],
    'confirmPhone' => [
        'type' => 2,
        'ruleName' => 'confirmPhone',
    ],
    'changePropositionInterest' => [
        'type' => 2,
        'ruleName' => 'changePropositionInterest',
    ],
    'enterNewPhone' => [
        'type' => 2,
        'ruleName' => 'enterNewPhone',
    ],
    'removePhoneResendCodeShowLink' => [
        'type' => 2,
        'ruleName' => 'removePhoneResendCodeShowLink',
    ],
    'confirmPhoneResendCodeShowLink' => [
        'type' => 2,
        'ruleName' => 'confirmPhoneResendCodeShowLink',
    ],
];
