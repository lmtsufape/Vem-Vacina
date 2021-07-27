<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function index()
    {

        $notifications = DB::table('notifications')->orderBy('created_at', "DESC")->paginate(50);

        return view('notifications.index', compact('notifications'));
    }
}
