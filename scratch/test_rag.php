<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rag = new App\Domain\Ai\Services\RagKnowledgeService();

echo "--- 1. Testing RAG Context Retrieval for 'React 19 & Next.js' ---\n";
$reactRes = $rag->retrieveContext('React 19 and Next.js frontend development');
echo "Matched Tech: " . $reactRes['tech_title'] . "\n";
echo "Retrieved Docs: " . $reactRes['retrieved_docs'] . "\n\n";

echo "--- 2. Testing RAG ATS Score for Python Job ---\n";
$atsRes = $rag->generateAugmentedAtsScore('Python, FastAPI, PostgreSQL', 'Looking for Senior Python engineer skilled in Django, FastAPI, Docker, and PostgreSQL');
echo "Domain: " . $atsRes['domain'] . "\n";
echo "Score: " . $atsRes['score'] . "%\n";
echo "Matched Keywords: " . implode(', ', $atsRes['matched_keywords']) . "\n";
