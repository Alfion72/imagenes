<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class JuegoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $juegos = Juego::all();
        return view('juegos.index',compact('juegos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('juegos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'levels'=>'required|numeric',
            'release'=>'required|date',
            'image'=>'required|image',
        ]);

        $juego = Juego::create($request->all());

        if($request->hasFile('image')){
            $nombre = $juego->id.'.'.$request->file('image')->getClientOriginalExtension();
            $img = $request->file('image')->storeAs('img', $nombre, 'public');
            $juego->image = 'img/'.$nombre;
            $juego->save();
        }
                
        return redirect()->route('juegos.index')->with('success', 'Juego creado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Juego $juego)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Juego $juego)
    {
        return view('juegos.edit',compact('juego'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Juego $juego)
    {
        $request->validate([
            'name'=>'required',
            'levels'=>'required|numeric',
            'release'=>'required|date',
        ]);

        if($request->hasFile('image')){
            Storage::disk('public')->delete($juego->image);
            $nombre = $juego->id.'.'.$request->file('image')->getClientOriginalExtension();
            $img = $request->file('image')->storeAs('img', $nombre, 'public');
            $juego->image = 'img/'.$nombre;
            $juego->save();
        }
        

        $juego->update($request->input());
        return redirect()->route('juegos.index')->with('success', 'Juego actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Juego $juego)
    {
        Storage::disk('public')->delete($juego->image);
        $juego->delete();
        return redirect()->route('juegos.index')->with('success', 'Juego eliminado');
    }
}
