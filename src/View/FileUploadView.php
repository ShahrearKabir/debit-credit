<?php
// header('Content-Type: application/json');
use DebitCredit\View\FileUpload;

if (isset($_FILES['image'])) {
    $errors = array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $var_ext = explode('.', $file_name);
    $file_ext = strtolower(end($var_ext));

    $extensions = array("jpeg", "jpg", "png", "csv");

    // print_r($file_name);

    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
    }

    if ($file_size > 2097152) {
        $errors[] = 'File size must be excately 2 MB';
    }

    if (empty($errors) == true) {
        // move_uploaded_file($file_tmp, "images/" . $file_name);
        $fileUpload = new FileUpload();

        // print_r($file_tmp);
        if ($file_ext === 'csv') {
            $fileUpload->fileHandleCSV($file_tmp);
        }

        // echo "Success";
        $fileUpload->getCSVData();
    } else {
        print_r($errors);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Debit Credit</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" />
        <br/>
        <input type="submit" />
    </form>
</body>

<script>
    
</script>

</html>