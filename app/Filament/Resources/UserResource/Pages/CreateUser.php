<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Models\Docter;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterCreate(): void
    {
        if ($this->data['role'] === 'doc') {
            Docter::create([
                'user_id' => $this->record->id,
                'nip' => $this->data['nip'],
                'spesialis' => $this->data['spesialis'],
            ]);
        }
    }
}
