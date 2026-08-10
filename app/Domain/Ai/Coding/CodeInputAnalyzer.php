<?php

namespace App\Domain\Ai\Coding;

class CodeInputAnalyzer
{
    /**
     * Analyze source code to extract structured stdin input requirements.
     *
     * @return array List of required input definitions: [['label' => '...', 'type' => '...', 'var' => '...'], ...]
     */
    public function detectInputs(string $code, string $language): array
    {
        $language = strtolower(trim($language));
        $inputs = [];

        if (empty(trim($code))) return [];

        if ($language === 'python') {
            $inputs = $this->analyzePython($code);
        } elseif ($language === 'java') {
            $inputs = $this->analyzeJava($code);
        } elseif ($language === 'c++' || $language === 'cpp' || $language === 'c') {
            $inputs = $this->analyzeCpp($code);
        } elseif ($language === 'javascript' || $language === 'typescript') {
            $inputs = $this->analyzeJs($code);
        } elseif ($language === 'php') {
            $inputs = $this->analyzePhp($code);
        } elseif ($language === 'go') {
            $inputs = $this->analyzeGo($code);
        } elseif ($language === 'rust') {
            $inputs = $this->analyzeRust($code);
        } else {
            $inputs = $this->analyzeGeneric($code);
        }

        return $inputs;
    }

    protected function analyzePython(string $code): array
    {
        $inputs = [];
        $lines = explode("\n", $code);
        $count = 1;

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (empty($trimmed) || str_starts_with($trimmed, '#')) continue;

            if (preg_match('/(?:(\w+)\s*=\s*)?(?:(int|float|str)\s*\(\s*)?input\s*\(\s*(?:["\'](.*?)["\'])?\s*\)\s*\)?/i', $trimmed, $m)) {
                $varName = !empty($m[1]) ? trim($m[1]) : '';
                $castType = !empty($m[2]) ? strtolower(trim($m[2])) : '';
                $promptText = !empty($m[3]) ? trim($m[3]) : '';

                $label = !empty($promptText) ? rtrim($promptText, ': ') : (!empty($varName) ? "Enter " . ucwords($varName) : "Input value {$count}");

                $type = match ($castType) {
                    'int' => 'Integer',
                    'float' => 'Decimal',
                    default => 'Text',
                };

                $inputs[] = [
                    'step' => $count,
                    'label' => $label,
                    'var' => $varName,
                    'type' => $type,
                ];
                $count++;
            } elseif (str_contains($trimmed, 'sys.stdin.readline') || str_contains($trimmed, 'sys.stdin.read')) {
                $inputs[] = [
                    'step' => $count,
                    'label' => "Input value {$count}",
                    'var' => 'stdin',
                    'type' => 'Text',
                ];
                $count++;
            }
        }

        return $inputs;
    }

    protected function analyzeJava(string $code): array
    {
        $inputs = [];
        $lines = explode("\n", $code);
        $count = 1;

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (empty($trimmed) || str_starts_with($trimmed, '//')) continue;

            if (preg_match('/(?:(int|double|float|String|long)\s+)?(\w+)\s*=\s*\w+\.(next\w*)\(\);/i', $trimmed, $m)) {
                $dataType = !empty($m[1]) ? trim($m[1]) : '';
                $varName = trim($m[2]);
                $methodName = strtolower(trim($m[3]));

                $type = match ($methodName) {
                    'nextint', 'nextlong' => 'Integer',
                    'nextdouble', 'nextfloat' => 'Decimal',
                    default => 'Text',
                };

                $label = "Enter " . ucwords(str_replace('_', ' ', $varName));

                $inputs[] = [
                    'step' => $count,
                    'label' => $label,
                    'var' => $varName,
                    'type' => $type,
                ];
                $count++;
            }
        }

        return $inputs;
    }

    protected function analyzeCpp(string $code): array
    {
        $inputs = [];
        $count = 1;

        if (preg_match_all('/cin\s*>>\s*([a-zA-Z0-9_\s>]+);/i', $code, $m)) {
            foreach ($m[1] as $matchGroup) {
                $vars = explode('>>', $matchGroup);
                foreach ($vars as $v) {
                    $vTrim = trim($v);
                    if (!empty($vTrim)) {
                        $inputs[] = [
                            'step' => $count,
                            'label' => "Enter " . ucwords($vTrim),
                            'var' => $vTrim,
                            'type' => 'Text/Number',
                        ];
                        $count++;
                    }
                }
            }
        }

        if (preg_match_all('/getline\s*\(\s*cin\s*,\s*(\w+)\s*\)/i', $code, $m)) {
            foreach ($m[1] as $vTrim) {
                $inputs[] = [
                    'step' => $count,
                    'label' => "Enter " . ucwords($vTrim),
                    'var' => $vTrim,
                    'type' => 'Text',
                ];
                $count++;
            }
        }

        return $inputs;
    }

    protected function analyzeJs(string $code): array
    {
        $inputs = [];
        if (str_contains($code, 'fs.readFileSync(0') || str_contains($code, 'process.stdin') || str_contains($code, 'readline')) {
            $inputs[] = [
                'step' => 1,
                'label' => 'Enter program input',
                'var' => 'stdin',
                'type' => 'Text',
            ];
        }
        return $inputs;
    }

    protected function analyzePhp(string $code): array
    {
        $inputs = [];
        $lines = explode("\n", $code);
        $count = 1;

        foreach ($lines as $line) {
            $trimmed = trim($line);
            if (str_contains($trimmed, 'fgets(STDIN)') || str_contains($trimmed, 'STDIN')) {
                preg_match('/\$(\w+)\s*=\s*/', $trimmed, $m);
                $varName = !empty($m[1]) ? $m[1] : '';
                $label = !empty($varName) ? "Enter " . ucwords($varName) : "Input value {$count}";

                $inputs[] = [
                    'step' => $count,
                    'label' => $label,
                    'var' => $varName,
                    'type' => 'Text',
                ];
                $count++;
            }
        }

        return $inputs;
    }

    protected function analyzeGo(string $code): array
    {
        $inputs = [];
        if (str_contains($code, 'fmt.Scan') || str_contains($code, 'bufio.NewScanner')) {
            $inputs[] = [
                'step' => 1,
                'label' => 'Enter Go program input',
                'var' => 'stdin',
                'type' => 'Text',
            ];
        }
        return $inputs;
    }

    protected function analyzeRust(string $code): array
    {
        $inputs = [];
        if (str_contains($code, 'stdin()')) {
            $inputs[] = [
                'step' => 1,
                'label' => 'Enter Rust program input',
                'var' => 'stdin',
                'type' => 'Text',
            ];
        }
        return $inputs;
    }

    protected function analyzeGeneric(string $code): array
    {
        if (str_contains(strtolower($code), 'input') || str_contains($code, 'stdin') || str_contains($code, 'read')) {
            return [
                [
                    'step' => 1,
                    'label' => 'Enter program input',
                    'var' => 'stdin',
                    'type' => 'Text',
                ]
            ];
        }
        return [];
    }
}
