<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_COOKIE['cookies_accepted']) || $_COOKIE['cookies_accepted'] !== 'true') {
        echo "Cookie elfogadás szükséges.";
        exit;
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject_choice = $_POST['subject'];
    $message = $_POST['message'];

    $uploadFileDir = './uploaded_files/';
    
    if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0775, true); 
    }

    if (!is_writable($uploadFileDir)) {
        die("A feltöltési könyvtár nem írható.");
    }

    $file_upload_messages = [];
    $attachments = [];
    if (isset($_FILES['files']) && count($_FILES['files']['name']) > 0) {
        $totalFiles = count($_FILES['files']['name']);
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        for ($i = 0; $i < $totalFiles; $i++) {
            if ($_FILES['files']['error'][$i] == UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['files']['tmp_name'][$i];
                $fileName = $_FILES['files']['name'][$i];
                $fileSize = $_FILES['files']['size'][$i];
                $fileType = $_FILES['files']['type'][$i];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));

                if (in_array($fileExtension, $allowedfileExtensions)) {
                    $dest_path = $uploadFileDir . $fileName;

                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $file_upload_messages[] = "A fájl $fileName sikeresen feltöltve.";
                        $attachments[] = $dest_path;
                    } else {
                        $file_upload_messages[] = "Hiba történt a $fileName fájl áthelyezésekor.";
                    }
                } else {
                    $file_upload_messages[] = "A feltöltés sikertelen volt a $fileName fájl esetében. Engedélyezett fájltípusok: " . implode(',', $allowedfileExtensions);
                }
            } else {
                $file_upload_messages[] = "Nem történt fájl feltöltés, vagy hiba történt a $fileName fájl feltöltésekor.";
            }
        }
    }

    $file_upload_message = implode("\n", $file_upload_messages);

    $to = "info@dvdantikvar.hu";
    $subject = "=?UTF-8?B?" . base64_encode("Érdeklődő - $subject_choice") . "?=";


    $body = "<h1>Kapott üzenet</h1>";
    $body .= "<p><strong>Név:</strong> $name</p>";
    $body .= "<p><strong>E-mail:</strong> $email</p>";
    $body .= "<p><strong>Telefon:</strong> $phone</p>";
    $body .= "<p><strong>Tárgy:</strong> $subject_choice</p>";
    $body .= "<p><strong>Üzenet:</strong> $message</p>";
    $body .= "<p><strong>Fájl feltöltési állapot:</strong></p><pre>$file_upload_message</pre>";

    $headers = "From: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";


    $boundary = md5(time());
    $related_boundary = md5(time() + 1);

    $headers .= "Content-Type: multipart/related; boundary=\"{$boundary}\"\r\n";

    $email_message = "--{$boundary}\r\n";
    $email_message .= "Content-Type: multipart/alternative; boundary=\"{$related_boundary}\"\r\n\r\n";

    $email_message .= "--{$related_boundary}\r\n";
    $email_message .= "Content-Type: text/html; charset=UTF-8\r\n";
    $email_message .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $email_message .= $body . "\r\n\r\n";

    foreach ($attachments as $filePath) {
        if (file_exists($filePath)) {
            $fileName = basename($filePath);
            $fileData = file_get_contents($filePath);
            $fileData = chunk_split(base64_encode($fileData));
            $cid = md5($filePath);

            $email_message .= "--{$related_boundary}\r\n";
            $email_message .= "Content-Type: application/octet-stream; name=\"{$fileName}\"\r\n";
            $email_message .= "Content-Transfer-Encoding: base64\r\n";
            $email_message .= "Content-Disposition: inline; filename=\"{$fileName}\"\r\n";
            $email_message .= "Content-ID: <$cid>\r\n\r\n";
            $email_message .= $fileData . "\r\n\r\n";
        }
    }

    $email_message .= "--{$related_boundary}--\r\n";
    $email_message .= "--{$boundary}--\r\n";

    if (mail($to, $subject, $email_message, $headers)) {
        echo "<h1 style='text-align: center;'>Üzenet sikeresen elküldve!</h1>";
    } else {
        echo "Hiba történt az üzenet elküldésekor.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <title>Sikerült</title>
</head>
<body>
    <a href="index.php"><button>Vissza a főoldalra.</button></a>
</body>
</html>
