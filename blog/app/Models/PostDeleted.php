<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostDeleted extends Model
{
    protected $table = 'post_deleted';
	protected $fillable = ['deleted_by_author_id', 'data'];
}
