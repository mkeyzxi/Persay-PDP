$dir = "c:\Users\muhma\Herd\prisay-pdp\resources\views\livewire"
Get-ChildItem -Path $dir -Recurse -Filter *.blade.php | ForEach-Object {
    $content = Get-Content -Path $_.FullName -Raw
    $newContent = $content -replace 'p-4 transition-colors md:p-6', 'transition-colors'
    if ($newContent -cne $content) {
        Set-Content -Path $_.FullName -Value $newContent -NoNewline
        Write-Host "Updated: $($_.FullName)"
    }
}
