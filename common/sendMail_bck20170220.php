<?php
require_once "./libfpdf.php";

//Invok rederizsoftFunctionPDF - Genera PDF
rederizsoftFunctionPDF($pd,$vRo,$vtechName,$vPriority,$vType,$vVin,$vComments,$vpartsJSON,$vDate,$vStatus,$eMail);

//Invok rederizsoftFunctionMail - Crea mail y envia
rederizsoftFunctionMail($vtechName,$eMail,$from,$fromName,$pass,$mail,$subject,$body,$vRo,$vDate,$dir,$vStatus,$time,$dbh);
?>