<?php

namespace App\Classes\Enums;

class StatusEnum
{
    public const New = 'new';
    public const SubmittedForReview = 'submitted-for-review';
    public const FinanceRejected = 'finance-rejected';
    public const ManagerRejected = 'manager-rejected';
    public const DirectorRejected = 'director-rejected';

    public const Rejected = 'rejected';
    public const FinanceOk = 'finance-ok';

    public const ThresholdExceeded = 'threshold-exceeded';
    public const ManagerConfirmed = 'manager-confirmed';       //when manager accept it
    public const DirectorConfirmed = 'director-confirmed';       //when director accept it

    public const ConfirmedPartially = 'confirmed-partially';
    public const Paid = 'paid';

    public const Active = 'active';
    public const Inactive = 'inactive';

    public const Blocked = 'blocked';


    public static $Statuses  =
    [
        self::New,
        self::SubmittedForReview,
        self::Rejected,
        self::FinanceRejected,
        self::ManagerRejected,
        self::DirectorRejected,
        self::FinanceOk,
        self::ThresholdExceeded,
        self::ManagerConfirmed,
        self::DirectorConfirmed,
        self::ConfirmedPartially,
        self::Paid,
    ];

    public static $Basic_statuses =
    [
        self::Active,
        self::Inactive,
        self::Blocked,
    ];
}
