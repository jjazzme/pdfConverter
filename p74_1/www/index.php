<?php
require 'vendor/autoload.php';
use PhpOffice\PhpWord\TemplateProcessor;
$template = new TemplateProcessor('./doc.docx');
$imagePath = './sign.png';
$template->setImageValue('podpisantPodpis', [
    'path' => $imagePath,
    'width' => '200px',
    'height' => '200px',
    'ratio' => true
]);


$regex1 = '/^phpword_.+$/';
$regex2 = '/^.+\.pdf$/';
$timestamp = time() - 300;
$files = scandir(sys_get_temp_dir());
foreach ($files as $file) {
    if (preg_match($regex1, $file) || preg_match($regex2, $file)) {
        $filePath = sys_get_temp_dir() . '/' . $file;
        $fileCreationTime = filectime($filePath);
        if ($fileCreationTime <= $timestamp) {
            unlink($filePath);
        }
    }
}

$sourcePath = tempnam(sys_get_temp_dir(), 'phpword_');
$template->saveAs($sourcePath);

$targetPath = $sourcePath . '.pdf';
$libreofficePath = '/usr/bin/libreoffice';
$command = "$libreofficePath --headless --convert-to pdf --outdir " . escapeshellarg(sys_get_temp_dir()) . ' ' . escapeshellarg($sourcePath);
$output = shell_exec($command);
unlink($sourcePath);
if (file_exists($targetPath)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="output.pdf"');
    readfile($targetPath);
} else {
    echo 'conversion error';
}
