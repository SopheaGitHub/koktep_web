<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostVisitorViewDetail extends Model
{
    protected $table = 'post_visitor_view_detail';
	protected $fillable = ['post_id', 'visitor_id', 'ip'];
}
