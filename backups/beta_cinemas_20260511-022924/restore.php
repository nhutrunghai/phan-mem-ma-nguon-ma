<?php

require __DIR__ . '/../../vendor/autoload.php';

$app = require __DIR__ . '/../../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$db = DB::connection('mongodb')->getDatabase();
$collections = json_decode(file_get_contents(__DIR__ . '/collections.json'), true);

if (! is_array($collections)) {
    fwrite(STDERR, "collections.json is invalid\n");
    exit(1);
}

foreach ($collections as $name) {
    $file = __DIR__ . '/' . $name . '.jsonl';
    if (! is_file($file)) {
        fwrite(STDERR, "Missing {$name}.jsonl\n");
        exit(1);
    }

    $collection = $db->selectCollection($name);
    $collection->drop();

    $batch = [];
    $handle = fopen($file, 'rb');

    while (($line = fgets($handle)) !== false) {
        $line = trim($line);
        if ($line === '') {
            continue;
        }

        $batch[] = MongoDB\BSON\Document::fromJSON($line)->toPHP();

        if (count($batch) >= 500) {
            $collection->insertMany($batch);
            $batch = [];
        }
    }

    fclose($handle);

    if ($batch !== []) {
        $collection->insertMany($batch);
    }

    echo "Restored {$name}: " . $collection->countDocuments() . PHP_EOL;
}