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
        <h5 class="mb-4" title="all links"><i class="bi bi-share-fill"> {{ $siteLinks }} </i></h5>
        <h5 class="mb-4 ml-5" title="all clicks"><i class="bi bi-eye-fill"> {{ $siteClicks }} </i></h5>
        <h5 class="mb-4 ml-5" title="all Users"><i class="bi bi bi-person-fill"> {{ $userNumber }}</i></h5>
    </div>

    <div class="mt-5 row">
        <h5 class="mb-4"><i class="bi bi-link"> link: {{ $links }} </i></h5>
        <h5 class="mb-4 ml-5"><i class="bi bi-eye"> click: {{ $clicks }} </i></h5>
    </div>

    <div class="mt-5 row">
        <h2>Visualizaciones</h2>
    </div>

    <div class="mt-2 row">
        <table class="table table-bordered w-50">
            <thead>
                <tr>
                    <th scope="col" class="w-50">Titulo</th>
                    <th scope="col" class="w-50">Link</th>
                </tr>
            </thead>
            <tbody id="links-table-body">
                @foreach ($statistic as $row)
                    <tr data-id="{{ $row->id }}">
                        {{-- <td title="{{ $row->title }}"><span class="sortable-handle"></span>
                            {{ Str::limit($row->row, 30) }}</td> --}}
                        {{-- <td title="{{ $row->title }}">{{ Str::limit($row->title, 30) }}</td> --}}
                        <td class="text-center">{{ $row->title }}</td>
                        <td class="text-right">{{ $row->click_number }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
