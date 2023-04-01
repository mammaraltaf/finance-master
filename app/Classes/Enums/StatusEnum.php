<?php

namespace App\Classes\Enums;

class StatusEnum
{
    public const New = 'new';
    public const SubmittedForReview = 'submitted-for-review';
    public const Rejected = 'rejected';
    public const FinanceOk = 'finance-ok';
    public const Confirmed = 'confirmed';       //when manager accept it

    public const Paid = 'paid';

    public const Active = 'active';
    public const Inactive = 'inactive';

    public static $Statuses  =
    [
        self::New,
        self::SubmittedForReview,
        self::Rejected,
        self::FinanceOk,
        self::Confirmed,
        self::Paid
    ];

    public static $Basic_statuses =
    [
        self::Active,
        self::Inactive
    ];
}
