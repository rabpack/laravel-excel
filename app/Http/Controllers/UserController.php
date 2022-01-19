<?php

namespace App\Http\Controllers;

use App\Exports\TestExcelExport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PHPUnit\Util\Test;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->inRandomOrder()->take(10)->get();
        return view('user',compact('users'));
    }

    public function download()
    {
        return Excel::download(new TestExcelExport(), 'user.xlsx');
    }
}
