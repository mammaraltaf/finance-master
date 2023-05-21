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
    public const ManagerThresholdExceeded = 'manager-threshold-exceeded';
    public const FinanceThresholdExceeded = 'finance-threshold-exceeded';
    public const ManagerConfirmed = 'manager-confirmed';       //when manager accept it
    public const DirectorConfirmed = 'director-confirmed';       //when director accept it

    public const ConfirmedPartially = 'confirmed-partially';
    public const Paid = 'paid';

    public const Active = 'active';
    public const Inactive = 'inactive';

    public const Blocked = 'blocked';


    public const BOG_EXPORT = 'bog-export';
    public const TBC_EXPORT = 'tbc-export';

    public const BOG_EXPORT_COLUMNS = [
        'გამგზავნის ანგარიშის ნომერი',
        'დოკუმენტის ნომერი',
        'მიმღები ბანკის კოდი(არასავალდებულო)',
        'მიმღების ანგარიშის ნომერი',
        'მიმღების დასახელება',
        'მიმღების საიდენტიფიკაციო კოდი',
        'დანიშნულება',
        'თანხა',
        'ხელფასი',
        'გადარიცხვის მეთოდი',
        'დამატებითი ინფორმაცია'
    ];

    public const TBC_EXPORT_COLUMNS = [
        'საბუთის ნომერი',
        'მიმღების ანგარიში',
        'მიმღების სახელი',
        'მიმღ. საგადასახადო კოდი',
        'თანხა',
        'დანიშნულება',
        'დამატებითი დანიშნულება',
        'სახაზინო კოდი',
        'გადამხდელის კოდი',
        'გადამხდელის დასახელება'
    ];

    public const TBC_EXPORT_COLUMNS_2 = [
        'ns1:DOCNUM',
        'ns1:ACCIBANTO',
        'ns1:BENEFNAME',
        'ns1:BENEFTAXCODE',
        'ns1:AMOUNT',
        'ns1:DESCR',
        'ns1:ADDDESCR',
        'ns1:TREASCODE',
        'ns1:TAXPAYCODE',
        'ns1:TAXPAYNAME'
    ];

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
