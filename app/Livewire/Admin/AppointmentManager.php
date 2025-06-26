<?php

namespace App\Livewire\Admin;

use App\Models\Speciality;
use App\Services\AppointmentService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AppointmentManager extends Component
{
    public $search = [
        'date' => '',
        'hour' => '',
        'speciality_id' => '',
    ];

    public $selectedSchedules = [
        'doctor_id' => '',
        'schedules' => [],
    ];

    public $specialities = [];

    public $availabilities = [];

    public $appointment = [
        'patient_id' => '',
        'doctor_id' => '',
        'date' => '',
        'start_time' => '',
        'end_time' => '',
        'duration' => '',
        'reason' => ''
    ];

    public function mount()
    {
        $this->specialities = Speciality::all();
        $this->search['date'] = now()->hour >= 12
            ? now()->addDay()->format('Y-m-d')
            : now()->format('Y-m-d');
    }

    #[Computed()]
    public function hourBlocks()
    {
        return CarbonPeriod::create(
            Carbon::createFromTimeString(config('schedule.start_time')),
            '1 hour',
            Carbon::createFromTimeString(config('schedule.end_time'))
        )->excludeEndDate();
    }

    public function searchAvailability(AppointmentService $service)
    {
        $this->validate([
            'search.date' => 'required|date|after_or_equal:today',
            'search.hour' => [
                'required',
                'date_format:H:i:s',
                Rule::when($this->search['date'] === now()->format('Y-m-d'), [
                    'after_or_equal:' . now()->format('H:i:s'),
                ])
            ],
        ]);

        $this->appointment['date'] = $this->search['date'];

        //Buscar disponibilidad
        $this->availabilities = $service->searchAvailability(...$this->search);
    }

    public function render()
    {
        return view('livewire.admin.appointment-manager');
    }
}
