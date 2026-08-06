<?php

namespace App\Domain\Jobs\Services;

use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobPosting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdzunaJobSyncService
{
    public function __construct(
        protected JobDeduplicationService $deduplicationService
    ) {}

    /**
     * Fetch live software engineering jobs from Adzuna API and persist to DB.
     */
    public function syncJobs(string $country = 'in', string $query = 'developer', int $maxPages = 2): int
    {
        $appId = env('ADZUNA_APP_ID', 'b1cb7505');
        $appKey = env('ADZUNA_APP_KEY', 'ffebba9d13743714202cd9eacffdff94');

        if (! $appId || ! $appKey) {
            Log::warning('Adzuna API credentials missing in .env');

            return 0;
        }

        $importedCount = 0;
        $category = JobCategory::firstOrCreate(
            ['slug' => 'software-engineering'],
            ['name' => 'Software Engineering']
        );

        for ($page = 1; $page <= $maxPages; $page++) {
            try {
                $response = Http::withoutVerifying()->timeout(10)->get("https://api.adzuna.com/v1/api/jobs/{$country}/search/{$page}", [
                    'app_id' => $appId,
                    'app_key' => $appKey,
                    'results_per_page' => 20,
                    'what' => $query,
                ]);

                if ($response->failed()) {
                    Log::error("Adzuna API page {$page} failed: " . $response->body());
                    break;
                }

                $results = $response->json('results', []);

                foreach ($results as $job) {
                    $companyName = $job['company']['display_name'] ?? 'Tech Enterprise';
                    $title = $job['title'] ?? 'Software Engineer';
                    $location = $job['location']['display_name'] ?? 'India';
                    $description = strip_tags($job['description'] ?? 'Exciting software developer opportunity.');
                    $externalId = (string) ($job['id'] ?? Str::uuid());

                    // Generate MD5 hash to prevent duplicate entries
                    $dedupHash = $this->deduplicationService->generateHash($companyName, $title, $location);

                    // Check if job posting already exists
                    if (JobPosting::where('deduplication_hash', $dedupHash)->orWhere('external_id', $externalId)->exists()) {
                        continue;
                    }

                    // Create or find Company
                    $company = Company::firstOrCreate(
                        ['slug' => Str::slug($companyName)],
                        [
                            'name' => $companyName,
                            'website' => 'https://' . Str::slug($companyName) . '.com',
                            'description' => "Enterprise technological innovator hiring software developers.",
                            'is_verified' => true,
                        ]
                    );

                    // Insert Job Posting
                    JobPosting::create([
                        'company_id' => $company->id,
                        'category_id' => $category->id,
                        'deduplication_hash' => $dedupHash,
                        'source' => 'adzuna',
                        'external_id' => $externalId,
                        'title' => $title,
                        'slug' => Str::slug($title . '-' . Str::random(5)),
                        'description' => $description,
                        'location' => $location,
                        'salary_min' => (float) ($job['salary_min'] ?? 600000),
                        'salary_max' => (float) ($job['salary_max'] ?? 1200000),
                        'status' => 'active',
                    ]);

                    $importedCount++;
                }
            } catch (\Exception $e) {
                Log::error("Adzuna Sync exception on page {$page}: " . $e->getMessage());
                break;
            }
        }

        return $importedCount;
    }
}
