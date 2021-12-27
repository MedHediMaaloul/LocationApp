<?php

session_start();
// verification si la personn est bien passé par la page pour se connecter
if (!isset($_SESSION['User'])) {
    // echo '<center><font color="red" size="4"><b>Vous devez vous connecter pour acceder à la page <i>réseaux</i></center></font><br />';
    header("Location:login.php");
} else {
    // si elle est bien connecté alors c'est bon
    include('Gestion_location/inc/header_sidebar.php');
}
?>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Page wrapper  --
       ============================================================== -->
<div class="page-wrapper">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb bg-white">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title text-uppercase font-medium font-14">
                    Tableau de bord
                </h4>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- .col -->
            <?php
            include('Gestion_location/inc/connect_db.php');
            ?>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-heading">Tableau de bord</div>
                    <div class="card-body">

                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Les totaux
                                    enregistrés</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">

                                </div>
                            </div>
                        </div>
                        
                        <div class="row w-100">
                            <!-- Nbre total de clients  -->
                            <div class="col">
                                <div class="card border border-primary mx-sm-1 p-3" style="height: 400px;">
                                    <div class="card border border-primary shadow text-primary p-3 my-card"
                                        style="display:inline-block"><span class="fa fa-user" aria-hidden="true"
                                            style="margin-top:3px"></span></div>
                                    <div class="text-primary text-center mt-3">
                                        <h4>Nombre total de clients</h4>
                                    </div>
                                    <?php

                                    $query = "SELECT id_client FROM client ORDER BY id_client";
                                    $query_run = mysqli_query($conn, $query);
                                    $row = mysqli_num_rows($query_run);
                                    ?>
                                    <div class="text-primary text-center mt-2">
                                        <h1><?php echo $row; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <!-- Nbre total de véhicules  -->
                            <div class="col">
                                <div class="card  border border-info mx-sm-1 p-3" style="height: 400px;">
                                    <div class="card border border-info shadow text-info p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-truck" aria-hidden="true"
                                            style="margin-top:3px"></span></div>
                                    <div class="text-info text-center mt-3">
                                        <h4>Nombre total de véhicules</h4>
                                    </div>
                                    <?php
                                    $query = "SELECT id_voiture FROM voiture where actions != 'S' ORDER BY id_voiture";
                                    $query_run = mysqli_query($conn, $query);
                                    $row = mysqli_num_rows($query_run);
                                    ?>
                                    <div class="text-info text-center mt-2">
                                        <h1><?php echo $row; ?></h1>
                                    </div>
                                    <div class="card-group">
                                    <div class="card border border-info shadow text-info p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-truck"  aria-hidden="true"
                                            style="margin-top:3px"></span>
                                            <span  class="fas fa-wrench" aria-hidden="true"
                                            style="margin-top:3px"></span>
                                    <?php
                                    $query = "SELECT id_voiture  FROM voiture Where etat_voiture = 'HS' or etat_voiture = 'Entretien' ORDER BY id_voiture ";
                                    $query_run = mysqli_query($conn, $query);
                                    $row = mysqli_num_rows($query_run);
                                    ?>
                                    <h5 class="text-info text-center mt-3">Nombre de véhicules en maintenance: 
                                        <div class="text-info text-center mt-2">
                                            <h1><?php echo $row; ?></h1>
                                        </div>
                                    </h5>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Nbre total de matériels  -->
                            <div class="col">
                                <div class="card border border-secondary mx-sm-1 p-3" style="height: 400px;">
                                    <div class="card border border-secondary shadow text-secondary p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-box-open" aria-hidden="true"
                                        style="margin-top:3px"></span>
                                    </div>
                                    <div class="text-secondary text-center mt-3">
                                        <h4>Nombre total de Matériels</h4>
                                    </div>
                                    <?php
                                    $query = "SELECT id_materiels_agence 
                                                FROM materiels_agence 
                                                WHERE   etat_materiels != 'F'
                                                ORDER BY id_materiels_agence";
                                    $query_run = mysqli_query($conn, $query);
                                    $row = mysqli_num_rows($query_run);
                                    ?>
                                    <div class="text-secondary text-center mt-2">
                                        <h1><?php echo $row; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <!-- Nbre total de packs  -->
                            <div class="col">
                                <div class="card border border-dark mx-sm-1 p-3" style="height: 400px;">
                                    <div class="card border border-dark shadow text-dark p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-cube" aria-hidden="true"
                                        style="margin-top:3px"></span>
                                    </div>
                                    <div class="text-dark text-center mt-3">
                                        <h4>Nombre total de Packs</h4>
                                    </div>
                                    <?php
                                    $query = "SELECT id_group_packs 
                                                FROM group_packs 
                                                ORDER BY id_group_packs";
                                    $query_run = mysqli_query($conn, $query);
                                    $row = mysqli_num_rows($query_run);
                                    ?>
                                    <div class="text-dark text-center mt-2">
                                        <h1>
                                            <?php echo $row; ?>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            <!-- Nbre total d'entretiens  -->
                            <div class="col">
                                <div class="card border border-danger mx-sm-1 p-3" style="height: 400px;">
                                    <div class="card border border-danger shadow text-danger p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-wrench" aria-hidden="true"
                                            style="margin-top:3px"></span>
                                    </div>
                                    <div class="text-danger text-center mt-3">
                                        <h4>Nombre total d'entretiens</h4>
                                    </div>
                                    <?php
                                    $query = "SELECT id_entretien FROM entretien  ORDER BY id_entretien";
                                    $query_run = mysqli_query($conn, $query);
                                    $row = mysqli_num_rows($query_run);
                                    ?>
                                    <div class="text-danger text-center mt-2">
                                        <h1><?php echo $row; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <!-- Nbre total de factures  -->
                            <div class="col">
                                <div class="card border border-success mx-sm-1 p-3" style="height: 400px;">
                                    <div class="card border border-success shadow text-success p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-list-alt" aria-hidden="true"
                                            style="margin-top:3px"></span>
                                    </div>
                                    <div class="text-success text-center mt-3">
                                        <h4>Nombre total de factures</h4>
                                    </div>
                                    <?php
                                    $query = "SELECT id_facture FROM facture_client ORDER BY id_facture";
                                    $query_run = mysqli_query($conn, $query);
                                    $row = mysqli_num_rows($query_run);
                                    ?>
                                    <div class="text-success text-center mt-2">
                                        <h1><?php echo $row; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <!-- Nbre total de contrats  -->
                            <div class="col">
                                <div class="card border border-warning mx-sm-1 p-3" style="width: 400px; height: 400px;">
                                    <div class="card border border-warning shadow text-warning p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-calendar"
                                        aria-hidden="true" style="margin-top:3px"></span>
                                    </div>
                                    <div class="text-warning text-center mt-3">
                                        <h4>Nombre total de contrats</h4>
                                    </div>
                                    <?php
                                    $query = "SELECT id_contrat  FROM contrat_client ORDER BY id_contrat ";
                                    $query_run = mysqli_query($conn, $query);
                                    $row = mysqli_num_rows($query_run);
                                    ?>
                                    <div class="text-warning text-center mt-2">
                                        <h1><?php echo $row; ?></h1>
                                    </div>
                                <!-- Groupe des contrats  -->
                                <div class="card-group">
                                    <div class="card border border-warning shadow text-warning p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-truck" aria-hidden="true"
                                        style="margin-top:3px"></span>
                                        <?php
                                        $query = "SELECT id_contrat  FROM contrat_client Where type_location = 'Vehicule'ORDER BY id_contrat ";
                                        $query_run = mysqli_query($conn, $query);
                                        $row = mysqli_num_rows($query_run);
                                        ?>
                                        <h5 class="text-warning text-center mt-3">Nombre total de contrats véhicule : 
                                            <div class="text-warning text-center mt-2">
                                                <h1><?php echo $row; ?></h1>
                                            </div>
                                        </h5>
                                    </div>
                                
                                
                                    <div class="card border border-warning shadow text-warning p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-box-open" aria-hidden="true"
                                        style="margin-top:3px"></span>
                                        <?php
                                        $query = "SELECT id_contrat  FROM contrat_client Where type_location = 'Materiel' ORDER BY id_contrat ";
                                        $query_run = mysqli_query($conn, $query);
                                        $row = mysqli_num_rows($query_run);
                                        ?>
                                        <h5 class="text-warning text-center mt-3">Nombre total de contrats matériel :
                                            <div class="text-warning text-center mt-2">
                                                <h1><?php echo $row; ?></h1>
                                            </div>
                                        </h5>
                                    </div>
                                

                                    <div class="card border border-warning shadow text-warning p-3 my-card"
                                        style="display:inline-block"><span class="fas fa-cube" aria-hidden="true"
                                        style="margin-top:3px"></span>
                                        <?php
                                        $query = "SELECT id_contrat  FROM contrat_client Where type_location = 'Pack' ORDER BY id_contrat ";
                                        $query_run = mysqli_query($conn, $query);
                                        $row = mysqli_num_rows($query_run);
                                        ?>
                                        <h5 class="text-warning text-center mt-3">Nombre total de contrats pack : 
                                            <div class="text-warning text-center mt-2">
                                                <h1><?php echo $row; ?></h1>
                                            </div>
                                        </h5>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>    
                            
                        <!-- Les pourcentages  -->
                            
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">les pourcentages enregistrés</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm" id="voiturechart" style="width: 100px; height: 200px;"></div>
                                    <div class="col-sm" id="materielchart" style="width: 100px; height: 200px;"></div>
                                    <div class="col-sm" id="packchart" style="width: 100px; height: 200px;"></div>
                                    <div class="col-sm" id="entretienchart" style="width: 100px; height: 200px;"></div>
                                    <div class="col-sm" id="contratchart" style="width: 100px; height: 200px;"></div>
                                    <div class="col-sm" id="facturechart" style="width: 100px; height: 200px;"></div>   
                                </div>

                                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                                <script type="text/javascript">
                                    google.charts.load('current', {
                                        'packages': ['corechart']
                                    });
                                    google.charts.setOnLoadCallback(drawChartVoiture);
                                    google.charts.setOnLoadCallback(drawChartMateriel);
                                    google.charts.setOnLoadCallback(drawChartPack); 
                                    google.charts.setOnLoadCallback(drawChartEntretien);
                                    google.charts.setOnLoadCallback(drawChartContrat);
                                    google.charts.setOnLoadCallback(drawChartFacture);
                                
                                    function drawChartEntretien() {
                                        var data = google.visualization.arrayToDataTable([
                                            ['type', 'Number'],
                                            <?php
                                                $query = "SELECT type, count(*) as number FROM entretien GROUP BY type";
                                                $result = mysqli_query($conn, $query);
                                                ?>
                                            <?php
                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo "['" . $row["type"] . "', " . $row["number"] . "],";
                                                }
                                                ?>
                                        ]);
                                        var options = {
                                            title: 'Taux d\'Entretiens par type',
                                            colors: ['#f2a5b3', '#e0321e'],
                                            is3D:true,  
                                            pieHole: 0.3
                                        };
                                        var chart = new google.visualization.PieChart(document.getElementById('entretienchart'));
                                        chart.draw(data, options);
                                    }

                                    function drawChartPack() {
                                        var data = google.visualization.arrayToDataTable([
                                            ['type', 'Number'],
                                            <?php
                                                $query = "SELECT etat_group_pack, count(id_group_packs) as number FROM group_packs GROUP BY etat_group_pack";
                                                $result = mysqli_query($conn, $query);
                                                ?>
                                            <?php
                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo "['" . $row["etat_group_pack"] . "', " . $row["number"] . "],";
                                                }
                                                ?>
                                        ]);
                                        var options = {
                                            title: 'Taux de Packs par etat',
                                            colors: ['#f2a500', '#e03200', '#e45200'],
                                            is3D:true,  
                                            pieHole: 0.3
                                        };
                                        var chart = new google.visualization.PieChart(document.getElementById('packchart'));
                                        chart.draw(data, options);
                                    }

                                    function drawChartFacture() {
                                        var data = google.visualization.arrayToDataTable([
                                            ['type', 'Number'],
                                            <?php
                                                $query = "SELECT C.type_location, count(F.id_facture) as number FROM facture_client As F LEFT JOIN contrat_client AS C ON F.id_contrat =C.id_contrat 
                                                 GROUP BY C.type_location";
                                                $result = mysqli_query($conn, $query);
                                                ?>
                                            <?php
                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo "['" . $row["type_location"] . "', " . $row["number"] . "],";
                                                }
                                                ?>
                                        ]);
                                        var options = {
                                            title: 'Taux de Factures par type',
                                            colors: ['#E9A7A7', '#F56AB4', '#F56AF5'],
                                            is3D:true,  
                                            pieHole: 0.3
                                        };
                                        var chart = new google.visualization.PieChart(document.getElementById('facturechart'));
                                        chart.draw(data, options);
                                    }

                                    function drawChartMateriel() {
                                        var data = google.visualization.arrayToDataTable([
                                            ['type', 'Number'],
                                            <?php
                                                $query = "SELECT etat_materiels, count(id_materiels_agence) as number FROM materiels_agence  GROUP BY etat_materiels";
                                                $result = mysqli_query($conn, $query);
                                                ?>
                                            <?php
                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo "['" . $row["etat_materiels"] . "', " . $row["number"] . "],";
                                                }
                                                ?>
                                        ]);
                                        var options = {
                                            title: 'Taux de Materiels par état',
                                            colors: ['#6AF5C6', '#6ADEF5', '#6AAFF5'],
                                            is3D:true,  
                                            pieHole: 0.3
                                        };
                                        var chart = new google.visualization.PieChart(document.getElementById('materielchart'));
                                        chart.draw(data, options);
                                    }
                                
                                    function drawChartVoiture() {
                                        var data = google.visualization.arrayToDataTable([
                                            ['type', 'Number'],
                                            <?php
                                                $query = "SELECT dispo, count(*) as number FROM voiture GROUP BY dispo";
                                                $result = mysqli_query($conn, $query);
                                                ?>
                                            <?php
                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo "['" . $row["dispo"] . "', " . $row["number"] . "],";
                                                }
                                                ?>
                                        ]);
                                        var options = {
                                            title: 'Taux de Véhicules par disponibilité',
                                            colors: ['#0275d8', '#5bc0de'],
                                            is3D:true,  
                                            pieHole: 0.3
                                        };
                                        var chart = new google.visualization.PieChart(document.getElementById('voiturechart'));
                                        chart.draw(data, options);
                                    }

                                    function drawChartContrat() {
                                        var data = google.visualization.arrayToDataTable([
                                            ['type', 'Number'],
                                            <?php
                                                $query = "SELECT type_location, count(*) as number FROM contrat_client GROUP BY type_location";
                                                $result = mysqli_query($conn, $query);
                                                ?>
                                            <?php
                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo "['" . $row["type_location"] . "', " . $row["number"] . "],";
                                                }
                                                ?>
                                        ]);
                                        var options = {
                                            title: 'Taux de Contrats par type',
                                            colors: ['#F5B56B', '#F5A26B', '#F5796B'],
                                            is3D:true,  
                                            pieHole: 0.3
                                        };
                                        var chart = new google.visualization.PieChart(document.getElementById('contratchart'));
                                        chart.draw(data, options);
                                    }
                                </script>



                        <div class="row  no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Véhicule disponibles</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        $value = '<table class="table table-striped table-bordered table-hover">
                                                    <tr class="thead-dark">
                                                        <th class="border-top-0">ID Voiture</th>
                                                        <th class="border-top-0">Marque Voiture</th>
                                                        <th class="border-top-0">Modèle Voiture</th>
                                                        <th class="border-top-0">Immatriculation Voiture</th>
                                                    </tr>';
                                        $query = "SELECT V.id_voiture,V.pimm,MM.Marque,MM.Model
                                        FROM voiture as V 
                                        left JOIN marquemodel as MM on V.id_MarqueModel=MM.id_MarqueModel
                                        WHERE etat_voiture='Disponible' ";

                                        $result = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $value .= '               
                                                <tr>
                                                    <td class="border-top-0 font-weight-bold">' . $row['id_voiture'] . '</td>
                                                    <td class="border-top-0 font-weight-bold">' . $row['Marque'] . '</td>
                                                    <td class="border-top-0 font-weight-bold">' . $row['Model'] . '</td>
                                                    <td class="border-top-0 font-weight-bold">' . $row['pimm'] . '</td>
                                                </tr>';
                                        }
                                        $value .= '</table>';
                                        echo $value;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                                    
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Contrats impayés</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"></div>
                                <div class="row">
                                    <div class="col-12">
                                        <?php
                                        $value = '<table class="table table-striped table-bordered table-hover">
                                                            <tr class="thead-dark">
                                                                <th class="border-top-0">ID Contrat</th>
                                                                <th class="border-top-0">Dernière Facture Payé</th>
                                                                <th class="border-top-0">Type Contrat</th>
                                                                <th class="border-top-0">Date Fin</th>
                                                                <th class="border-top-0">Nom Client</th>
                                                                <th class="border-top-0">Email Client</th>
                                                                <th class="border-top-0">Téléphone Client</th>
                                                                <th class="border-top-0">Adresse Client</th>  
                                                            </tr>';
                                        $query = "SELECT F.id_facture,C.id_contrat,C.type_location,C.date_fin,CL.nom,CL.email,CL.tel,CL.adresse
                                                        FROM contrat_client as C
                                                        left JOIN facture_client as F on C.id_contrat=F.id_contrat
                                                        left JOIN client as CL on C.id_client=CL.id_client
                                                        WHERE F.date_facture = C.date_fin";
                                        $result = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        $value .= '               
                                                            <tr>
                                                                <td class="border-top-0 font-weight-bold">' . $row['id_contrat'] . '</td>
                                                                <td class="border-top-0 font-weight-bold">' . $row['id_facture'] . '</td>
                                                                <td class="border-top-0 font-weight-bold">' . $row['type_location'] . '</td>
                                                                <td class="border-top-0 font-weight-bold">' . $row['date_fin'] . '</td>
                                                                <td class="border-top-0 font-weight-bold">' . $row['nom'] . '</td>
                                                                <td class="border-top-0 font-weight-bold">' . $row['email'] . '</td>
                                                                <td class="border-top-0 font-weight-bold">' . $row['tel'] . '</td>
                                                                <td class="border-top-0 font-weight-bold">' . $row['adresse'] . '</td>
                                                            </tr>';
                                        }
                                        $value .= '</table>';
                                        echo $value;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                
                                                
                                                <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Contrats qui
                                                        prendront fin</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-9">
                                                            <?php
                                                            $value = '<table class="table table-striped table-bordered table-hover">
                                                                    <tr class="thead-dark">
                                                                        <th class="border-top-0">ID Contrat</th>
                                                                        <th class="border-top-0">Type Contrat</th>
                                                                        <th class="border-top-0">Date Fin</th>
                                                                        <th class="border-top-0">Nom Client</th>
                                                                        <th class="border-top-0">Email Client</th>
                                                                        <th class="border-top-0">Téléphone Client</th>
                                                                        <th class="border-top-0">Adresse Client</th>
                                                                    </tr>';
                                                            $query = "SELECT C.id_contrat,C.type_location,C.date_fin,CL.nom,CL.email,CL.tel,CL.adresse FROM `contrat_client` as C left JOIN client as CL on C.id_client=CL.id_client
                                                             WHERE (DATE(NOW()) BETWEEN DATE_SUB(C.date_fin, INTERVAL 7 DAY) AND DATE_SUB(C.date_fin, INTERVAL -3 DAY))";

                                                            $result = mysqli_query($conn, $query);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $value .= '               
                                                                        <tr>
                                                                            <td class="border-top-0 font-weight-bold">' . $row['id_contrat'] . '</td>
                                                                            <td class="border-top-0 font-weight-bold">' . $row['type_location'] . '</td>
                                                                            <td class="border-top-0 font-weight-bold">' . $row['date_fin'] . '</td>
                                                                            <td class="border-top-0 font-weight-bold">' . $row['nom'] . '</td>
                                                                            <td class="border-top-0 font-weight-bold">' . $row['email'] . '</td>
                                                                            <td class="border-top-0 font-weight-bold">' . $row['tel'] . '</td>
                                                                            <td class="border-top-0 font-weight-bold">' . $row['adresse'] . '</td>
                                                                        </tr>';
                                                            }
                                                            $value .= '</table>';
                                                            echo $value;
                                                            ?>
                                                        </div>




                                    <div class="col-3">
                                        <div class="box-part text-center align-middle " style="margin-top: 5px;">
                                            <i class="fas fa-star text-secondary" style="font-size: 40px;"></i>
                                            <i class="fas fa-star" style="font-size: 70px;"></i>
                                            <i class="fas fa-star text-secondary" style="font-size: 40px;"></i>
                                            <div class="title">
                                                <h3 class="text-uppercase">Meilleur client</h3>
                                            </div>
                                            <div class="text border border-dark">
                                                <?php
                                                $query = "SELECT id_client,nom,email,adresse from client where id_client= (SELECT id_client from contrat_client  group by  id_client having (COUNT(id_client)>1) LIMIT 1)";
                                                $result = mysqli_query($conn, $query);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<h1 class="font-weight-bold text-uppercase mb-1">' . '<span>' . $row['nom'] . '</span></h1>';
                                                    echo '<h3>' . '<span class="text-uppercase mb-1">Email:</span>' . ' ' . '<span class="font-weight-bold">' . $row['email'] . '</span></h3>';
                                                    echo '<h3>' . '<span class="text-uppercase mb-1">Adresse:</span>' . ' ' . '<span class="font-weight-bold">' . $row['adresse'] . '</span></h3>';
                                                }
                                                ?>
                                                <?php
                                                $query = "SELECT id_client,COUNT(`id_client`) AS `value_occurrence`  from contrat_client  group by id_client having (COUNT(id_client)>1) LIMIT 1";
                                                $result = mysqli_query($conn, $query);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<h3>' . '<span class="text-uppercase mb-1">Nombre de locations:</span>' . ' ' . '<span class="font-weight-bold">' . $row['value_occurrence'] . '</span></h3>';
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>

                                
                                </div>
                            </div>
                        </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
    </div>
    <?php
    include('Gestion_location/inc/footer.php')
    ?>
    </body>

    </html>