<x-admin-layout
title="Usuarios | Coders Free"
:breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',
        'href' => route('admin.users.index'),
    ],
    [
        'name' => 'Nuevo'
    ]
]">
    
    <x-wire-card>

        <form action="{{route('admin.users.store')}}" method="POST">
            @csrf

            <div class="space-y-4">

                <div class="grid lg:grid-cols-2 gap-4">

                    <x-wire-input
                        name="name"
                        label="Nombre"
                        required
                        :value="old('name')"
                        placeholder="Ingrese el nombre del usuario"
                        />
    
                    <x-wire-input
                        name="email"
                        label="Correo Electrónico"
                        type="email"
                        required
                        :value="old('email')"
                        placeholder="Ingrese el correo electrónico del usuario"
                        />
    
                    <x-wire-input
                        name="password"
                        label="Contraseña"
                        type="password"
                        required
                        placeholder="Ingrese la contraseña del usuario"
                        />
    
                    <x-wire-input
                        name="password_confirmation"
                        label="Confirmar Contraseña"
                        type="password"
                        required
                        placeholder="Confirme la contraseña del usuario"
                        />
                        {{-- DNI --}}
                        <x-wire-input
                            name="dni"
                            label="DNI"
                            required
                            :value="old('dni')"
                            placeholder="Ingrese el DNI del usuario"
                            />
        
                        {{-- Phone --}}
                        <x-wire-input
                            name="phone"
                            label="Teléfono"
                            required
                            :value="old('phone')"
                            placeholder="Ingrese el teléfono del usuario"
                            />
                </div>

                {{-- Address --}}
                <x-wire-input
                    name="address"
                    label="Dirección"
                    required
                    :value="old('address')"
                    placeholder="Ingrese la dirección del usuario"
                />

                {{-- Role --}}
                <x-wire-native-select
                    label="Rol"
                    name="role_id">

                    <option value="">
                        Seleccione un rol
                    </option>

                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}"
                            @selected(old('role_id') == $role->id)
                        >
                            {{ $role->name }}
                        </option>
                    @endforeach
                </x-wire-native-select>

                <div class="flex justify-end">
                    <x-wire-button type="submit">
                        Guardar
                    </x-wire-button>
                </div>
            </div>


        </form>

    </x-wire-card>

</x-admin-layout>