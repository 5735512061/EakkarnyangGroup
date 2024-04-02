<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class CompanyRegulations extends Model
{
	protected $table = 'company_regulations';

	protected $fillable = [
    	'id', 'file_company_regulations', 'date'
    ];

    protected $primaryKey = 'id';
}
