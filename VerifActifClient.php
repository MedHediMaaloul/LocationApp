<?php
include('Gestion_location/inc/connect_db.php');
$query = "SELECT id_client FROM client";
$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($result)){
    $idclient=$row['id_client'];
    $querydate = "  SELECT   contrat_client.date_fin 
  FROM client,contrat_client 
  WHERE client.id_client=contrat_client.id_client 
  and contrat_client.date_fin=(select MAX(date_fin) FROM contrat_client where  id_client=$idclient)";
    $resultdate = mysqli_query($conn, $querydate);
    while($rowdate = mysqli_fetch_assoc($resultdate)){
        $st= $rowdate['date_fin'];
        $st = strtotime("+3 months", strtotime($st));
       date("Y-m-d",$st);
      $sysdate=date("Y-m-d");

         $sysdate = strtotime(($sysdate));
         date("Y-m-d",$sysdate);


      if ($sysdate>$st){
         $qt= " UPDATE client set etat_client= 'I' where  id_client=$idclient  ";
          $res = mysqli_query($conn, $qt);

//          echo $etat="I";

        }

    }
    echo "<br>";

}
