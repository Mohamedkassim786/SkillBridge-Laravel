<?php

namespace App\Livewire\Student\Practice;

use App\Domain\Ai\Coding\CodeExecutionService;
use App\Domain\Ai\Coding\CodeInputAnalyzer;
use App\Domain\Ai\Coding\LanguageRuntimeRegistry;
use App\Domain\Ai\Common\NvidiaRagAiAgentService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.student')]
#[Title('Universal Code Playground & AI Examiner - SkillBridge')]
class CodingPractice extends Component
{
    // Language & Code State
    public string $selectedLanguage = 'Python';
    public string $customLanguage = '';
    public string $userCode = '';
    public string $challengeTitle = 'Universal Code Playground & AI Examiner';

    // Input Wizard State (Sequential One-at-a-Time)
    public array $detectedInputs = [];
    public array $inputValues = [];
    public int $currentInputStep = 0;
    public bool $showInputWizard = false;
    public string $stdinInput = '';

    // Execution Result State
    public string $executionOutput = '';
    public string $stderrOutput = '';
    public string $executionStatus = '';
    public ?int $errorLine = null;
    public ?int $errorColumn = null;
    public bool $isSuccess = false;
    public float $measuredRuntimeMs = 0.0;
    public float $measuredMemoryKb = 0.0;
    public string $languageVersion = '';
    public string $monacoLanguage = 'python';

    // Execution History State
    public array $executionHistory = [];

    // AI Diagnostics State
    public bool $hasAiAnalysis = false;
    public string $errorType = '';
    public string $errorExplanation = '';
    public string $howToFix = '';
    public string $timeComplexity = '';
    public string $spaceComplexity = '';
    public string $refactoredCode = '';

    public array $languages = [];

    public function mount(?LanguageRuntimeRegistry $registry = null, ?CodeInputAnalyzer $analyzer = null)
    {
        $registry = $registry ?? new LanguageRuntimeRegistry();
        $analyzer = $analyzer ?? new CodeInputAnalyzer();

        $this->languages = $registry->getLanguages();
        $this->languageVersion = $registry->getVersion($this->selectedLanguage);
        $this->monacoLanguage = $registry->getMonacoLanguage($this->selectedLanguage);
        $this->userCode = $registry->getStarterSnippet($this->selectedLanguage);

        $this->analyzeCodeInputs($analyzer);
    }

    public function updatedUserCode(?CodeInputAnalyzer $analyzer = null)
    {
        $analyzer = $analyzer ?? new CodeInputAnalyzer();
        $this->analyzeCodeInputs($analyzer);
    }

    public function updatedSelectedLanguage($val, ?LanguageRuntimeRegistry $registry = null, ?CodeInputAnalyzer $analyzer = null)
    {
        $registry = $registry ?? new LanguageRuntimeRegistry();
        $analyzer = $analyzer ?? new CodeInputAnalyzer();

        $this->languageVersion = $registry->getVersion($val);
        $this->monacoLanguage = $registry->getMonacoLanguage($val);
        $this->userCode = $registry->getStarterSnippet($val);

        $this->executionOutput = '';
        $this->stderrOutput = '';
        $this->executionStatus = '';
        $this->hasAiAnalysis = false;
        $this->showInputWizard = false;
        $this->inputValues = [];
        $this->currentInputStep = 0;
        $this->errorLine = null;

        $this->analyzeCodeInputs($analyzer);
    }

    public function analyzeCodeInputs(?CodeInputAnalyzer $analyzer = null): void
    {
        $analyzer = $analyzer ?? new CodeInputAnalyzer();
        $effectiveLang = ($this->selectedLanguage === 'Custom' && !empty($this->customLanguage)) ? $this->customLanguage : $this->selectedLanguage;

        $this->detectedInputs = $analyzer->detectInputs($this->userCode, $effectiveLang);
    }

    public function startInputWizard(): void
    {
        if (count($this->detectedInputs) > 0) {
            $this->currentInputStep = 0;
            $this->showInputWizard = true;
        } else {
            $this->executeProgram();
        }
    }

