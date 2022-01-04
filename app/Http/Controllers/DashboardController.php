<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        if(Auth::user()->hasRole('admin')) {
            return view('admin.adminDashboard');
        }elseif(Auth::user()->hasRole('customer')){
            return view('customer.customerProfile');
        }
    }
}
