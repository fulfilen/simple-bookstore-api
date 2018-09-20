<?php

namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

class EmailAvailable extends AbstractRule
{
	
	public function validate($input)
	{
		return (bool) !User::where('email', $input)->exists();
	}
}