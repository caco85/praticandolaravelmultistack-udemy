<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

   protected $fillable = ['nome' ,'imagem'];

   public function rules()
   {
        return [
            'nome' => 'required|unique:marcas,nome,'.$this->id.'|min:3',
            'imagem' => 'required|file|mimes:png,jpeg'
        ];
   }

   public function feedback()
   {
        return [
            'required' => 'o campo :attribute é obrigatório',
             'imagem.mines' => 'o arquivo tem que ser um arquivo do tipo png ou jpeg',
            'nome.unique' => 'o nome  da marca ja existe',
            'nome.min' => 'o campo nome precisa ter no minimo 3 caracteres'

        ];

   }

   public function modelos()
   {
      return $this->hasMany('App\Models\Modelo');
   }
}
