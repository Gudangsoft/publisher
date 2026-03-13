<?php

require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$submission = App\Models\Submission::find(1);
if (!$submission) {
    echo "Submission not found\n";
    exit(1);
}

echo "status=" . $submission->status . "\n";
echo "revision_notes=" . var_export($submission->revision_notes, true) . "\n";
