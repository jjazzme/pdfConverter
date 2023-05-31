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


$regex = '/^phpword_.+$/';
$timestamp = time() - 300;
$files = scandir(sys_get_temp_dir());
foreach ($files as $file) {
    if (preg_match($regex, $file)) {
        $filePath = sys_get_temp_dir() . '/' . $file;
        $fileCreationTime = filectime($filePath);
        if ($fileCreationTime <= $timestamp) {
            unlink($filePath);
        }
    }
}

$targetPath = tempnam(sys_get_temp_dir(), 'phpword_');
$template->saveAs($targetPath);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://p73');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
$fileData = curl_file_create($targetPath, mime_content_type($targetPath), basename($targetPath));
$postData = array('file' => $fileData);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
$response = curl_exec($curl);
curl_close($curl);
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="output.pdf"');
echo $response;
