<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
  public function show()
  {
    return view('layouts.default');
  }
  public function table()
  {
    return view('layouts.table');
  }
}
