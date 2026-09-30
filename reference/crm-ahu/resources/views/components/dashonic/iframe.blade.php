<x-dashonic-horizontal-layout sidebar="0" with-sidebar="0" with-header="0" with-footer="0">
    <x-slot name="css">
        {{ $css ?? "" }}
    </x-slot>
    <x-slot name="preloader">
        {{ $preloader ?? "" }}
    </x-slot>

    {{ $slot }}

    <x-slot name="js">
        {{ $js ?? "" }}
    </x-slot>
</x-dashonic-horizontal-layout>
