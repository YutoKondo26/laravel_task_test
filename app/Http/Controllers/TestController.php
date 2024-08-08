<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        dd('test');
        // Eloquent(エロクアント)
        $values = Test::all();
        $count = Test::count();
        $fist = Test::findOrFail(1);
        $whereBBB = Test::where('text','=','bbb');

        //クエリビルダ
        $queryBuilder = DB::table('tests')->where('text','=','bbb')
        ->select('id','text')
        ->get();

        dd($values,$count,$fist,$whereBBB,$queryBuilder);
        return view('tests.test',compact('values'));
    }
}
