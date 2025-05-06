<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BController extends Controller
{
    public function index()
    {
        return view('admin.b.index');
    }
}
