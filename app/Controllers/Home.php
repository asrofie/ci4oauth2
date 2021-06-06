<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		$clientModel = model('OauthClientModel');
		return view('welcome_message');
	}
}
