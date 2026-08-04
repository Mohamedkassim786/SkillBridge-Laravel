<?php

namespace App\Domain\Jobs\Services;

class JobDeduplicationService
{
    /**
     * Generate standard MD5 hash for external job deduplication.
     */
    public function generateHash(string $companyName, string $title, string $location): string
    {
        $normalizedCompany = strtolower(trim($companyName));
        $normalizedTitle = strtolower(trim($title));
        $normalizedLocation = strtolower(trim($location));

        return md5("{$normalizedCompany}|{$normalizedTitle}|{$normalizedLocation}");
    }
}
