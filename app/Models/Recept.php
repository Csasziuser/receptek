<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recept extends Model
{
    protected $table = "receptek";
    protected $fillable = ["nev","ido","nehezseg","leiras"];
    public function hozzavalok()
    {
        return $this -> belongsToMany(Hozzavalo::class) -> withPivot("mennyiseg");
    }
}
