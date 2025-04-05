@extends('Juegos.form')
@section('formName')
    Crear
@endsection
@section('action')
    action = "{{route('juegos.store')}}"
@endsection