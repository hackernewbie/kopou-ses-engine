<?php

namespace Kopou\SESEngine\Models;

use Illuminate\Database\Eloquent\Model;

class Suppression extends Model
{
    protected $table = 'kopou_suppression_list';
    protected $guarded = [];
    public $timestamps = true;

    public static function isSuppressed(string $email): bool
    {
        return self::where('email', $email)->exists();
    }
}
