<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ElearningStatistic extends Model
{
    protected $table = 'e_learning_statistics';

	protected $fillable = [
    	'staff_id','date','count'
    ];

    protected $primaryKey = 'id';
}
