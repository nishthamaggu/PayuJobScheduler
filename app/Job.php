<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
	protected $table = "job";
    protected $fillable = ['query', 'start_time', 'routine', 'type'];
}
