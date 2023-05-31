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

// Сохранение TemplateProcessor во временный файл
$tempFilePath = tempnam(sys_get_temp_dir(), 'phpword_');
$template->saveAs($tempFilePath);

// Конвертация временного файла в PDF с помощью LibreOffice
$outputFile = './output.pdf';
$libreofficePath = '/usr/bin/libreoffice';
$command = "$libreofficePath --headless --convert-to pdf --outdir " . escapeshellarg(dirname($outputFile)) . ' ' . escapeshellarg($tempFilePath);
$output = shell_exec($command);

// Удаление временного файла
unlink($tempFilePath);

if (file_exists($outputFile)) {
echo 'Конвертация завершена. PDF файл создан: ' . $outputFile;
} else {
echo 'Ошибка при конвертации.';
}
