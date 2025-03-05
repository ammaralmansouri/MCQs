<?php

namespace App\Filament\Resources\ChoicesResource\Pages;

use App\Filament\Resources\ChoicesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewChoices extends ViewRecord
{
    protected static string $resource = ChoicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
