<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DemoComponent extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected function getFormSchema(): array 
    {
        return [
            DatePicker::make('event_date')
                ->label('Event Date')
                ->displayFormat('d.m.Y')
                ->closeOnDateSelection()
                ->minDate(now())
                ->reactive()
                ->required(),
            DatePicker::make('arrival_date')
                ->label('Arrival Date')
                ->displayFormat('d.m.Y')
                ->closeOnDateSelection()
                ->minDate(now())
                ->maxDate(function (callable $get) {
                    // Calculate max of arrival date depending on event date
                    $eventDate = $get('event_date');
                    if ($eventDate == null) {
                        Log::info("Retrieved value of event_date is null.");
                        return null;
                    }
                    else {
                        Log::info("Retrieved value of event_date: " . Carbon::parse($eventDate)->toDateString());
                        Log::info("Set maxDate for 'arrival_date' to: " . Carbon::parse($eventDate)->subDays(1)->toDateString());
                        return Carbon::parse($eventDate)->subDays(1);
                    }
                }),
        ];
    } 

    public function render()
    {
        return view('livewire.demo-component');
    }
}
