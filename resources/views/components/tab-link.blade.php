@props(['tab' => 'default'])

<li class="me-2">
    <a href="#" x-on:click="active = '{{$tab}}'"
        :class="{
            'inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group': active === '{{$tab}}',
            'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group': active !== '{{$tab}}'
        }">
        {{ $slot }}
    </a>
</li>