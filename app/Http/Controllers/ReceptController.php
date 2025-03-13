<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Recept;


class ReceptController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('id'))
        {
            $recept = Recept::findOrFail($request->id)->load('hozzavalok');
            return response()->json([
                'id'=>$recept->id,
                'nev'=>$recept->nev,
                'ido'=>$recept->ido,
                'nehezseg'=>$recept->nehezseg,
                'leiras'=>$recept->leiras,
                'hozzavalok'=>$recept->hozzavalok->map(function($item){
                    return [
                        'mennyiseg'=>$item->pivot->mennyiseg,
                        'nev'=>$item->nev,
                        'mertekegyseg'=>$item->mertekegyseg
                    ];
                 })])
            ;
        }
        $receptek = Recept::all();
        return response(json_encode(["success" => true, 'receptek' => $receptek]));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'nev' => "required|string|max:255",
                'ido' => "required|integer|min:1",
                'nehezseg' => "string|max:255",
                'leiras' => "required|string|max:1001",
                'hozzavalok' => "required|array|min:1",
                'hozzavalok.*.id' => "required|integer|exists:hozzavalok,id",
                'hozzavalok.*.mennyiseg' => "required|integer|min:1"
            ],
            [
                'required' => 'A :attribute mező kitöltése kötelező!',
                'string' => 'A(z) :attribute mező szöveges értéket vár!',
                'integer' => "A(z) :attribute mező egész szám értéket vár!",
                'array' => "A(z) :attribute mező lista értéket vár!",
                'exists' => "A(z) :exists mező értéket vár!",
                'hozzavalok.*.id' => "Olyan hozzávalót adott meg, ami nem létezik!",
                'max' => 'A(z) :attribute túl hosszú! Max hossz :max',
                'min' => 'A(z) :attribute túl rövid! Min hossz :min'
            ],
            [
                'nev' => "név",
                'ido' => "idő",
                'nehezseg' => "nehézség",
                'leiras' => "leírás",
                'hozzavalok' => "hozzávalók",
                'hozzavalok.*.mennyiseg' => "mennyiség"
            ]);
        } catch(Exception $e)
        {
            return response()->json(['success' =>false, 'error' => $e->getMessage()],400, options:JSON_UNESCAPED_UNICODE);
        }
        $recept = Recept::create([
            'nev' => $request->nev,
            'ido' => $request->ido,
            'nehezseg' => $request->nehezseg,
            'leiras' => $request->leiras,

        ]);
        $hozzavalok = $request->hozzavalok;
        // return $hozzavalok;
        foreach ($hozzavalok as $hozzavalo) {
            $recept->hozzavalok()->attach($hozzavalo['id'],['mennyiseg'=>$hozzavalo['mennyiseg']]);
        }
        return response()->json(['success' => true, 'message'],200, options:JSON_UNESCAPED_UNICODE);
    }
}