    public function nextInputStep(): void
    {
        if ($this->currentInputStep < count($this->detectedInputs) - 1) {
            $this->currentInputStep++;
        } else {
            $this->showInputWizard = false;
            $this->executeProgram();
        }
    }

    public function previousInputStep(): void
    {
        if ($this->currentInputStep > 0) {
            $this->currentInputStep--;
        }
    }

    public function cancelInputWizard(): void
    {
        $this->showInputWizard = false;
    }

    public function executeProgram(?CodeExecutionService $executor = null, ?NvidiaRagAiAgentService $nvidiaAgent = null): void
    {
        $executor = $executor ?? app(CodeExecutionService::class);
        $nvidiaAgent = $nvidiaAgent ?? app(NvidiaRagAiAgentService::class);

        $effectiveLang = ($this->selectedLanguage === 'Custom' && !empty($this->customLanguage)) ? $this->customLanguage : $this->selectedLanguage;

        // Build STDIN string from sequential inputs if present
        if (count($this->inputValues) > 0) {
            $this->stdinInput = implode("\n", array_values($this->inputValues));
        }

        // 1. STEP 1: Execute code immediately via execution sandbox
        $execResult = $executor->executeCode($effectiveLang, $this->userCode, $this->stdinInput);

        $this->isSuccess = $execResult['passed'];
        $this->executionStatus = $this->isSuccess ? 'PASSED ✓' : 'COMPILATION / RUNTIME ERROR ❌';
        $this->executionOutput = $execResult['stdout'];
        $this->stderrOutput = $execResult['stderr'];

        $this->errorLine = $execResult['error_line'] ?? ($execResult['error']['line'] ?? null);
        $this->errorColumn = $execResult['error']['column'] ?? null;
        $this->errorType = $execResult['error']['type'] ?? ($this->isSuccess ? '' : 'ExecutionError');

        $this->measuredRuntimeMs = $execResult['execution_time_ms'];
        $this->measuredMemoryKb = $execResult['memory_kb'];

        // Record session run history
        $this->executionHistory[] = [
            'run' => count($this->executionHistory) + 1,
            'status' => $this->isSuccess ? 'PASSED' : 'FAILED',
            'error_line' => $this->errorLine,
            'runtime_ms' => $this->measuredRuntimeMs,
            'time' => date('h:i:s A'),
            'stdout' => $this->executionOutput,
            'stderr' => $this->stderrOutput,
        ];

        // 2. STEP 2: Perform AI Code Analysis
        $aiResult = $nvidiaAgent->analyzeCodingErrorAndSolution(
            language: $effectiveLang,
            userCode: $this->userCode,
            errorLog: $this->stderrOutput ?: $this->executionOutput,
            challengeTitle: $this->challengeTitle
        );

        $this->errorExplanation = $aiResult['error_explanation'] ?? ($this->isSuccess ? 'Code executed cleanly.' : 'Execution failed.');
        $this->howToFix = $aiResult['how_to_fix'] ?? 'Review logic and error location.';
        $this->timeComplexity = $aiResult['time_complexity'] ?? 'O(N)';
        $this->spaceComplexity = $aiResult['space_complexity'] ?? 'O(1)';
        $this->refactoredCode = $aiResult['refactored_code'] ?? $this->userCode;
        $this->hasAiAnalysis = true;

        session()->flash('status', "Program executed for {$effectiveLang}!");
    }

    public function runCodeAndAiCheck(?CodeExecutionService $executor = null, ?NvidiaRagAiAgentService $nvidiaAgent = null)
    {
        $this->analyzeCodeInputs();
        if (count($this->detectedInputs) > 0 && count($this->inputValues) === 0) {
            $this->startInputWizard();
            return;
        }

        $this->executeProgram($executor, $nvidiaAgent);
    }

    public function applyRefactoredCode()
    {
        if (!empty($this->refactoredCode)) {
            $this->userCode = $this->refactoredCode;
            $this->errorLine = null;
            session()->flash('status', '✨ AI Suggested Fix applied to code editor!');
        }
    }

    public function render()
    {
        return view('livewire.student.practice.coding-practice', get_object_vars($this));
    }
}
