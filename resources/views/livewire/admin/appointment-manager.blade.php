<div x-data="data()">
    
    <x-wire-card class="mb-8">

        <p class="text-xl font-semibold mb-1 text-slate-800">
            Buscar disponibilidad
        </p>

        <p>
            Encuentra el horario perfecto para tu cita.
        </p>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
            <x-wire-input
                label="Fecha"
                type="date"
                wire:model="search.date"
                placeholder="Selecciona una fecha"
            />

            <div>
                <x-wire-select 
                    label="Hora"
                    wire:model="search.hour"
                    placeholder="Selecciona una hora">

                    @foreach ($this->hourBlocks as $hourBlock)

                        <x-wire-select.option
                            :label="$hourBlock->copy()->format('H:i:s') . ' - ' . $hourBlock->copy()->addHour()->format('H:i:s')"
                            :value="$hourBlock->format('H:i:s')"
                        />

                    @endforeach

                </x-wire-select>
            </div>

            <x-wire-select 
                label="Especialidad (opcional)"
                wire:model="search.speciality_id"
                placeholder="Selecciona una especialidad">

                @foreach ($specialities as $speciality)

                    <x-wire-select.option
                        :label="$speciality->name"
                        :value="$speciality->id"
                    />

                @endforeach

            </x-wire-select>

            <div class="lg:pt-6.5">
                <x-wire-button
                    wire:click="searchAvailability"
                    class="w-full"
                    color="primary"
                >
                    Buscar disponibilidad
                </x-wire-button>
            </div>
        </div>

    </x-wire-card>

    @if ($appointment['date'])
        
        @if (count($availability))

            <div class="grid lg:grid-cols-3 gap-4 lg:gap-8">
                <div class="col-span-1 lg:col-span-2">

                    @foreach ($availability as $doctor)
                        
                        <x-wire-card>

                            <div class="flex items-center space-x-4">
                                <img class="h-16 w-16 rounded-full object-cover" src="{{$doctor->user->profile_photo_url}}" alt="{{$doctor->user->name}}">

                                <div>
                                    <p class="text-xl font-bold text-slate-800">
                                        {{ $doctor->user->name }}
                                    </p>

                                    <p class="text-sm text-indigo-600 font-medium">
                                        {{ $doctor->speciality?->name ?? 'Sin especialidad' }}
                                    </p>
                                </div>
                            </div>

                            <hr class="my-5">

                            <div>
                                <p class="text-sm text-slate-600 mb-2 font-semibold">
                                    Horarios disponibles:
                                </p>


                                <ul class="grid grid-col-1 md:grid-cols-2 lg:grid-cols-4 gap-2">

                                    @foreach ($doctor->schedules as $schedule)
                                        <li>
                                            <x-wire-button
                                                x-on:click="selectSchedule({{$doctor->id}}, '{{$schedule->start_time->format('H:i:s')}}')"
                                                class="w-full">
                                                {{$schedule->start_time->format('H:i:s')}}
                                            </x-wire-button>
                                        </li>
                                    @endforeach

                                </ul>

                            </div>
                        </x-wire-card>

                    @endforeach

                </div>

                <div class="col-span-1">
                    @json($selectedSchedules)
                </div>
            </div>

        @else
            <x-wire-card>
                <p>
                    No hay disponibilidad para la fecha y hora seleccionadas.
                </p>
            </x-wire-card>
        @endif


    @endif

    @push('js')
        
        <script>

            function data() {
                return {
                    selectedSchedules: @entangle('selectedSchedules').live,
                    selectSchedule(doctorId, schedule)
                    {
                        this.selectedSchedules.doctor_id = doctorId;
                        this.selectedSchedules.schedules = schedule;
                    }
                }
            }

        </script>

    @endpush
    
</div>
