<x-admin-layout
title="Citas | Coders Free"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Citas',
    ]
]">

    <x-slot name="action">
        <x-wire-button blue href="{{ route('admin.appointments.create') }}">
            <i class="fa-solid fa-plus"></i>
            Nuevo
        </x-wire-button>
    </x-slot>

</x-admin-layout>