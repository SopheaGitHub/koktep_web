<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExhibitionComment extends Model
{
    protected $table = 'exhibition_comment';
	protected $fillable = ['user_id', 'exhibition_id', 'comment', 'parent_id'];
}
