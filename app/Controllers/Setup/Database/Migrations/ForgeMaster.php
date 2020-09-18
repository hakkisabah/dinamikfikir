<?php

namespace App\Controllers\Setup\Database\Migrations;


class ForgeMaster
{
    public function __construct($forge)
    {
        (new Comments())->up($forge);
        (new IpTables())->up($forge);
        (new UserContent())->up($forge);
        (new UserNotifications())->up($forge);
        (new UserTable())->up($forge);

    }
}