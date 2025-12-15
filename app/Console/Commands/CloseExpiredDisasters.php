<?php

namespace App\Console\Commands;

use App\Models\Disaster;
use Illuminate\Console\Command;

class CloseExpiredDisasters extends Command
{
    protected $signature = 'disasters:close-expired';
    protected $description = 'Set status=closed untuk disasters yang end_date lewat.';

    public function handle(): int
    {
        $affected = Disaster::query()
            ->where('status','active')
            ->whereNotNull('end_date')
            ->whereDate('end_date','<', now()->toDateString())
            ->update(['status' => 'closed']);

        $this->info("Closed: {$affected}");
        return self::SUCCESS;
    }
}
