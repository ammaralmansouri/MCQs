<?php

namespace App\Filament\Resources\ChoicesResource\Pages;

use App\Filament\Resources\ChoicesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChoices extends EditRecord
{
    protected static string $resource = ChoicesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
