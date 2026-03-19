<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    protected $fillable = ['user_id','channel','type','recipient','payload','status','error_message','sent_at'];
    protected function casts(): array { return ['payload' => 'array', 'sent_at' => 'datetime']; }
}
