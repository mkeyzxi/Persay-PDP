<?php
$models = ['Projects', 'MaterialIssues', 'MaterialIssuesItems', 'ProjectDocuments'];
foreach($models as $model) {
    $path = "c:/Users/muhma/Herd/prisay-pdp/app/Models/$model.php";
    if(file_exists($path)) {
        $content = file_get_contents($path);
        if(strpos($content, 'HasFactory') === false) {
            // add use Illuminate\Database\Eloquent\Factories\HasFactory;
            $content = preg_replace('/(class\s+'.$model.'\s+extends\s+Model\s*\{)/', "use Illuminate\\Database\\Eloquent\\Factories\\HasFactory;\n\n$1", $content);
            $content = preg_replace('/(class\s+'.$model.'\s+extends\s+Model\s*\{\s*)/', "$1\n    use HasFactory;\n", $content);
            file_put_contents($path, $content);
            echo "Updated $model\n";
        }
    }
}
