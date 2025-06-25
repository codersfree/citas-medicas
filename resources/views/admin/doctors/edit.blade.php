<x-admin-layout title="Doctores | Coders Free" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Doctores',
        'href' => route('admin.doctors.index'),
    ],
    [
        'name' => 'Editar',
    ],
]">

    <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST">
        @csrf
        @method('PUT')

        <x-wire-card class="mb-8">

            <div class="lg:flex lg:justify-between lg:items-center">
                <div class="flex items-center space-x-5">
                    <img src="{{ $doctor->user->profile_photo_url }}"
                        class="h-20 w-20 rounded-full object-cover object-center" alt="{{ $doctor->user->name }}">

                    <div>
                        <p class="text-2xl font-bold text-gray-900 mb-1">
                            {{ $doctor->user->name }}
                        </p>

                        <p class="text-sm font-semibold text-gray-500">
                            Licencia: {{ $doctor->medical_license_number ?? 'N/A' }}
                        </p>
                    </div>
                </div>

                <div class="flex space-x-3 mt-6 lg:mt-0">
                    <x-wire-button outline gray href="{{ route('admin.doctors.index') }}">
                        Volver
                    </x-wire-button>

                    <x-wire-button type="submit">
                        <i class="fa-solid fa-check"></i>
                        Guardar cambios
                    </x-wire-button>
                </div>
            </div>

        </x-wire-card>

        <x-wire-card>

            <div class="space-y-4">

                <x-wire-native-select
                    label="Especialidad"
                    name="speciality_id"
                    >
                    <option value="">
                        Selecciona una especialidad
                    </option>

                    @foreach ($specialities as $speciality)
                        <option value="{{ $speciality->id }}" @selected($speciality->id == old('speciality_id', $doctor->speciality_id))>
                            {{ $speciality->name }}
                        </option>
                    @endforeach
                </x-wire-native-select>

                <x-wire-input
                    label="Número de licencia médica"
                    name="medical_license_number"
                    value="{{ old('medical_license_number', $doctor->medical_license_number) }}"
                    placeholder="Número de licencia médica"
                />

                <x-wire-textarea
                    label="Biografía"
                    name="biography"
                    placeholder="Escribe una breve biografía del doctor">
                    {{ old('biography', $doctor->biography) }}
                </x-wire-textarea>

                <x-wire-native-select
                    label="Estado"
                    name="active">

                    <option value="1" @selected(old('active', $doctor->active) == 1)>
                        Activo
                    </option>

                    <option value="0" @selected(old('active', $doctor->active) == 0)>
                        Inactivo
                    </option>

                </x-wire-native-select>
            </div>

        </x-wire-card>
    </form>

</x-admin-layout>
