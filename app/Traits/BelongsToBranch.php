<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Models\Branch;

trait BelongsToBranch
{
    protected static function bootBelongsToBranch(): void
    {
        static::addGlobalScope('branch', function (Builder $builder) {
            $user = Auth::user();
            if ($user && !$user->hasRole('admin')) {
                $builder->where('branch_id', $user->branch_id);
            }
        });
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}

