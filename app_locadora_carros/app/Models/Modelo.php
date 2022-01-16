<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'nome' ,'imagem' , 'numeroPortas' , 'lugares' ,'airbag' , 'abs', 'marca_id'];

    public function rules()
    {
         return [
             'nome' => 'required|unique:modelos,nome,'.$this->id.'|min:3',
             'imagem' => 'required|file|mimes:png,jpeg',
             'numeroPortas' => 'required|integer|digits_between:1,5',
             'lugares'=> 'required|integer|digits_between:1,20',
             'airbag' => 'required|boolean',
             'abs' => 'required|boolean',
             'marca_id' => 'exists:marcas,id',

         ];
    }

    public function marca()
    {
        return $this->belongsTo('App\Models\Marca');
    }

}
