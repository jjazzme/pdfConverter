<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {

        $regex = '/^.+\.pdf$/';
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
            $sourcePath = $file['tmp_name'];
            $targetPath = $sourcePath . '.pdf';
            $libreofficePath = '/usr/bin/libreoffice';
            $command = "$libreofficePath --headless --convert-to pdf --outdir " . escapeshellarg(sys_get_temp_dir()) . ' ' . escapeshellarg($sourcePath);
            $output = shell_exec($command);
            unlink($sourcePath);

            if (file_exists($targetPath)) {
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="output.pdf"');
                readfile($targetPath);
                exit;
            } else {
                echo 'conversion error';
            }

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