<?php

namespace App\Livewire\Admin;

use App\Models\Doctor;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ScheduleManager extends Component
{
    public Doctor $doctor;
    public $schedule = [];

    public $days = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        0 => 'Domingo',
    ];

    public $apointment_duration = 15; // Default appointment duration in minutes
    public $intervals;

    #[Computed()]
    public function hourBlocks()
    {
        return CarbonPeriod::create(
            Carbon::createFromTimeString('08:00:00'),
            '1 hour',
            Carbon::createFromTimeString('18:00:00')
        );
    }

    public function mount()
    {
        $this->intervals = 60 / $this->apointment_duration;
        $this->initializeSchedule();
    }

    public function initializeSchedule()
    {
        $schedules = $this->doctor->schedules;

        foreach ($this->hourBlocks as $hourBlock) {
            $period = CarbonPeriod::create(
                $hourBlock->copy(),
                $this->apointment_duration . ' minutes',
                $hourBlock->copy()->addHour()
            );

            foreach ($period as $time) {

                foreach ($this->days as $index => $day) {
                    
                    $this->schedule[$index][$time->format('H:i:s')] = $schedules->contains(function($schedule) use ($index, $time){
                        return $schedule->day_of_week == $index && $schedule->start_time->format('H:i:s') == $time->format('H:i:s');
                    });

                }

            }
        }
    }

    public function save()
    {
        dd($this->schedule);
    }

    public function render()
    {
        return view('livewire.admin.schedule-manager');
    }
}
