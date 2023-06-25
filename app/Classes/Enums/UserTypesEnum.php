<?php

namespace App\Classes\Enums;

class UserTypesEnum{

    public const SuperAdmin = 'super-admin';
    public const Admin = 'admin';

    public const User = 'user';
    public const Accounting = 'accounting';
    public const Finance = 'finance';

    public const Manager = 'manager';
    public const Director = 'director';

    public const Spectator = 'spectator';


    public static $USER_TYPE_COLOR =
        [
            self::SuperAdmin => 'danger',
            self::Admin => 'success',
            self::User => 'primary',
            self::Accounting => 'warning',
            self::Finance => 'info',
            self::Manager => 'secondary',
            self::Director => 'dark',
        ];

    public static $USER_TYPES =
        [
            self::SuperAdmin,
            self::Admin,
            self::User,
            self::Accounting,
            self::Finance,
            self::Manager,
            self::Director,
        ];

}
