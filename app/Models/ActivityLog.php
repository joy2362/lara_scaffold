<?php

namespace App\Models;

use Spatie\Activitylog\Models\Activity as SpatieActivity;

class ActivityLog extends SpatieActivity
{
    protected $connection = 'mongodb';
    protected $collection = 'activity_logs';

    protected $table = 'activity_logs';

}
