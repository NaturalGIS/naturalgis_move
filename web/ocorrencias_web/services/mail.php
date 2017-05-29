<?php
$to      = 'gmanghi@uevora.pt';
$subject = 'Nova ocorrência';

  $headers .= "Reply-To: " . $utilizador . "\r\n";
  $headers .= "Return-Path: " . $utilizador . "\r\n";
  $headers .= "From: " . $nome_utilizador . " <" . $utilizador . ">\r\n";
  #$headers .= 'Cc: amira@uevora.pt' . "\r\n";  
  $headers .= "Organization: Universidade de Évora\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
  $headers .= "X-Priority: 3\r\n";
  $headers .= "X-Mailer: PHP". phpversion() ."\r\n";

    if (($observation == 'exacta') && ($local_type != 'grid'))
       {
       $message_formatted = "Observador: " . $utilizador . "\n" .
                         "Especie: " . $safeInputs['especie'] . "\n" .
                         "Coordenadas UTM 29N: " . $safeInputs['xcoord'] . "," . $safeInputs['ycoord'] . "\n" .
                         "Grelha 10km: " . $utm10Data['utm'] . "\n" .
                         "Grelha 2km: " . $utm2Data['utm'] . "\n" .
                         "Local: " . $freguesia . "\n" .
                         "Data: " . $data  . "\n";
       }
    elseif (($observation == 'exacta') && ($local_type == 'grid'))
       {
        $message_formatted = "Observador: " . $utilizador . "\n" .
                         "Especie: " . $safeInputs['especie'] . "\n" .
                         "Coordenadas UTM 29N centroide grelha: " . $safeInputs['xcoord'] . "," . $safeInputs['ycoord'] . "\n" .
                         "Grelha 10km: " . $utm10Data['utm'] . "\n" .
                         "Grelha 2km: " . $utm2Data['utm'] . "\n" .
                         "Local: " . $freguesia . "\n" .
                         "Data: " . $data  . "\n";
       }
    elseif (($observation != 'exacta') && ($local_type != 'grid'))
       {
       $message_formatted = "Observador: " . $utilizador . "\n" .
                         "Classe sistematica: " . $ec . "\n" .
                         "Coordenadas UTM 29N: " . $safeInputs['xcoord'] . "," . $safeInputs['ycoord'] . "\n" .
                         "Grelha 10km: " . $utm10Data['utm'] . "\n" .
                         "Grelha 2km: " . $utm2Data['utm'] . "\n" .
                         "Local: " . $freguesia . "\n" .
                         "Data: " . $data  . "\n";
       }
    elseif (($observation != 'exacta') && ($local_type == 'grid'))
       {
       $message_formatted = "Observador: " . $utilizador . "\n" .
                         "Classe sistematica: " . $ec . "\n" .
                         "Coordenadas UTM 29N centroide grelha: " . $safeInputs['xcoord'] . "," . $safeInputs['ycoord'] . "\n" .
                         "Grelha 10km: " . $utm10Data['utm'] . "\n" .
                         "Grelha 2km: " . $utm2Data['utm'] . "\n" .
                         "Local: " . $freguesia . "\n" .
                         "Data: " . $data  . "\n";
       }
    else
       {
        $message_formatted = "Observador: " . $utilizador . "\n" .
                         "Data: " . $data  . "\n";
       }

mail($to, $subject, $message_formatted, $headers);
?>
