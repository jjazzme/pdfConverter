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
$stream = fopen('php://temp', 'r+');
$template->save($stream);
rewind($stream);
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: inline; filename="output.docx"');
fpassthru($stream);
fclose($stream);
exit;

//$targetPath = tempnam(sys_get_temp_dir(), 'phpword_');
//$template->saveAs($targetPath);
//if (file_exists($targetPath)) {
//    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
//    header('Content-Disposition: inline; filename="output.pdf"');
//    readfile($targetPath);
//    exit;
//} else {
//    echo 'conversion error';
//}
