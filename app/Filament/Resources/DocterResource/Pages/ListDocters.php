<?php

namespace App\Filament\Resources\DocterResource\Pages;

use App\Filament\Resources\DocterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDocters extends ListRecords
{
    protected static string $resource = DocterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
