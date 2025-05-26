<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Tutor;
use App\Models\Estudiante;

class GrupoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin')->except(['show']);
    }

    public function index()
    {
        $grupos = Grupo::with(['tutor', 'estudiantes'])->get();
        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
         $tutores = Tutor::where('estado', 'contratado')->get();
        $estudiantes = Estudiante::where('estado', 'activo')->get();
        return view('grupos.create', compact('tutores', 'estudiantes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo_tutor' => 'required|exists:tutores,codigo',
            'estudiantes' => 'array',
            'estudiantes.*' => 'exists:estudiantes,codigo',
        ]);

        $grupo = Grupo::create([
            'nombre' => $request->nombre,
            'codigo_tutor' => $request->codigo_tutor,
        ]);

        if ($request->has('estudiantes')) {
            $grupo->estudiantes()->attach($request->estudiantes);
        }

        return redirect()->route('grupos.index')->with('success', 'Grupo creado exitosamente.');
    }

    public function show(Grupo $grupo)
    {
        return view('grupos.show', compact('grupo'));
    }

    public function edit(Grupo $grupo)
    {
        $tutores = Tutor::where('estado', 'contratado')->get();
        $estudiantes = Estudiante::where('estado', 'activo')->get();
        $estudiantesSeleccionados = $grupo->estudiantes->pluck('codigo')->toArray();
        return view('grupos.edit', compact('grupo', 'tutores', 'estudiantes', 'estudiantesSeleccionados'));
    }

    public function update(Request $request, Grupo $grupo)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo_tutor' => 'required|exists:tutores,codigo',
            'estudiantes' => 'array',
            'estudiantes.*' => 'exists:estudiantes,codigo',
        ]);

        $grupo->update([
            'nombre' => $request->nombre,
            'codigo_tutor' => $request->codigo_tutor,
        ]);

        $grupo->estudiantes()->sync($request->estudiantes ?? []);

        return redirect()->route('grupos.index')->with('success', 'Grupo actualizado exitosamente.');
    }

    public function destroy(Grupo $grupo)
    {
        $grupo->estudiantes()->detach();
        $grupo->delete();
        return redirect()->route('grupos.index')->with('success', 'Grupo eliminado exitosamente.');
    }
}
