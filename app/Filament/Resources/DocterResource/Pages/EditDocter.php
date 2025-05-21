<?php

namespace App\Filament\Resources\DocterResource\Pages;

use App\Filament\Resources\DocterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDocter extends EditRecord
{
    protected static string $resource = DocterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
