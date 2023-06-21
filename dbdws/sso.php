<?php
$entityBody = json_decode(file_get_contents('php://input'),1);

echo "<pre>" ;
print_r($entityBody);
echo "</pre>" ;
exit();


?>