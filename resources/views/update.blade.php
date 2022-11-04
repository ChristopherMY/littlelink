@extends('layouts.updater')

@Push('updater-body')
    <div class="container">

        <?php // Requests newest version from server and sets it as variable
        $Vgit = file_get_contents('https://version.littlelink-custom.com/');
        
        // Requests current version from the local version file and sets it as variable
        $Vlocal = file_get_contents(base_path('version.json'));
        ?>
        @if (auth()->user()->role == 'admin' and $Vgit > $Vlocal or env('JOIN_BETA') === true)

            @if ($_SERVER['QUERY_STRING'] === '')
                <?php //landing page
                ?>

                <div class="logo-container fadein">
                    <img class="logo-img" src="{{ asset('littlelink/images/just-gear.svg') }}" alt="Logo">
                    <div class="logo-centered">l</div>
                </div>
                <h1>Updater</h1>
                @if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
                    @if (env('JOIN_BETA') === true)
                        <p><?php echo 'Ultima versión beta= ' . file_get_contents('https://update.littlelink-custom.com/beta/vbeta.json'); ?></p>
                        <p><?php if (file_exists(base_path('vbeta.json'))) {
                            echo 'Versión beta instalada= ' . file_get_contents(base_path('vbeta.json'));
                        } else {
                            echo 'Versión beta instalada= none';
                        } ?></p>
                        <p><?php if ($Vgit > $Vlocal) {
                            echo 'Necesitas actualizar a la última versión de la línea principal';
                        } else {
                            echo 'Está ejecutando la última versión principal';
                        } ?></p>
                    @else
                        <h4 class="">Puede actualizar su instalación automáticamente o descargar la actualización e
                            instalar manualmente:</h4>
                        <h5 class="">Los usuarios de Windows pueden usar el actualizador alternativo. Este actualizador
                            no creará una copia de seguridad. Úselo a su propia discreción.</h5>
                    @endif
                    <br>
                    <div class="row">
                        &ensp;<a class="btn" href="{{ url()->current() }}/?updating-windows"><button><i
                                    class="fa-solid fa-user-gear btn"></i> Actualizar automáticamente</button></a>&ensp;
                        &ensp;<a class="btn" href="https://littlelink-custom.com/update" target="_blank"><button><i
                                    class="fa-solid fa-download btn"></i> Actualizar manualmente</button></a>&ensp;
                    </div>
                @else
                    @if (env('JOIN_BETA') === true)
                        <p><?php echo 'latest beta version= ' . file_get_contents('https://update.littlelink-custom.com/beta/vbeta.json'); ?></p>
                        <p><?php if (file_exists(base_path('vbeta.json'))) {
                            echo 'Installed beta version= ' . file_get_contents(base_path('vbeta.json'));
                        } else {
                            echo 'Installed beta version= none';
                        } ?></p>
                        <p><?php if ($Vgit > $Vlocal) {
                            echo 'You need to update to the latest mainline release';
                        } else {
                            echo "You're running the latest mainline release";
                        } ?></p>
                    @else
                        <h4 class="">Puede actualizar su instalación automáticamente o descargar la actualización e
                            instalarla manualmente:</h4>
                    @endif
                    <br>
                    <div class="row">
                        @if (env('SKIP_UPDATE_BACKUP') == true)
                            &ensp;<a class="btn" href="{{ url()->current() }}/?updating"><button><i
                                        class="fa-solid fa-user-gear btn"></i> Actualizar automáticamente</button></a>&ensp;
                        @else
                            &ensp;<a class="btn" href="{{ url()->current() }}/?backup"><button><i
                                        class="fa-solid fa-user-gear btn"></i> Actualizar automáticamente</button></a>&ensp;
                        @endif
                        &ensp;<a class="btn" href="https://littlelink-custom.com/update" target="_blank"><button><i
                                    class="fa-solid fa-download btn"></i> Actualizar manualmente</button></a>&ensp;
                    </div>
                @endif

            @endif


            @if ($_SERVER['QUERY_STRING'] === 'updating-windows' and strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
                <?php //updating on Windows
                ?>
                <div class="logo-container fadein">
                    <img class="logo-img loading" src="{{ asset('littlelink/images/just-gear.svg') }}" alt="Logo">
                    <div class="logo-centered">l</div>
                </div>
                <h1 class="loadingtxt">Actualizando</h1>
                @Push('updater-head')
                    <meta http-equiv="refresh" content="2; URL={{ url()->current() }}/?updating-windows-bat" />
                @endpush
            @endif

            @if ($_SERVER['QUERY_STRING'] === 'updating-windows-bat' and strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
                <?php //updating on Windows
                ?>
                <?php
                
                // Download the zip file
                
                $latestversion = trim(file_get_contents('https://raw.githubusercontent.com/JulianPrieber/littlelink-custom/main/version.json'));
                
                if (env('JOIN_BETA') === true) {
                    $fileUrl = 'https://update.littlelink-custom.com/beta/' . $latestversion . '.zip';
                } else {
                    $fileUrl = 'https://update.littlelink-custom.com/' . $latestversion . '.zip';
                }
                
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $fileUrl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($curl);
                curl_close($curl);
                
                file_put_contents(base_path('storage/update.zip'), $result);
                
                $zip = new ZipArchive();
                $zip->open(base_path() . '/storage/update.zip');
                $zip->extractTo(base_path());
                $zip->close();
                unlink(base_path() . '/storage/update.zip');
                
                echo "<meta http-equiv=\"refresh\" content=\"0; " . url()->current() . "/?finishing\" />";
                
                ?>
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
                <h1 class="loadingtxt">Creating backup</h1>
            @endif

            @if ($_SERVER['QUERY_STRING'] === 'backups')
                <?php Artisan::call('backup:clean');
                Artisan::call('backup:run', ['--only-files' => true]);
                $tst = base_path('backups/');
                file_put_contents($tst . 'CANUPDATE', '');
                $URL = Route::current()->getName();
                header('Location: ' . $URL . '?updating');
                exit(); ?>
            @endif

            @if ($_SERVER['QUERY_STRING'] === 'updating' and
                (file_exists(base_path('backups/CANUPDATE')) or env('SKIP_UPDATE_BACKUP') == true))
                <?php //updating...
                ?>
                <div class="logo-container fadein">
                    <img class="logo-img loading" src="{{ asset('littlelink/images/just-gear.svg') }}" alt="Logo">
                    <div class="logo-centered">l</div>
                </div>
                <h1 class="loadingtxt">Updating</h1>
                @Push('updater-head')
                    <meta http-equiv="refresh" content="2; URL={{ url()->current() }}/../updating" />
                @endpush
            @endif
        @elseif($_SERVER['QUERY_STRING'] === '')
            <?php //if no new version available
            ?>

            <div class="logo-container fadein">
                <img class="logo-img" src="{{ asset('littlelink/images/just-gear.svg') }}" alt="Logo">
                <div class="logo-centered">l</div>
            </div>
            <h1>Sin nueva versión</h1>
            <h4 class="">No hay nueva versión disponible</h4>
            <br>
            <div class="row">
                &ensp;<a class="btn" href="{{ route('studioIndex') }}"><button><i
                            class="fa-solid fa-house-laptop btn"></i> Admin Panel</button></a>&ensp;
            </div>

        @endif

        @if ($_SERVER['QUERY_STRING'] === 'finishing')
            <?php //finishing up update
            ?>
            <div class="logo-container fadein">
                <img class="logo-img loading" src="{{ asset('littlelink/images/just-gear.svg') }}" alt="Logo">
                <div class="logo-centered">l</div>
            </div>
            <h1 class="loadingtxt">Terminando</h1>

            @include('components.finishing')

            <?php if (file_exists(base_path('storage/MAINTENANCE'))) {
                unlink(base_path('storage/MAINTENANCE'));
            } ?>
        @endif

        @if ($_SERVER['QUERY_STRING'] === 'success')
            <?php //after successfully updating
            ?>

            <div class="logo-container fadein">
                <img class="logo-img" src="{{ asset('littlelink/images/just-gear.svg') }}" alt="Logo">
                <div class="logo-centered">l</div>
            </div>
            <h1>Success!</h1>
            @if (env('JOIN_BETA') === true)
                <p><?php echo 'última versión beta= ' . file_get_contents('https://update.littlelink-custom.com/beta/vbeta.json'); ?></p>
                <p><?php if (file_exists(base_path('vbeta.json'))) {
                    echo 'Versión beta instalada= ' . file_get_contents(base_path('vbeta.json'));
                } else {
                    echo 'Versión beta instalada= none';
                } ?></p>
                <p><?php if ($Vgit > $Vlocal) {
                    echo 'Necesitas actualizar a la última versión de la línea principal';
                } else {
                    echo 'Está ejecutando la última versión principal';
                } ?></p>
            @else
                <h4 class="">La actualización fue exitosa, ahora puede regresar al Panel de administración.</h4>
                <style>
                    .noteslink:hover {
                        color: #006fd5;
                        text-shadow: 0px 6px 7px rgba(23, 10, 6, 0.66);
                    }
                </style>
                <a class="noteslink" href="https://github.com/JulianPrieber/littlelink-custom/releases/latest"
                    target="_blank"><i class="fa-solid fa-up-right-from-square"></i> Ver las notas de la versión</a>
                <br>
            @endif
            <br>
            <div class="row">
                &ensp;<a class="btn" href="{{ route('studioIndex') }}"><button><i
                            class="fa-solid fa-house-laptop btn"></i> Admin Panel</button></a>&ensp;

                @if (env('JOIN_BETA') === true)
                    &ensp;<a class="btn" href="{{ url()->current() }}/"><button><i
                                class="fa-solid fa-arrow-rotate-right btn"></i> Corre de nuevo</button></a>&ensp;
                @endif
            </div>
        @endif

        @if ($_SERVER['QUERY_STRING'] === 'error')
            <?php //on error
            ?>

            <?php if (file_exists(base_path('storage/MAINTENANCE'))) {
                unlink(base_path('storage/MAINTENANCE'));
            } ?>

            <div class="logo-container fadein">
                <img class="logo-img" src="{{ asset('littlelink/images/just-gear.svg') }}" alt="Logo">
                <div class="logo-centered">l</div>
            </div>
            <h1>Error</h1>
            <h4 class="">Algo salió mal con la actualización :(</h4>
            <br>
            <div class="row">
                &ensp;<a class="btn" href="{{ route('studioIndex') }}"><button><i
                            class="fa-solid fa-house-laptop btn"></i> Admin Panel</button></a>&ensp;
            </div>
        @endif

        @if ('8' > phpversion())
            <br><br><a style="background-color:tomato;color:#fff;border-radius:5px;" class="nav-link"
                href="{{ url('/studio/profile') }}" target=""><i class="bi bi-exclamation-circle-fill"></i>
                <strong>¡Está utilizando una versión obsoleta de PHP! Terminará el soporte oficial para esta versión.
                    pronto.</strong></a>
        @endif
    </div>

@endpush
