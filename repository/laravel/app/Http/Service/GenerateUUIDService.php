<?php

namespace App\Http\Service;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class GenerateUUIDService
{
    public function handle(Model $model): void
    {
        $model::creating(function (Model $model): void {
            $model->setAttribute('uuid', Str::uuid()->toString());
        });
    }
}
