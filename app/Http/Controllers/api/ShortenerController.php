<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShortenerController extends Controller {
	public function index(Request $r) {
		return view('welcome');
	}
}