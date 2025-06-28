<?php

namespace App\Livewire\Admin;

use App\Models\Appointment;
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

    public function updated($property, $value)
    {
        if($property === 'selectedSchedules')
        {
            $this->fillAppointment($value);
        }
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

    #[Computed()]
    public function doctorName()
    {
        return $this->appointment['doctor_id']
            ? $this->availabilities[$this->appointment['doctor_id']]['doctor']->user->name
            : 'Por definir';
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

    public function fillAppointment($selectedSchedules)
    {
        $schedules = collect($selectedSchedules['schedules'])
            ->sort()
            ->values();

        if ($schedules->count()) {
            $this->appointment['doctor_id'] = $selectedSchedules['doctor_id'];
            $this->appointment['start_time'] = $schedules->first();
            $this->appointment['end_time'] = Carbon::parse($schedules->last())->addMinutes(config('schedule.appointment_duration'))->format('H:i:s');
            $this->appointment['duration'] = $schedules->count() * config('schedule.appointment_duration');

            return;
        }

        $this->appointment['doctor_id'] = "";
        $this->appointment['doctor_id'] = "";
        $this->appointment['start_time'] = "";
        $this->appointment['end_time'] = "";
        $this->appointment['duration'] = "";

    }

    public function save()
    {
        $this->validate([
            'appointment.patient_id' => 'required|exists:patients,id',
            'appointment.doctor_id' => 'required|exists:doctors,id',
            'appointment.date' => 'required|date|after_or_equal:today',
            'appointment.start_time' => 'required|date_format:H:i:s',
            'appointment.end_time' => 'required|date_format:H:i:s|after:appointment.start_time',
            'appointment.reason' => 'nullable|string|max:255',
        ]);

        Appointment::create($this->appointment);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Cita creada correctamente',
            'text' => 'La cita ha sido registrada exitosamente.',
        ]);

        return redirect()->route('admin.appointments.index');
    }

    public function render()
    {
        return view('livewire.admin.appointment-manager');
    }
}
