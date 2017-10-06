<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';
	protected $fillable = ['user_id', 'notification_action_id', 'notification_type_id', 'notification_of_id'];
}
