<?php

namespace App\Domain\Ai\Coding;

class CodeErrorParser
{
    /**
     * Parse compiler or runtime error logs to extract error location and type.
     */
    public function parseError(string $stderr, string $language): ?array
    {
        if (empty(trim($stderr))) return null;

        $language = strtolower(trim($language));

        // 1. Python Traceback / SyntaxError: File "...", line 12, in <module>
        if (preg_match('/File ".*?", line (\d+)(?:, column (\d+))?/i', $stderr, $m)) {
            $line = (int)$m[1];
            $col = !empty($m[2]) ? (int)$m[2] : null;
            preg_match('/(\w+Error|\w+Exception):\s*(.*)/i', $stderr, $em);
            return [
                'type' => $em[1] ?? 'RuntimeError',
                'line' => $line,
                'column' => $col,
                'message' => trim($em[2] ?? $stderr),
            ];
        }

        // 2. Java / C++ / GCC / C# compiler: Main.java:12: error: ...
        if (preg_match('/(?:[a-zA-Z0-9_]+\.(?:java|cpp|c|cs|kt|swift|go)):(\d+)(?::(\d+))?:\s*(?:error|syntax error)?:\s*(.*)/i', $stderr, $m)) {
            return [
                'type' => 'CompilationError',
                'line' => (int)$m[1],
                'column' => !empty($m[2]) ? (int)$m[2] : null,
                'message' => trim($m[3]),
            ];
        }

        // 3. PHP Parse/Fatal Error: Parse error: syntax error ... in ... on line 12
        if (preg_match('/(?:Parse|Fatal|Uncaught)\s+error:?\s*(.*?)\s+in\s+.*?\s+on\s+line\s+(\d+)/i', $stderr, $m)) {
            return [
                'type' => 'SyntaxError',
                'line' => (int)$m[2],
                'column' => null,
                'message' => trim($m[1]),
            ];
        }

        // 4. Fallback line parser: "line 12"
        if (preg_match('/line\s+(\d+)/i', $stderr, $m)) {
            return [
                'type' => 'ExecutionError',
                'line' => (int)$m[1],
                'column' => null,
                'message' => trim($stderr),
            ];
        }

        return [
            'type' => 'ExecutionError',
            'line' => null,
            'column' => null,
            'message' => trim($stderr),
        ];
    }
}
