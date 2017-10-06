<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationViewed extends Model
{
    protected $table = 'notification_viewed';
	protected $fillable = ['user_id'];
}
