<div class="container">
    <div class="footer fadein" style="margin:5% 0px 35px 0px;">
        @if (env('DISPLAY_FOOTER') === true)
            @if (config('advanced-config.display_link_home') != 'false')<a class="footer-hover spacing"
                    @if (config('advanced-config.custom_link_home') != '') href="{{ config('advanced-config.custom_link_home') }}"@else href="{{ url('') }}/" @endif>
                    @if (config('advanced-config.custom_text_home') != '')
                        {{ config('advanced-config.custom_text_home') }}
                    @else
                        Home
                    @endif
                </a>@endif
            @if (config('advanced-config.display_link_terms') != 'false')
                <a class="footer-hover spacing" href="{{ url('') }}/pages/terms">Terminos</a>
            @endif
            @if (config('advanced-config.display_link_privacy') != 'false')
                <a class="footer-hover spacing" href="{{ url('') }}/pages/privacy">Privacidad</a>
            @endif
            @if (config('advanced-config.display_link_contact') != 'false')
                <a class="footer-hover spacing" href="{{ url('') }}/pages/contact">Contacto</a>
            @endif
        @endif
    </div>

    @if (env('DISPLAY_CREDIT') === true)
        <div class="credit-footer"><a style="text-decoration: none;" class="spacing"
                href="https://littlelink-custom.com" target="_blank" title="Learn more">
                <section class="credit-hover hvr-grow fadein">
                    <div class="parent-footer credit-icon">
                        <img id="footer_spin" class="footer_spin image-footer1 generic"
                            src="{{ asset('littlelink/images/avatar@2x.png') }}" alt="LittleLink"></img>
                        <img class="image-footer2" src="{{ asset('littlelink/images/avatar@2x.png') }}"
                            alt="LittleLink"></img>
                    </div>

                    <a href="https://littlelink-custom.com" target="_blank" title="Aprender más"
                        class="credit-txt credit-txt-clr credit-text">Desarrollado por Mundo Negocio</a>
                </section>
            </a>
        </div><br><br><br>
    @endif
</div>
