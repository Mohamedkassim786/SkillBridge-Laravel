<?php

namespace App\Domain\Ai\Coding;

class LanguageRuntimeRegistry
{
    /**
     * Supported language definitions and metadata.
     */
    protected array $languages = [
        'Python' => [
            'name' => 'Python',
            'version' => 'Python 3.12',
            'monaco_lang' => 'python',
            'type' => 'interpreted',
            'snippet' => "name = input(\"Enter your name: \")\nage = int(input(\"Enter your age: \"))\nprint(f\"Hello {name}! You are {age} years old.\")",
        ],
        'JavaScript' => [
            'name' => 'JavaScript',
            'version' => 'Node.js 22',
            'monaco_lang' => 'javascript',
            'type' => 'interpreted',
            'snippet' => "const fs = require('fs');\nconst input = fs.readFileSync(0, 'utf-8').trim().split('\\n');\nconst name = input[0] || 'Developer';\nconsole.log(`Hello \${name} from Node.js!`);",
        ],
        'TypeScript' => [
            'name' => 'TypeScript',
            'version' => 'TypeScript 5.4',
            'monaco_lang' => 'typescript',
            'type' => 'interpreted',
            'snippet' => "function greet(name: string): string {\n    return `Hello \${name} from TypeScript!`;\n}\nconsole.log(greet('Developer'));",
        ],
        'PHP' => [
            'name' => 'PHP',
            'version' => 'PHP 8.2',
            'monaco_lang' => 'php',
            'type' => 'interpreted',
            'snippet' => "<?php\n\$name = trim(fgets(STDIN)) ?: 'Developer';\necho \"Hello {\$name} from PHP!\\n\";",
        ],
        'Java' => [
            'name' => 'Java',
            'version' => 'Java 21',
            'monaco_lang' => 'java',
            'type' => 'compiled',
            'snippet' => "import java.util.Scanner;\n\npublic class Main {\n    public static void main(String[] args) {\n        Scanner scanner = new Scanner(System.in);\n        String name = scanner.nextLine();\n        System.out.println(\"Hello \" + name);\n    }\n}",
        ],
        'C++' => [
            'name' => 'C++',
            'version' => 'GCC 13',
            'monaco_lang' => 'cpp',
            'type' => 'compiled',
            'snippet' => "#include <iostream>\n#include <string>\nusing namespace std;\n\nint main() {\n    string name;\n    if (cin >> name) {\n        cout << \"Hello \" << name << endl;\n    } else {\n        cout << \"Hello World\" << endl;\n    }\n    return 0;\n}",
        ],
        'C#' => [
            'name' => 'C#',
            'version' => '.NET 8',
            'monaco_lang' => 'csharp',
            'type' => 'compiled',
            'snippet' => "using System;\n\nclass Program {\n    static void Main() {\n        string name = Console.ReadLine() ?? \"Developer\";\n        Console.WriteLine($\"Hello {name} from C#!\");\n    }\n}",
        ],
        'Go' => [
            'name' => 'Go',
            'version' => 'Go 1.22',
            'monaco_lang' => 'go',
            'type' => 'compiled',
            'snippet' => "package main\nimport (\n    \"fmt\"\n    \"bufio\"\n    \"os\"\n)\n\nfunc main() {\n    scanner := bufio.NewScanner(os.Stdin)\n    if scanner.Scan() {\n        fmt.Printf(\"Hello %s from Go!\\n\", scanner.Text())\n    } else {\n        fmt.Println(\"Hello World from Go!\")\n    }\n}",
        ],
        'Rust' => [
            'name' => 'Rust',
            'version' => 'Rust 1.77',
            'monaco_lang' => 'rust',
            'type' => 'compiled',
            'snippet' => "use std::io::{self, BufRead};\n\nfn main() {\n    let stdin = io::stdin();\n    let name = stdin.lock().lines().next().unwrap_or(Ok(\"Developer\".to_string())).unwrap();\n    println!(\"Hello {} from Rust!\", name);\n}",
        ],
        'SQL' => [
            'name' => 'SQL',
            'version' => 'SQLite 3.45 Sandbox',
            'monaco_lang' => 'sql',
            'type' => 'query',
            'snippet' => "CREATE TABLE students (id INT, name TEXT, gpa DOUBLE);\nINSERT INTO students VALUES (1, 'Mohamed', 8.5), (2, 'Sara', 9.1);\nSELECT * FROM students WHERE gpa > 8.0 ORDER BY gpa DESC;",
        ],
        'Ruby' => [
            'name' => 'Ruby',
            'version' => 'Ruby 3.3',
            'monaco_lang' => 'ruby',
            'type' => 'interpreted',
            'snippet' => "name = gets&.strip || 'Developer'\nputs \"Hello #{name} from Ruby!\"",
        ],
        'Swift' => [
            'name' => 'Swift',
            'version' => 'Swift 5.10',
            'monaco_lang' => 'swift',
            'type' => 'compiled',
            'snippet' => "import Foundation\n\nlet name = readLine() ?? \"Developer\"\nprint(\"Hello \\(name) from Swift!\")",
        ],
        'Kotlin' => [
            'name' => 'Kotlin',
            'version' => 'Kotlin 1.9',
            'monaco_lang' => 'kotlin',
            'type' => 'compiled',
            'snippet' => "import java.util.Scanner\n\nfun main() {\n    val scanner = Scanner(System.`in`)\n    val name = if (scanner.hasNext()) scanner.next() else \"Developer\"\n    println(\"Hello \$name from Kotlin!\")\n}",
        ],
        'HTML/CSS' => [
            'name' => 'HTML/CSS',
            'version' => 'HTML5 Sandbox',
            'monaco_lang' => 'html',
            'type' => 'markup',
            'snippet' => "<!DOCTYPE html>\n<html>\n<head>\n    <style>\n        body { font-family: system-ui, sans-serif; background: #0B1F3A; color: white; padding: 20px; }\n        .card { background: #112240; padding: 15px; border-radius: 12px; border: 1px solid #1e3a5f; }\n    </style>\n</head>\n<body>\n    <div class=\"card\">\n        <h1>⚡ SkillBridge Coding Sandbox</h1>\n        <p>Interactive HTML/CSS Preview</p>\n    </div>\n</body>\n</html>",
        ],
        'Custom' => [
            'name' => 'Custom',
            'version' => 'Custom Runtime Environment',
            'monaco_lang' => 'plaintext',
            'type' => 'interpreted',
            'snippet' => "// Custom Code Sandbox\nprint(\"Hello World\");",
        ],
    ];

    public function getLanguages(): array
    {
        return array_keys($this->languages);
    }

    public function getLanguageDetails(string $langKey): array
    {
        return $this->languages[$langKey] ?? $this->languages['Python'];
    }

    public function getVersion(string $langKey): string
    {
        return $this->languages[$langKey]['version'] ?? 'Custom Runtime';
    }

    public function getMonacoLanguage(string $langKey): string
    {
        return $this->languages[$langKey]['monaco_lang'] ?? 'plaintext';
    }

    public function getStarterSnippet(string $langKey): string
    {
        return $this->languages[$langKey]['snippet'] ?? "// Write your code here";
    }
}
