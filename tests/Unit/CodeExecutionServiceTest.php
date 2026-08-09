<?php

namespace Tests\Unit;

use App\Domain\Ai\Services\CodeExecutionService;
use Tests\TestCase;

class CodeExecutionServiceTest extends TestCase
{
    public function test_php_code_execution_runs_safely_with_real_measured_runtime(): void
    {
        $service = new CodeExecutionService();
        $userCode = 'function twoSum($nums, $target) { return [0, 1]; }';

        $result = $service->executeCode('PHP', $userCode);

        $this->assertTrue($result['passed']);
        $this->assertGreaterThan(0, $result['execution_time_ms']);
        $this->assertGreaterThan(0, $result['memory_bytes']);
        $this->assertEquals(2, $result['passed_tests']);
    }

    public function test_sql_in_memory_execution_runs_successfully(): void
    {
        $service = new CodeExecutionService();
        $userCode = 'SELECT * FROM employees WHERE salary > 70000;';

        $result = $service->executeCode('SQL', $userCode);

        $this->assertTrue($result['passed']);
        $this->assertStringContainsString('Mohamed Kassim', $result['stdout']);
    }
}
