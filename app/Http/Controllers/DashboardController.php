<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use App\Notifications\InvoicePaid;
use App\User;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::find(1);
        // $user->notify(new InvoicePaid('INVOICE'));

        return redirect()->route('painel.clientes');
        // return view('admin.dashboard.index');
    }
}
