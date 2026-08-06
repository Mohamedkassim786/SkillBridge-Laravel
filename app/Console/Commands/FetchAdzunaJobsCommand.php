<?php

namespace App\Console\Commands;

use App\Domain\Jobs\Services\AdzunaJobSyncService;
use Illuminate\Console\Command;

class FetchAdzunaJobsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:fetch-adzuna {--country=in} {--query=developer} {--pages=2}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync live developer job postings from Adzuna API into database';

    /**
     * Execute the console command.
     */
    public function handle(AdzunaJobSyncService $syncService): int
    {
        $country = $this->option('country');
        $query = $this->option('query');
        $pages = (int) $this->option('pages');

        $this->info("Fetching live '{$query}' jobs for country [{$country}] from Adzuna API...");

        $count = $syncService->syncJobs($country, $query, $pages);

        $this->info("✅ Successfully imported {$count} live jobs from Adzuna API!");

        return Command::SUCCESS;
    }
}
