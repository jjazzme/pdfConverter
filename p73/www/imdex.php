<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {

        $regex = '/^doc_to_pdf_conv_.+\..+/';
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

        $file = $_FILES['file'];
        if ($file['error'] === UPLOAD_ERR_OK) {
            $tempFilePath = $file['tmp_name'];
            echo $tempFilePath;

        } else {
            http_response_code(400);
            echo 'file upload error';
        }
    } else {
        http_response_code(400);
        echo 'no file';
    }
} else {
    http_response_code(400);
    echo 'no post';
}