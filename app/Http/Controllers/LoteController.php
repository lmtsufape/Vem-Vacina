<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lote;

class LoteController extends Controller
{
    public function show() {
        $lotes = Lote::all();

        return view('lotes')->with(['lotes' => $lotes]);
    }
}
