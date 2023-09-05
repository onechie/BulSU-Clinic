<?php
class File
{

    private static $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt'];
    private static $allowedMimeTypes = ['image/jpeg', 'image/png', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'];
    private static $allowedPictureExtensions = ['jpg', 'jpeg', 'png'];
    private static $allowedPictureMimeTypes = ['image/jpeg', 'image/png'];
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
        $baseDirectory = __DIR__ . '/../../src/attachments/';
        if (!is_dir($baseDirectory)) {
            mkdir($baseDirectory, 0777, true);
        }
        foreach ($files as $key => $value) {

            $file = $value['name'];
            $fileTmpName = $value['tmp_name'];
            $fileExt = explode('.', $file);
            $fileActualExt = strtolower(end($fileExt));

            $fileDirectory = __DIR__ . '/../../src/attachments/' . $id . '/';

            if (!is_dir($fileDirectory)) {
                mkdir($fileDirectory, 0777, true);
            }

            $fileNameNew = uniqid('', true) . "." . $fileActualExt;

            $fileDestination = $fileDirectory . $fileNameNew;
            if (!move_uploaded_file($fileTmpName, $fileDestination)) {
                throw new Exception("Error uploading file.");
            }
            $fileUrl = '/src/attachments/' . $id . '/' . $fileNameNew;
            $uploadedFilesData[$file] = [
                'name' => $file,
                'url' => $fileUrl,
            ];
        }
        return $uploadedFilesData;
    }
    public static function deleteFiles($files, $recordId, $alsoDirectory = false)
    {
        foreach ($files as $key => $value) {
            $url = __DIR__ . '/../..' . $value['url'];
            if (file_exists($url)) {
                unlink($url);
            }
        }
        if ($alsoDirectory) {
            $fileDirectory =  __DIR__ . '/../../src/attachments/' . $recordId . '/';
            if (is_dir($fileDirectory)) {
                rmdir($fileDirectory);
            }
        }
    }
    public static function deleteFile($url)
    {
        $url = __DIR__ . '/../..' . $url;
        if (file_exists($url)) {
            unlink($url);
        }
    }

    //HANDLING PROFILE PICTURES
    public static function hasPicture($file)
    {
        if ($file['profilePicture']['name'] == null) {
            return false;
        }
        return true;
    }
    public static function formatPicture($file)
    {
        $newFileFormat = [
            'name' => $file['name'],
            'tmp_name' => $file['tmp_name'],
            'size' => $file['size'],
            'error' => $file['error'],
            'type' => $file['type'],
        ];
        return $newFileFormat;
    }
    public static function validatePicture($picture)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file = $picture['name'];
        $fileSize = $picture['size'];
        $fileError = $picture['error'];
        $tmpName = $picture['tmp_name'];

        $fileExt = explode('.', $file);
        $fileActualExt = strtolower(end($fileExt));
        $mime_type = finfo_file($finfo, $tmpName);

        if (!in_array($fileActualExt, self::$allowedPictureExtensions)) {
            throw new Exception($fileActualExt . " file type not allowed.");
        }
        if (!in_array($mime_type, self::$allowedPictureMimeTypes)) {
            throw new Exception($mime_type . " file type not allowed.");
        }
        if ($fileError !== UPLOAD_ERR_OK) {
            throw new Exception("Error uploading " . $file . " file.");
        }
        if ($fileSize > self::$maxFileSize) {
            throw new Exception("File size of " . $file . " is too big.");
        }
        finfo_close($finfo);
    }
    public static function uploadPicture($picture, $id = 0)
    {
        $uploadedPictureData = [];
        $baseDirectory = __DIR__ . '/../../src/images/profiles/';

        if (!is_dir($baseDirectory)) {
            mkdir($baseDirectory, 0777, true);
        }
        $file = $picture['name'];
        $fileTmpName = $picture['tmp_name'];
        $fileExt = explode('.', $file);
        $fileActualExt = strtolower(end($fileExt));

        $fileDirectory = __DIR__ . '/../../src/images/profiles/' . $id . '/';
        if (!is_dir($fileDirectory)) {
            mkdir($fileDirectory, 0777, true);
        }
        $fileNameNew = uniqid('', true) . "." . $fileActualExt;

        $fileDestination = $fileDirectory . $fileNameNew;
        if (!move_uploaded_file($fileTmpName, $fileDestination)) {
            throw new Exception("Error uploading file.");
        }
        $fileUrl = '/src/images/profiles/' . $id . '/' . $fileNameNew;
        $uploadedPictureData = [
            'name' => $fileNameNew,
            'url' => $fileUrl,
        ];

        return $uploadedPictureData;
    }
}
