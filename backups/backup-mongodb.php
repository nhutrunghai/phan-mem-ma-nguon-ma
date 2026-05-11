<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$db = DB::connection('mongodb')->getDatabase();
$stamp = date('Ymd-His');
$backupDir = __DIR__ . '/beta_cinemas_' . $stamp;

if (! is_dir($backupDir) && ! mkdir($backupDir, 0777, true) && ! is_dir($backupDir)) {
    fwrite(STDERR, "Cannot create backup directory: {$backupDir}\n");
    exit(1);
}

$collections = [];
foreach ($db->listCollections() as $collectionInfo) {
    $name = $collectionInfo->getName();
    if (! str_starts_with($name, 'system.')) {
        $collections[] = $name;
    }
}
sort($collections);

file_put_contents($backupDir . '/collections.json', json_encode($collections, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

$metadata = [
    'database' => config('database.connections.mongodb.database'),
    'connection' => config('database.default'),
    'exported_at' => date(DATE_ATOM),
    'collections' => [],
];

foreach ($collections as $name) {
    $path = $backupDir . '/' . $name . '.jsonl';
    $handle = fopen($path, 'wb');

    foreach ($db->selectCollection($name)->find() as $document) {
        fwrite($handle, MongoDB\BSON\Document::fromPHP($document)->toCanonicalExtendedJSON() . PHP_EOL);
    }

    fclose($handle);

    $metadata['collections'][] = [
        'name' => $name,
        'count' => $db->selectCollection($name)->countDocuments(),
    ];
}

$restoreScript = <<<'PHP'
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
PHP;

file_put_contents($backupDir . '/restore.php', $restoreScript);
file_put_contents($backupDir . '/metadata.json', json_encode($metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
file_put_contents($backupDir . '/README.txt', "MongoDB backup for beta_cinemas\n\nRestore from Laravel project root:\nphp backups/" . basename($backupDir) . "/restore.php\n");

echo $backupDir . PHP_EOL;
