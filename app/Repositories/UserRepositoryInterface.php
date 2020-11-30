<?php

namespace App\Repositories;

interface UserRepositoryInterface{

	public function allWhereNotNull($columnName);
	
}