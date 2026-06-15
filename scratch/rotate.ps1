Add-Type -AssemblyName System.Drawing
$filePath = "c:\xampp\htdocs\Laika\assets\img\gallery\img-23.jpeg"
$img = [System.Drawing.Image]::FromFile($filePath)
$img.RotateFlip([System.Drawing.RotateFlipType]::Rotate270FlipNone)
$img.Save($filePath, [System.Drawing.Imaging.ImageFormat]::Jpeg)
$img.Dispose()
Write-Output "Image rotated successfully using PowerShell System.Drawing."
