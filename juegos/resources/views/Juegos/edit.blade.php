@extends('Juegos.form')
@section('formName')
    Editar a <b>{{$juego->name}}</b>
@endsection
@section('action')
    action = "{{route('juegos.update',$juego)}}"
@endsection
@section('method') @method('PUT') @endsection