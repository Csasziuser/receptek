<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hozzavalo extends Model
{
    protected $table = "hozzavalok";
    protected $fillable = ["nev","mertekegyseg"];
    public function receptek()
    {
        return $this -> belongsToMany(Recept::class) -> withPivot("mennyiseg");
    }
}
