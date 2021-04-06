<ul class="mfb-component--br mfb-zoomin" data-mfb-toggle="hover">
    <li class="mfb-component__wrap">
        <!-- the main menu button -->
        <a onclick="document.getElementById('{{ $form }}').submit()"
            data-mfb-label="@isset($check){{ __('pages.add') }}@endisset @empty($check){{ __('Update Data') }}@endempty"
            class="mfb-component__button--main">
            <!-- the main button icon visibile by default -->
            <i class="mfb-component__main-icon--resting fa fa-plus"></i>
            <!-- the main button icon visibile when the user is hovering/interacting with the menu -->
            <i class="mfb-component__main-icon--active fa fa-plus"></i>
        </a>
        @isset($check)
        <ul class="mfb-component__list">
            <!-- a child button, repeat as many times as needed -->
            <li>
                <a onclick="getPrice()" data-mfb-label="{{ __('pages.check') }}" class="mfb-component__button--child">
                    <i class="mfb-component__child-icon fa fa-check"></i>
                </a>
            </li>
        </ul>
        @endisset
    </li>
</ul>