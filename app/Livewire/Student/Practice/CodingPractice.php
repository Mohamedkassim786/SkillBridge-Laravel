<?php

namespace App\Livewire\Student\Practice;

use App\Domain\Ai\Coding\CodeExecutionService;
use App\Domain\Ai\Common\NvidiaRagAiAgentService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('Coding Practice Sandbox - SkillBridge')]
class CodingPractice extends Component
{
    public string $selectedLanguage = 'PHP';
    public string $customLanguage = '';
    public string $challengeTitle = 'Code Playground & AI Examiner';
    public string $userCode = '';
    public string $stdinInput = '';
    public string $executionOutput = '';
    public bool $isSuccess = false;

    // Dynamic Input Requirement Detection
    public bool $requiresInputStatement = false;
    public bool $showInputModal = false;
    public string $detectedPromptLabel = 'Enter input value required by program';

    // Measured Runtime Metrics
    public float $measuredRuntimeMs = 0.0;
    public float $measuredMemoryKb = 0.0;
    public int $passedCount = 0;
    public int $totalCount = 0;

    // AI Diagnostics State
    public bool $hasAiAnalysis = false;
    public string $errorExplanation = '';
    public string $howToFix = '';
    public string $timeComplexity = '';
    public string $spaceComplexity = '';
    public string $refactoredCode = '';

    public array $languages = [
        'PHP', 'JavaScript', 'TypeScript', 'Python', 'SQL', 
        'Java', 'C++', 'C#', 'Go', 'Rust', 'Ruby', 'Swift', 'Kotlin', 'HTML/CSS', 'Custom'
    ];

    public array $starterSnippets = [
        'PHP' => "function twoSum(\$nums, \$target) {\n    for (\$i = 0; \$i < count(\$nums); \$i++) {\n        for (\$j = \$i + 1; \$j < count(\$nums); \$j++) {\n            if (\$nums[\$i] + \$nums[\$j] === \$target) {\n                return [\$i, \$j];\n            }\n        }\n    }\n    return [];\n}",
        'JavaScript' => "function twoSum(nums, target) {\n    const map = new Map();\n    for (let i = 0; i < nums.length; i++) {\n        let diff = target - nums[i];\n        if (map.has(diff)) {\n            return [map.get(diff), i];\n        }\n        map.set(nums[i], i);\n    }\n    return [];\n}",
        'TypeScript' => "function twoSum(nums: number[], target: number): number[] {\n    const map = new Map<number, number>();\n    for (let i = 0; i < nums.length; i++) {\n        const diff = target - nums[i];\n        if (map.has(diff)) {\n            return [map.get(diff)!, i];\n        }\n        map.set(nums[i], i);\n    }\n    return [];\n}",
        'SQL' => "SELECT e.id, e.name, d.department_name\nFROM employees e\nJOIN departments d ON e.department_id = d.id\nWHERE e.salary > 75000\nORDER BY e.salary DESC;",
        'Python' => "name = input(\"Enter your name: \")\nprint(f\"Hello, {name}! Welcome to Python.\")",
        'Java' => "public class Main {\n    public static void main(String[] args) {\n        String name = \"John\";\n        System.out.println(\"Hello \" + name);\n    }\n}",
        'C++' => "#include <iostream>\nusing namespace std;\n\nint main() {\n    cout << \"Hello, World!\" << endl;\n    return 0;\n}",
        'C#' => "using System;\n\nclass Program {\n    static void Main() {\n        Console.WriteLine(\"Hello, World!\");\n    }\n}",
        'Go' => "package main\nimport \"fmt\"\n\nfunc main() {\n    fmt.Println(\"Hello, World!\")\n}",
        'Rust' => "fn main() {\n    println!(\"Hello, World!\");\n}",
        'Ruby' => "def two_sum(nums, target)\n    seen = {}\n    nums.each_with_index do |num, i|\n        diff = target - num\n        return [seen[diff], i] if seen.key?(diff)\n        seen[num] = i\n    end\nend",
        'Swift' => "import Foundation\n\nfunc twoSum(_ nums: [Int], _ target: Int) -> [Int] {\n    var dict = [Int: Int]()\n    for (i, num) in nums.enumerated() {\n        if let j = dict[target - num] { return [j, i] }\n        dict[num] = i\n    }\n    return []\n}",
        'Kotlin' => "fun main() {\n    println(\"Hello, World!\")\n}",
        'HTML/CSS' => "<!DOCTYPE html>\n<html>\n<head>\n    <style>\n        body { font-family: sans-serif; background: #0B1F3A; color: white; }\n    </style>\n</head>\n<body>\n    <h1>SkillBridge Coding Sandbox</h1>\n</body>\n</html>",
        'Custom' => "// Write your custom code here\nprint(\"Hello World\");",
    ];

