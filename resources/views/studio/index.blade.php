@extends('layouts.sidebar')

@section('content')
    @if ($littlelink_name == '')
        <h2 class="mb-4"> 👋 Hola, stranger</h2>
        <h5>No tiene establecida una URL de página, pero puede cambiarla en el <a href="{{ url('/studio/page') }}">Sección de
                página</a></h5>
    @else
        <h2 class="mb-4"> 👋 Hola, @<?= $littlelink_name ?></h2>
    @endif
    <p>
        Bienvenido a {{ config('app.name') }}!
    </p>
    <div class="mt-5 row">
        <h5 class="mb-4"><i class="bi bi-link"> link: {{ $links }} </i></h5>
        <h5 class="mb-4 ml-5"><i class="bi bi-eye"> click: {{ $clicks }} </i></h5>
    </div>

@endsection
