<x-admin-layout title="Pacientes | Coders Free" :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'href' => route('admin.dashboard'),
    ],
    [
        'name' => 'Pacientes',
        'href' => route('admin.patients.index'),
    ],
    [
        'name' => 'Editar',
    ],
]">

    <form action="{{ route('admin.patients.update', $patient) }}" method="POST">

        @csrf
        @method('PUT')

        <x-wire-card class="mb-8">

            <div class="lg:flex lg:justify-between lg:items-center">
                <div class="flex items-center space-x-5">
                    <img src="{{ $patient->user->patient->user->profile_photo_url }}"
                        class="h-20 w-20 rounded-full object-cover object-center" alt="{{ $patient->user->name }}">


                    <div>
                        <p class="text-2xl font-bold text-gray-900">
                            {{ $patient->user->name }}
                        </p>
                    </div>
                </div>

                <div class="flex space-x-3 mt-6 lg:mt-0">
                    <x-wire-button outline gray href="{{ route('admin.patients.index') }}">
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
            {{-- Tabs --}}
            <div x-data="{
                tab: 'datos-personales',
            }">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                        <li class="me-2">
                            <a href="#"
                                x-on:click="tab = 'datos-personales'"
                                :class="{
                                    'inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group': tab === 'datos-personales',
                                    'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group': tab !== 'datos-personales'
                                }">
                                <i class="fa-solid fa-user me-2"></i>
                                Datos personales
                            </a>
                        </li>
                        <li class="me-2">
                            <a href="#"
                                x-on:click="tab = 'antecedentes'"
                                :class="{
                                    'inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group': tab === 'antecedentes',
                                    'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group': tab !== 'antecedentes'
                                }"
                                aria-current="page">
                                <i class="fa-solid fa-file-lines me-2"></i>
                                Antecedentes
                            </a>
                        </li>
                        <li class="me-2">
                            <a href="#"
                                x-on:click="tab = 'informacion-general'"
                                :class="{
                                    'inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group': tab === 'informacion-general',
                                    'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group': tab !== 'informacion-general'
                                }"
                                >
                                <i class="fa-solid fa-info me-2"></i>
                                Información general
                            </a>
                        </li>
                        <li class="me-2">
                            <a href="#"
                                x-on:click="tab = 'contacto-emergencia'"
                                :class="{
                                    'inline-flex items-center justify-center p-4 text-blue-600 border-b-2 border-blue-600 rounded-t-lg active dark:text-blue-500 dark:border-blue-500 group': tab === 'contacto-emergencia',
                                    'inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group': tab !== 'contacto-emergencia'
                                }"
                                >
                                <i class="fa-solid fa-heart me-2"></i>
                                Contacto de Emergencia
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="px-4 mt-4">

                    {{-- Datos personales --}}
                    <div x-show="tab === 'datos-personales'">
                        <x-wire-alert info title="Edicion de usuario" class="mb-4">
                            
                            <p>
                                Para editar esta información, dirigete al 
                                <a href="{{ route('admin.users.edit', $patient->user) }}" 
                                    class="text-blue-600 hover:underline" 
                                    target="_blank">
                                    perfil del usuario
                                </a> 
                                asociado a este paciente.
                            </p>
                            
                        </x-wire-alert>

                        <div class="grid lg:grid-cols-2 gap-4">
                            <div>
                                <span class="text-gray-500 font-semibold text-sm">
                                    Teléfono:
                                </span>
                                
                                <span class="text-gray-900 text-sm ml-1">
                                    {{ $patient->user->phone }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-500 font-semibold text-sm">
                                    Email:
                                </span>

                                <span class="text-gray-900 text-sm ml-1">
                                    {{ $patient->user->email }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-500 font-semibold text-sm">
                                    Dirección:
                                </span>

                                <span class="text-gray-900 text-sm ml-1">
                                    {{ $patient->user->address }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Antecedentes --}}
                    <div x-show="tab === 'antecedentes'">
                        
                        <div class="grid lg:grid-cols-2 gap-4">

                            <div>
                                <x-wire-textarea
                                    label="Alergias conocidas"
                                    name="allergies">
                                    {{ old('allergies', $patient->allergies) }}
                                </x-wire-textarea>
                            </div>
                            <div>
                                <x-wire-textarea
                                    label="Enfermedades cronicas"
                                    name="chronic_conditions">
                                    {{ old('chronic_conditions', $patient->chronic_conditions) }}
                                </x-wire-textarea>
                            </div>
                            <div>
                                <x-wire-textarea
                                    label="Antecedentes quirúrgicos"
                                    name="surgical_history">
                                    {{ old('surgical_history', $patient->surgical_history) }}
                                </x-wire-textarea>
                            </div>
                            <div>
                                <x-wire-textarea
                                    label="Antecedentes familiares"
                                    name="family_history">
                                    {{ old('family_history', $patient->family_history) }}
                                </x-wire-textarea>
                            </div>

                        </div>

                    </div>

                    {{-- Información general --}}
                    <div x-show="tab === 'informacion-general'">
                        <x-wire-native-select
                            label="Tipo de sangre"
                            name="blood_type_id"
                            class="mb-4"
                        >
                            <option value="">
                                Selecciona un tipo de sangre
                            </option>

                            @foreach ($bloodTypes as $bloodType)
                                
                                <option value="{{$bloodType->id}}" @selected($bloodType->id === $patient->blood_type_id)>
                                    {{ $bloodType->name }}
                                </option>

                            @endforeach

                        </x-wire-native-select>

                        <x-wire-textarea
                            label="Observaciones"
                            name="observations"
                        >
                            {{ old('observations', $patient->observations) }}
                        </x-wire-textarea>
                    </div>

                    {{-- Contacto de Emergencia --}}
                    <div x-show="tab === 'contacto-emergencia'">
                        <div class="space-y-4">
                            <x-wire-input
                                label="Nombre del contacto"
                                name="emergency_contact_name"
                                value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                            />

                            <x-wire-input
                                label="Teléfono del contacto"
                                name="emergency_contact_phone"
                                value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}"
                            />

                            <x-wire-input
                                label="Relación con el contacto"
                                name="emergency_contact_relationship"
                                value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </x-wire-card>


    </form>

</x-admin-layout>