    public function mount()
    {
        $this->userCode = $this->starterSnippets['Python'];
        $this->detectInputRequirement();
    }

    public function updatedUserCode()
    {
        $this->detectInputRequirement();
    }

    public function updatedSelectedLanguage($val)
    {
        if (isset($this->starterSnippets[$val])) {
            $this->userCode = $this->starterSnippets[$val];
        }
        $this->executionOutput = '';
        $this->hasAiAnalysis = false;
        $this->showInputModal = false;
        $this->stdinInput = '';
        $this->detectInputRequirement();
    }

    public function detectInputRequirement(): bool
    {
        $this->requiresInputStatement = false;
        $promptLabel = 'Enter value required by your program';

        if (preg_match('/input\s*\(\s*["\'](.*?)["\']\s*\)/i', $this->userCode, $m)) {
            $this->requiresInputStatement = true;
            $promptLabel = trim($m[1]) ?: 'Enter input required by Python program';
        } elseif (str_contains($this->userCode, 'input(') || str_contains($this->userCode, 'sys.stdin') || str_contains($this->userCode, 'Scanner') || str_contains($this->userCode, 'cin') || str_contains($this->userCode, 'STDIN') || str_contains($this->userCode, 'prompt(')) {
            $this->requiresInputStatement = true;
        }

        $this->detectedPromptLabel = $promptLabel;
        return $this->requiresInputStatement;
    }

    public function runCodeAndAiCheck(CodeExecutionService $executor, NvidiaRagAiAgentService $nvidiaAgent)
    {
        if ($this->detectInputRequirement() && empty(trim($this->stdinInput))) {
            $this->showInputModal = true;
            return;
        }

        $this->showInputModal = false;

        if (str_contains($this->userCode, 'public class') || str_contains($this->userCode, 'System.out.println')) {
            $this->selectedLanguage = 'Java';
        }

        $effectiveLanguage = ($this->selectedLanguage === 'Custom' && !empty(trim($this->customLanguage))) ? $this->customLanguage : $this->selectedLanguage;

        $execResult = $executor->executeCode($effectiveLanguage, $this->userCode, $this->stdinInput);

        $this->isSuccess = $execResult['passed'];
        $this->measuredRuntimeMs = $execResult['execution_time_ms'];
        $this->measuredMemoryKb = round($execResult['memory_bytes'] / 1024, 1);
        $this->passedCount = $execResult['passed_tests'];
        $this->totalCount = $execResult['total_tests'];

        $statusText = $this->isSuccess ? "PASSED ✓" : "REVIEW NEEDED ⚠️";
        $this->executionOutput = "Language: {$effectiveLanguage} | Status: {$statusText}\nMeasured Runtime: {$this->measuredRuntimeMs} ms | Memory: {$this->measuredMemoryKb} KB\n\n--- Output / Log ---\n" . $execResult['stdout'];

        if (!empty($execResult['stderr'])) {
            $this->executionOutput .= "\n\n--- Standard Error ---\n" . $execResult['stderr'];
        }

        // Call AI Diagnostics for Universal Code Review & Big-O Complexity
        $result = $nvidiaAgent->analyzeCodingErrorAndSolution(
            language: $effectiveLanguage,
            userCode: $this->userCode,
            errorLog: $execResult['stderr'] ?: $execResult['stdout'],
            challengeTitle: $this->challengeTitle
        );

        $this->errorExplanation = $result['error_explanation'] ?? 'No syntax errors found.';
        $this->howToFix = $result['how_to_fix'] ?? 'Code satisfies algorithm constraints.';
        $this->timeComplexity = $result['time_complexity'] ?? 'O(N)';
        $this->spaceComplexity = $result['space_complexity'] ?? 'O(1)';
        $this->refactoredCode = $result['refactored_code'] ?? $this->userCode;
        $this->hasAiAnalysis = true;

        session()->flash('status', "AI Code Diagnostic completed for {$effectiveLanguage}!");
    }

    public function submitInputAndRun(CodeExecutionService $executor, NvidiaRagAiAgentService $nvidiaAgent)
    {
        $this->showInputModal = false;
        $this->runCodeAndAiCheck($executor, $nvidiaAgent);
    }

    public function closeModal()
    {
        $this->showInputModal = false;
    }

    public function applyRefactoredCode()
    {
        if (!empty($this->refactoredCode)) {
            $this->userCode = $this->refactoredCode;
            session()->flash('status', 'AI Refactored Code applied to editor!');
        }
    }

    public function render()
    {
        return view('livewire.student.practice.coding-practice');
    }
}
