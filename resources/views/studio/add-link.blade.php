@extends('layouts.sidebar')

@section('content')
    <h2 class="mb-4"><i class="bi bi-plus"> Añadir Link</i></h2>

    <form action="{{ route('addLink') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="form-group col-lg-8">
            <label>Link*</label>
            <input type="text" name="link" class="form-control" placeholder="https://example.com" required>
        </div>
        <div class="form-group col-lg-8">
            <label>Titulo</label>
            <input type="text" name="title" class="form-control" placeholder="Internal name (optional)">
        </div>
        <div class="form-group col-lg-8">
            <label for="exampleFormControlSelect1">Button*</label>
            <select class="form-control" name="button">
                <option style="background-color:#ffe8e4;"> custom </option>
                <option style="background-color:#ffe8e4;"> custom_website </option>
                @foreach ($buttons as $button)
                    @if (!in_array($button->name, ['custom', 'custom_website', 'heading', 'space']))
                        <option> {{ $button->name }} </option>
                    @endif
                @endforeach
                <option style="background-color:#ebebeb;"> heading </option>
                <option style="background-color:#ebebeb;"> space </option>
            </select>
        </div>
        <div class="form-group col-lg-8">

            <label>Icono *</label>
            <input type="file" class="form-control" name="image">

            <br>
            <label>* Campos requeridos</label><br>

            <div class="row">
                <button type="submit" class="mt-3 ml-3 btn btn-info">Guardar</button>
                <a style="color:white;background-color:#f8b739;" class="mt-3 ml-3 btn" href="{{ url('/studio/links') }}">Ver
                    links</a>
            </div>
        </div>
    </form>

    <br><br>
    <details>
        <summary>Más información</summary>
        <pre style="color: grey;">
El botón 'Personalizado' le permite agregar un enlace personalizado, donde el texto del botón se determina con el título del enlace establecido anteriormente.
El botón 'Custom_website' funciona de manera similar al botón Personalizado, con la adición de una función que solicita el favicon de la URL elegida y lo usa como el icono del botón.

El botón 'Espacio' se reemplazará con un espacio vacío, por lo que los botones se pueden separar visualmente en grupos. Ingresar un número entre 1 y 10 en la sección de título cambiará la distancia del espacio vacío.
El botón 'Título' se reemplazará con un subtítulo, donde el título define el texto de ese encabezado.
</pre>
    </details>
@endsection
