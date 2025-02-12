@extends('layouts.sidebar')

@section('content')
    <h2 class="mb-4"><i class="bi bi-person"> Mi perfil</i></h2>

    @foreach ($profile as $profile)
        <form action="{{ route('editProfile') }}" method="post">
            @csrf
            <div class="form-group col-lg-8">
                <h3>Nombre</h3>
                <input type="text" class="form-control" name="name" value="{{ $profile->name }}" required>
            </div>
            <button type="Change " class="mt-3 ml-3 btn btn-info">Cambiar nombre</button>
        </form>

        @if (env('REGISTER_AUTH') != 'verified' or auth()->user()->role == 'admin')
            <br><br>
            <form action="{{ route('editProfile') }}" method="post">
                @csrf
                <div class="form-group col-lg-8">
                    <h3>Email</h3>
                    <input type="email" class="form-control" name="email" value="{{ $profile->email }}" required>
                </div>
                <button type="Change " class="mt-3 ml-3 btn btn-info">Cambiar email</button>
            </form>
        @endif

        <br><br>
        <form action="{{ route('editProfile') }}" method="post">
            @csrf
            <div class="form-group col-lg-8">
                <h3>Password</h3>
                <input type="password" name="password" class="form-control" placeholder="At least 8 characters" required>
            </div>
            <button type="Change " class="mt-3 ml-3 btn btn-info">Cambiar contraseña</button>
        </form>

        @csrf
        <br><br>
        <div class="form-group col-lg-8">
            <h3>Rol</h3>
            <input type="text" class="form-control" value="{{ strtoupper($profile->role) }}" readonly>
        </div>
    @endforeach
@endsection
