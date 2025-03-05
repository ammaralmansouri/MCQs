<?php

namespace App\Filament\Resources\ChoicesResource\Pages;

use App\Filament\Resources\ChoicesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChoices extends ListRecords
{
    protected static string $resource = ChoicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
