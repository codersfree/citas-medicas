<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Builder;

class DoctorTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Doctor::query()
            ->with('user');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nombre", "user.name")
                ->sortable(),
            Column::make("Email", "user.email")
                ->sortable(),
            Column::make("DNI", "user.dni")
                ->sortable(),
            Column::make("Telefono", "user.phone")
                ->sortable(),
            Column::make("Especialidad", "speciality.name")
                ->format(function ($value) {
                    return $value ?: 'N/A';
                })
                ->sortable(),

            Column::make("Acciones")
                ->label(function($row){
                    return view('admin.doctors.actions', [
                        'doctor' => $row
                    ]);
                })
        ];
    }
}
