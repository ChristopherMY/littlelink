<title>Backup</title>
@extends('layouts.updater')

@Push('updater-body')
    <div class="container">

        @if ($_SERVER['QUERY_STRING'] === '')
            <?php //landing page
            ?>

            <div class="logo-container fadein">
                <img class="logo-img" src="{{ asset('littlelink/images/just-gear.svg') }}" alt="Logo">
                <div class="logo-centered">l</div>
            </div>
            <h1>Backup</h1>
            <h4 class="">Puede hacer una copia de seguridad de toda su instancia:</h4>
            <h5 class="">El sistema de copia de seguridad no guardará más de dos copias de seguridad a la vez.</h5>
            <br>
            <div class="row">
                &ensp;<a class="btn" href="{{ url()->current() }}/?backup"><button><i class="fa-solid fa-floppy-disk"></i>
                        Instancia de respaldo</button></a>&ensp;
                &ensp;<a class="btn" href="{{ route('showBackups') }}"><button><i class="fa-solid fa-box-archive"></i>
                        Todas las copias de seguridad</button></a>&ensp;
            </div>
        @endif


        @if ($_SERVER['QUERY_STRING'] === 'backup')
            <?php //creating backup...
            ?>
            @Push('updater-head')
                <meta http-equiv="refresh" content="2; URL={{ url()->current() }}/?backups" />
            @endpush
            <div class="logo-container fadein">
                <img class="logo-img loading" src="{{ asset('littlelink/images/just-gear.svg') }}" alt="Logo">
                <div class="logo-centered">l</div>
            </div>
            <h1 class="loadingtxt">Crear copia de seguridad</h1>
        @endif

        @if ($_SERVER['QUERY_STRING'] === 'backups')
            <?php Artisan::call('backup:clean');
            Artisan::call('backup:run', ['--only-files' => true]);
            $tst = base_path('backups/');
            file_put_contents($tst . 'CANUPDATE', '');
            $URL = Route::current()->getName();
            header('Location: ' . $URL . '?success');
            exit(); ?>
        @endif

        @if ($_SERVER['QUERY_STRING'] === 'success')
            <?php //after successfully updating
            ?>

            <div class="logo-container fadein">
                <img class="logo-img" src="{{ asset('littlelink/images/just-gear.svg') }}" alt="Logo">
                <div class="logo-centered">l</div>
            </div>
            <h1>Success!</h1>
            <h4 class="">La copia de seguridad se realizó correctamente, ahora puede volver al Panel de administración
                o ver todas sus copias de seguridad.
            </h4>
            <br>
            <div class="row">
                &ensp;<a class="btn" href="{{ route('studioIndex') }}"><button><i
                            class="fa-solid fa-house-laptop btn"></i> Admin Panel</button></a>&ensp;
                &ensp;<a class="btn" href="{{ route('showBackups') }}"><button><i class="fa-solid fa-box-archive"></i>
                        Todas las copias de seguridad</button></a>&ensp;
            </div>
        @endif

    </div>
@endpush
