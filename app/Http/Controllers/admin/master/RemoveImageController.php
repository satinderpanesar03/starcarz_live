<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RemoveImageController extends Controller
{
    public function delete($table, $id, $field){
        DB::table($table)->where('id', $id)->update([
            $field => '',
        ]);
        return redirect()->back();
    }
}
