<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
	protected $table = 'evaluations';

	protected $fillable = [
    	'set', 'number', 'list', 'score', 'status'
    ];

    protected $primaryKey = 'id';
}
