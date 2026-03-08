<?php

namespace Kopou\SESEngine\Models;

use Illuminate\Database\Eloquent\Model;

class SentEmail extends Model
{
    protected $table = 'kopou_sent_emails';
    protected $guarded = [];
    public $timestamps = true;
}
