<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait MultiTenantModelTrait
{
    public static function bootMultiTenantModelTrait()
    {
        if (!app()->runningInConsole() && auth()->check()) {
            $isadmin = auth()->user()->roles->contains(1);
            static::creating(function ($model) use ($isadmin) {
// Prevent admin from setting his own id - admin entries are global.

// If required, remove the surrounding IF condition and admins will act as users
                if (!$isadmin) {
                    $model->created_by_id = auth()->id();
                }
            });
            if (!$isadmin) {
                static::addGlobalScope('created_by_id', function (Builder $builder) {
                    $builder->where('created_by_id', auth()->id())->orWhereNull('created_by_id');
                });
            }
        }
    }
}
