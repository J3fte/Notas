<?php

namespace App\Repositories;

use App\Models\Notas;

class NotasRepository
{
  public function createNota($titulo, $descripcion, $archivado, $request)
  {
    $nota = new Notas;
    $nota->titulo_nota = $request->titulo_nota;
    $nota->descripcion_nota = $request->descripcion_nota;
    $nota->archivado = $request->archivado === 'true';
    $nota->save();
    return $nota;
  }

  public function editNote($titulo, $descripcion, $request, $nota)
  {
    $nota->titulo_nota = $request->titulo_nota;
    $nota->descripcion_nota = $request->descripcion_nota;
    $nota->update();
    return $nota;
  }
  public function deleteNote($nota)
  {
    if (is_null($nota)) {
      return response()->json('No se pudo realizar correctamente la operacion', 404);
    } else {
      $nota->delete();
    }
  }
  public function doArchivedNote($request, $nota)
  {
    $archivado = ($request->archivado === 'true') ? true : false;
    $nota->archivado = $archivado;
    $nota->save();
    return $nota;
  }
  public function allArchivedNotes()
  {
    $notasArchivadas = Notas::where('archivado', true)->get();
    if ($notasArchivadas->count() > 0) {
      return response()->json([
        'success' => true,
        'message' => 'Notas archivadas encontradas',
        'data' => $notasArchivadas
      ], 200);
    } else {
      return response()->json([
        'success' => false,
        'message' => 'No hay notas archivadas',
        'data' => []
      ], 200);
    }
  }
}
