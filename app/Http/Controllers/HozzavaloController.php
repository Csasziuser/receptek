<?php

namespace App\Http\Controllers;

use App\Models\Hozzavalo;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HozzavaloController extends Controller
{
    public function index(){
        $hozzavalok = Hozzavalo::all();
        return response(json_encode(['success' => true, 'hozzavalok' => $hozzavalok]));
    }

    public function store(Request $request){
        try {
            $request->validate([
                'nev' =>'required|string|max:255',
                'mertekegyseg'=>'required|string|max:255',
            ],[
                'required' => 'A :attribute mező kitöltése kötelező!',
                'string' => 'A(z) :attribute mező szöveges értéket vár!',
                'max' => 'A(z) :attribute túl hosszú! Max hossz :max',
            ],[
                'nev' =>'hozzávaló',
                'mertekegyseg' =>'mértékegység',
            ]);
        } catch (ValidationException $e) {
            return response(json_encode(['success' =>false, 'error' => $e->getMessage(),]),400, options:JSON_UNESCAPED_UNICODE);
        }
        
        Hozzavalo::create([
            'nev' => $request->nev,
            'mertekegyseg' => $request->mertekegyseg,
        ]);

        return response(json_encode(['success' =>true, 'message' => 'Sikeresen rögzítve']),201, options:JSON_UNESCAPED_UNICODE);
    }
}
