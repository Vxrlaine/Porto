<?php

namespace App\Providers;

use App\Models\Commission;
use App\Models\Project;
use App\Models\Skill;
use App\Policies\CommissionPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\SkillPolicy;
use App\Events\CommissionCreated;
use App\Events\CommissionStatusChanged;
use App\Listeners\LogCommissionStatusChange;
use App\Listeners\SendCommissionNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        CommissionCreated::class => [
            SendCommissionNotification::class,
        ],
        CommissionStatusChanged::class => [
            LogCommissionStatusChange::class,
        ],
    ];

    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Project::class => ProjectPolicy::class,
        Skill::class => SkillPolicy::class,
        Commission::class => CommissionPolicy::class,
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();

        // Explicitly register policies
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
