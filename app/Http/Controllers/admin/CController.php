<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CController extends Controller
{
    public function index()
    {
        return view('admin.c.index');
    }
}