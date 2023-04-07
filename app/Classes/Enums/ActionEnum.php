<?php

namespace App\Classes\Enums;

class ActionEnum
{
    public const FINANCE_ACCEPT = 'finance-accept';
    public const FINANCE_REJECT = 'finance-reject';

    public const MANAGER_ACCEPT = 'manager-accept';
    public const MANAGER_REJECT = 'manager-reject';

    public const DIRECTOR_ACCEPT = 'director-accept';
    public const DIRECTOR_REJECT = 'director-reject';

    public const ACCOUNTING_ACCEPT = 'accounting-accept';
    public const ACCOUNTING_REJECT = 'accounting-reject';


    public static $Statuses  =
    [
        self::FINANCE_ACCEPT,
        self::FINANCE_REJECT,
        self::MANAGER_ACCEPT,
        self::MANAGER_REJECT,
        self::DIRECTOR_ACCEPT,
        self::DIRECTOR_REJECT,
        self::ACCOUNTING_ACCEPT,
        self::ACCOUNTING_REJECT,
    ];
}
