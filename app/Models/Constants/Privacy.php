<?php
namespace App\Models\Constants;
use Spatie\Enum\Enum;


class Privacy extends Enum{
    protected static function values()
    {
        return [
            'public' => 'Public',
            'schedule' => 'Schedule',
            'anyone' => 'Anyone with the link',
            'private' => 'Private draft'
        ];
    }
}

