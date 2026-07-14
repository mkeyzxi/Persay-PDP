<?php
$renameMap = [
    'ProjectFactory' => 'ProjectsFactory',
    'MaterialIssueFactory' => 'MaterialIssuesFactory',
    'MaterialIssuesItemFactory' => 'MaterialIssuesItemsFactory',
    'ProjectDocumentFactory' => 'ProjectDocumentsFactory'
];

foreach ($renameMap as $old => $new) {
    $oldPath = "c:/Users/muhma/Herd/prisay-pdp/database/factories/{$old}.php";
    $newPath = "c:/Users/muhma/Herd/prisay-pdp/database/factories/{$new}.php";
    
    if (file_exists($oldPath)) {
        $content = file_get_contents($oldPath);
        $content = str_replace("class {$old}", "class {$new}", $content);
        file_put_contents($newPath, $content);
        unlink($oldPath);
        echo "Renamed $old to $new\n";
    } else {
        echo "File $oldPath not found\n";
    }
}
