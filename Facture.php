<?php
if (isset($_GET["submit"])){
    $numero=$_GET["numero"];
    $date=$_GET["date"];
    $client=$_GET["client"];
    $designations=$_GET["designation"];
    $quantites=$_GET["quantite"];
    $prixs=$_GET["prix"];
    $montants=$_GET["montant"];
    echo "numero: ".$numero." date: ".$date." client: ".$client."</br>";
    foreach($designations as $designation){
        echo " designation : ".$designation;
    }
    echo "</br>";
    foreach($quantites as $quantite){
        echo " quantite : ".$quantite;
    }
    echo "</br>";
    foreach($prixs as $prix){
        echo " prix : ".$prix;
    }
    echo "</br>";
    foreach($montants as $montant){
        echo " montant : ".$montant;
    }
    echo "</br>";
}
?>
<form action="" method="GET">
    <div>
    <label>numero</label>
    <input type="text" name="numero" id="numero" />
    <label>date</date>
    <input type="date" name="date" id="date" />
    <label>client</label>
    <select name="client" id="client">
        <option value="mohamed">mohamed</option>
        <option value="bilel">bilel</option>
        <option value="amel">amel</option>
</select>
</div>
<div>
    <table border=1>
        <tr>
            <td> designation </td>
            <td> quantite</td>
            <td> prix</td>
            <td> montant</td>
        </tr>
        <tr>
            <td><input type="text" name="designation[]" id="designation1"/> </td>
            <td><input type="text" name="quantite[]" class="element" id="quantite1"/> </td>
            <td><input type="text" name="prix[]" class="element" id="prix1"/> </td>
            <td><input type="text" name="montant[]" id="montant1"/> </td>
        </tr>
        <tr>
            <td><input type="text" name="designation[]" id="designation2"/> </td>
            <td><input type="text" name="quantite[]" class="element" id="quantite2"/> </td>
            <td><input type="text" name="prix[]" class="element" id="prix2"/> </td>
            <td><input type="text" name="montant[]" id="montant2"/> </td>
        </tr>
        <tr>
            <td><input type="text" name="designation[]" id="designation3"/> </td>
            <td><input type="text" name="quantite[]" class="element" id="quantite3"/> </td>
            <td><input type="text" name="prix[]" class="element" id="prix3"/> </td>
            <td><input type="text" name="montant[]" id="montant3"/> </td>
        </tr>  
        <tr>
            <td>MontantHT</td>
            <td></td>
            <td></td>
            <td><input type="text" name="MontantHT" id="montantHT"/></td>
        </tr> 
        <tr>
            <td>TVA</td>
            <td></td>
            <td></td>
            <td><input type="text" name="tva" id="tva"/></td>
        </tr>
        <tr>
            <td>TotalTTC</td>
            <td></td>
            <td></td>
            <td><input type="text" name="totalTTC" id="totalTTC"/></td>
        </tr>  
    </table>      
</div>
<div>
<input type="submit" name="submit" id="submit" value="envoyer"/>
</div>
</form>
<script>
    function produit(){
        var id=this.getAttribute("id");
        var numero=id.substring(id.length-1, id.length);
        var quantite1=document.getElementById("quantite"+numero).value;
        var prix1=document.getElementById("prix"+numero).value;
        var montant1=document.getElementById("montant"+numero);
        var somme=parseInt(quantite1) * parseInt(prix1);
        if (!isNaN(somme)) montant1.value=somme;
        var montantTotal=0;
        montants=document.getElementByClassName("montant");
        for (var i=0;i<montants.length;i++){
            if (!isNaN(parseInt(montants[i].value)))    montantTotal=montantTotal+parseInt(montants[i].value);
        }
        var montantHT=document.getElementById("montantHT");
        montantHT.value=montantTotal;
        var tva=document.getElementById("TVA");
        tva.value=montantTotal*10/100;
        var montantTTC=document.getElementById("TotalTTC");
        montantTTC.value=montantTotal+tva;
    }

    var elements=document.getElementsByClassName("element");
    for (var i=0;i<elements.length;i++){
        elements[i].addEventListener("change", produit, false);
        elements[i].addEventListener("change", produit, false);
    }
</script>