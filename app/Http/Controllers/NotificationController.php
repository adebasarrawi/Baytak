<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the user's notifications.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications->paginate(10); // إذا كانت notifications كخاصية
        return view('notifications.index', compact('notifications'));
    }// app/Models/User.php
   
}