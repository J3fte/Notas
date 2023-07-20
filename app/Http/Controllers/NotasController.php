<?php

namespace App\Http\Controllers;

use App\Models\Notas;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use App\Repositories\NotasRepository;

class NotasController extends Controller
{

  public function index()
  {
    $notas = Notas::all();
    return  $notas;
  }
  public function store(StorePostRequest  $request,  NotasRepository $notasRepository)
  {
    $validatedData = $request->validated();
    $nota = $notasRepository->createNota($validatedData['titulo_nota'], $validatedData['descripcion_nota'], $validatedData['archivado'], $request);
    return $nota;
  }
  public function show($notas)
  {
    $nota = Notas::find($notas);
    return $nota;
  }
  public function update(Request $request, $notas, NotasRepository $notasRepository)
  {
    $nota = Notas::find($notas);
    $nota = $notasRepository->editNote(['titulo_nota'], ['descripcion_nota'], $request, $nota);
    return $nota;
  }
  public function destroy($notas, NotasRepository $notasRepository)
  {
    $nota = Notas::find($notas);
    $notasRepository->deleteNote($nota);
    return response()->noContent();
  }
  public function archiveNote(Request $request, $id, NotasRepository $notasRepository)
  {
    $nota = Notas::find($id);
    if (is_null($nota)) {
      return response()->json(['message' => 'No existe la nota la nota que quiere editar'], 404);
    } else {
      $notasRepository->doArchivedNote($request, $nota);
      return response()->json(['message' => 'La nota se cambio'], 200);
    }
  }
  public function nArchivadas(NotasRepository $notasRepository)
  {
    return  $notasRepository->allArchivedNotes();
  }
}
