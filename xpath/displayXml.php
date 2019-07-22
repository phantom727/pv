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






function extractFirstName($i, $xpath) {
	$query  = "/*[local-name()='rechnungen' and namespace-uri()='http://padinfo.de/ns/pad']/*[local-name()='rechnung' and namespace-uri()='http://padinfo.de/ns/pad'][" . $i . "]/*[local-name()='rechnungsempfaenger' and namespace-uri()='http://padinfo.de/ns/pad'][1]/*[local-name()='person' and namespace-uri()='http://padinfo.de/ns/pad'][1]/*[local-name()='vorname' and namespace-uri()='http://padinfo.de/ns/pad'][1]";
	$nodeList = $xpath->evaluate($query);
	
	return $nodeList->item(0)->nodeValue ;
}





















function extractLastName($i, $xpath) {
	$query  = "/*[local-name()='rechnungen' and namespace-uri()='http://padinfo.de/ns/pad']/*[local-name()='rechnung' and namespace-uri()='http://padinfo.de/ns/pad'][" . $i . "]/*[local-name()='rechnungsempfaenger' and namespace-uri()='http://padinfo.de/ns/pad'][1]/*[local-name()='person' and namespace-uri()='http://padinfo.de/ns/pad'][1]/*[local-name()='name' and namespace-uri()='http://padinfo.de/ns/pad'][1]";
	$nodeList = $xpath->evaluate($query);
	
	return $nodeList->item(0)->nodeValue ;
}

$fileName = $_FILES['xmlFile']['name'];
$endsWithXml = endsWith($fileName,".xml");

if ($_FILES["xmlFile"]["error"] > 0)
{
  echo "Error: " . $_FILES["xmlFile"]["error"] . "<br />";
}


if (!$endsWithXml){
  echo "Dateiname endet nicht mit XML";
  die();
}

//echo "Dateiname endet mit XML";

$uploadedFileName = 'upload/'.$_FILES['xmlFile']['name'];
$uploadResult = move_uploaded_file($_FILES['xmlFile']['tmp_name'], $uploadedFileName);

echo "Ergebnis des Hochladens:" . $uploadResult . "<br>";

$tmpFileName = $_FILES['xmlFile']['tmp_name'];

echo "Temporäre Datei:" . $tmpFileName;
// echo $fileName;

 $myfile = fopen($uploadedFileName, "r") or die("Unable to open file!");
//echo "<pre>" . fread($myfile,filesize($uploadedFileName)) . "</pre>";

$xmlText = fread($myfile,filesize($uploadedFileName));

fclose($myfile);

$doc = new DOMDocument;

// We don't want to bother with white spaces
$doc->preserveWhiteSpace = false;
$doc->loadXML($xmlText);

$xpath = new DOMXPath($doc);

$query = "count(/*[local-name()='rechnungen' and namespace-uri()='http://padinfo.de/ns/pad']/*[local-name()='rechnung' and namespace-uri()='http://padinfo.de/ns/pad'])";

//$xpath->evaluate($query);
$RechungAnzahl = $xpath->evaluate($query);

for ($i = 1; $i <= $RechungAnzahl ; $i++) {
    echo "<h3>Rechnung Nummer:".$i."</h3>";
	$name = extractLastName($i, $xpath);
	$firstName = extractFirstName($i, $xpath);
	echo "Name:". $name."<br>";
	echo "Vorname:".$firstName;
}




?>
  </body>
</html>