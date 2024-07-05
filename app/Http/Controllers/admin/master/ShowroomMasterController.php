<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShowroomMasterController extends Controller
{
    public function index(){
        return view('admin.master.index');
    }
}
