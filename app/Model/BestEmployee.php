<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class BestEmployee extends Model
{
	protected $table = 'best_employees';

	protected $fillable = [
    	'employee_id', 'year', 'month', 'image'
    ];

    protected $primaryKey = 'id';
}
