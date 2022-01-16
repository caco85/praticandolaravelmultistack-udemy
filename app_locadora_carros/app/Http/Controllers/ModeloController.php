<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Marca;
use App\Repositories\ModeloRepository;

class ModeloController extends Controller
{

    public function __construct(Modelo $modelo) {
        $this->modelo = $modelo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $modeloRepository = new ModeloRepository($this->modelo);

        if($request->has('atributos_marca')) {
            $atributos_marca = 'marca:id,'.$request->atributos_marca;
            $modeloRepository->selectAtributosRegistrosRelacionados($atributos_marca);
        } else {
            $modeloRepository->selectAtributosRegistrosRelacionados('marca');
        }

        if($request->has('filtro')) {
            $modeloRepository->filtro($request->filtro);
        }

        if($request->has('atributos')) {
            $modeloRepository->selectAtributos($request->atributos);
        }

        return response()->json($modeloRepository->getResultado(), 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->modelo->rules());

        $image = $request->file('imagem');
        $imagem_urn = $image->store('imagens/modelos','public');

        $modelo = $this->modelo->create([
            'nome' => $request->nome,
            'imagem' =>   $imagem_urn,
            'numeroPortas' =>$request->numeroPortas,
            'lugares' => $request->lugares,
            'airbag' => $request->airbag,
            'abs' => $request->abs,
            'id_marca' => $request->id_marca
        ]);

        return  response()->json($modelo,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelo = $this->modelo->find($id);
        if ($modelo === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'],404);
        }
          return response()->json($modelo, 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $modelo = $this->modelo->with('marca')->find($id);
        if ($modelo === null) {
            return response()->json(['erro' => 'Não foi posivel atualizar, o recurso pesquisado não existe'],404);
        }


        if ($request->method() === 'PATCH') {
            foreach($modelo->rules() as $input => $regra){
                if(array_key_exists($input, $request->all())){
                   $regrasdinamicas[$input] = $regra;

                }
            }
            $request->validate($regrasdinamicas);
        } else {
            $request->validate($modelo->rules());
        }

        if ($request->file('imagem')) {
            Storage::disk('public')->delete($modelo->imagem);
        }

        $image = $request->file('imagem');
        $imagem_urn = $image->store('imagens/modelos','public');

        $modelo->fill($request->all());
        $modelo->imagem = $imagem_urn;

        $modelo->save();

        // $modelo->update([
        //     'nome' => $request->nome,
        //     'imagem' =>   $imagem_urn,
        //     'numeroPortas' =>$request->numeroPortas,
        //     'lugares' => $request->lugares,
        //     'airbag' => $request->airbag,
        //     'abs' => $request->abs,
        //     'id_marca' => $request->id_marca
        // ]);

        return response()->json($modelo, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo = $this->modelo->find($id);

        if ($modelo === null) {
            return response()->json(['erro' => 'Não foi posivel deletar, o recurso pesquisado não existe'],404);
        }

        Storage::disc('public')->delete($modelo->imagem);

        $modelo->delete();
        return response()->json(['msg' => 'o modelo foi removida com sucesso!'],200);
    }
}
