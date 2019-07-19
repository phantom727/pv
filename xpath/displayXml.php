 <!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Titel</title>
  </head>
  <body>
<?php
function endsWith($haystack, $needle) {
    return substr_compare($haystack, $needle, -strlen($needle)) === 0;
}

$fileName = $_FILES['xmlFile']['name'];
$endsWithXml = endsWith($fileName,".xml");

if ($endsWithXml){
  echo "Dateiname endet mit XML";
} else {
  echo "Dateiname endet nicht mit XML";
}

echo "result of endsWith:" . endsWith($fileName,".xml");
// echo $fileName;
?>
  </body>
</html>