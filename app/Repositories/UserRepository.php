<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements UserRepositoryInterface{

	function allWhereNotNull($columnName = null){
		if(!empty($columnName))
			return User::all()->whereNotNull($columnName);
		return User::all();
	}

}