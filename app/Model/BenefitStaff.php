<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class BenefitStaff extends Model
{
	protected $table = 'benefit_staffs';

	protected $fillable = [
    	'id', 'name', 'detail',
    ];

    protected $primaryKey = 'id';
}
