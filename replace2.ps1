$dir = "c:\Users\muhma\Herd\prisay-pdp\resources\views\livewire"
Get-ChildItem -Path $dir -Recurse -Filter *.blade.php | ForEach-Object {
    $content = Get-Content -Path $_.FullName -Raw
    $lines = $content -split "`r`n|`n"
    if ($lines.Length -gt 0) {
        $firstLine = $lines[0]
        if ($firstLine -match '^<div class=".*?min-h-screen.*?">') {
            $newLine = $firstLine -replace '\bp-\d+\b', ''
            $newLine = $newLine -replace '\bmd:p-\d+\b', ''
            $newLine = $newLine -replace '\btransition-colors\b', ''
            $newLine = $newLine -replace '\s+', ' '
            $newLine = $newLine -replace ' ">', '">'
            
            if ($newLine -cne $firstLine) {
                $lines[0] = $newLine
                $newContent = $lines -join "`n"
                Set-Content -Path $_.FullName -Value $newContent -NoNewline
                Write-Host "Updated padding: $($_.FullName)"
            }
        }
    }
}
