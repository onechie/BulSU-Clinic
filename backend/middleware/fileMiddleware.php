<?php
class File
{

    private static $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'];
    private static $allowedMimeTypes = ['image/jpeg', 'image/png', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'];
    private static $maxFileSize = 1048576 * 5; //1MB * 5 = 5MB
    public static function hasFiles($files)
    {
        $files = $files['attachments']['name'][0] ?? null;
        if ($files == null) {
            return false;
        }
        return true;
    }
    public static function formatFiles($files)
    {
        $filesCount = count($files['name']);
        $newFilesFormat = [];
        for ($i = 0; $i < $filesCount; $i++) {
            $newFilesFormat[$i] = [
                'name' => $files['name'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'size' => $files['size'][$i],
                'error' => $files['error'][$i],
                'type' => $files['type'][$i],
            ];
        }
        return $newFilesFormat;
    }
    public static function validateFiles($files)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        foreach ($files as $key => $value) {

            $file = $value['name'];
            $fileSize = $value['size'];
            $fileError = $value['error'];
            $tmpName = $value['tmp_name'];

            $fileExt = explode('.', $file);
            $fileActualExt = strtolower(end($fileExt));
            $mime_type = finfo_file($finfo, $tmpName);

            if (!in_array($fileActualExt, self::$allowedExtensions)) {
                throw new Exception($fileActualExt . " file type not allowed.");
            }
            if (!in_array($mime_type, self::$allowedMimeTypes)) {
                throw new Exception($mime_type . " file type not allowed.");
            }
            if ($fileError !== UPLOAD_ERR_OK) {
                throw new Exception("Error uploading " . $file . " file.");
            }
            if ($fileSize > self::$maxFileSize) {
                throw new Exception("File size of " . $file . " is too big.");
            }
        }
        finfo_close($finfo);
    }
    public static function uploadFiles($files, $id = 0)
    {
        $uploadedFilesData = [];
        $baseDirectory = '../../src/attachments/';
        if (!is_dir($baseDirectory)) {
            mkdir($baseDirectory, 0777, true);
        }
        foreach ($files as $key => $value) {

            $file = $value['name'];
            $fileTmpName = $value['tmp_name'];
            $fileExt = explode('.', $file);
            $fileActualExt = strtolower(end($fileExt));

            $fileDirectory = '../../src/attachments/' . $id . '/';

            if (!is_dir($fileDirectory)) {
                mkdir($fileDirectory, 0777, true);
            }

            $fileNameNew = uniqid('', true) . "." . $fileActualExt;

            $fileDestination = $fileDirectory . $fileNameNew;
            if (!move_uploaded_file($fileTmpName, $fileDestination)) {
                throw new Exception("Error uploading file.");
            }
            $uploadedFilesData[$file] = [
                'name' => $fileNameNew,
                'url' => $fileDestination,
            ];
        }
        return $uploadedFilesData;
    }
    public static function deleteFiles($files, $recordId, $alsoDirectory = false)
    {
        foreach ($files as $key => $value) {
            $file = $value['url'];
            if (file_exists($file)) {
                unlink($file);
            }
        }
        if ($alsoDirectory) {
            $fileDirectory = '../../src/attachments/' . $recordId . '/';
            if (is_dir($fileDirectory)) {
                rmdir($fileDirectory);
            }
        }
    }
    public static function deleteFile($url)
    {
        if (file_exists($url)) {
            unlink($url);
        }
    }
}
