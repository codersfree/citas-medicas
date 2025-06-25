@props(['tab' => 'default'])

<div x-show="active === '{{ $tab }}'">
    {{ $slot }}
</div>