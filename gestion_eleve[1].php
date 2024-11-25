<?php

//connexion a la base de donnée
$pdo = new mysqli( 'localhost','root','','gestion_eleve');
if ($pdo->connect_errno) { 
  die('Connexion failed: '. $pdo->connect_error);
 }


//ajouter un elève
if($_SERVER ['REQUEST_METHOD']  === 'POST' && isset($_POST['ajouter']) ) {
      $Nom = $pdo->real_escape_string($_POST['nom']) ;
      $Prenom = $pdo->real_escape_string($_POST['prenom']) ;
      $numero = $pdo->real_escape_string($_POST['numero']) ;
      $classe = $pdo->real_escape_string($_POST['classe']) ;
      
      $sql = "INSERT INTO eleve (Nom, Prenom, Numero, Classe) VALUES ('$Nom', '$Prenom', '$numero', '$classe')";

      if($pdo ->query($sql) === TRUE ){
        echo "eleves ajouté avec succée";
      }else{
        echo "erreur" .$pdo->errno. "";

      }
    }
    ////Recherche d'eleve

    $eleve = [];
    if($_SERVER ['REQUEST_METHOD'] == 'GET' && isset($_GET ['Rechercher'])){
      $numero = $pdo->real_escape_string($_GET['numero']);
      $classe = $pdo->real_escape_string($_GET['classe']) ;

      
    $sql = "SELECT * FROM eleve WHERE 1";

    if(!empty($numero)){
      $sql.= " AND Numero = '$numero'";
    }
    if(!empty($classe)){
      $sql.= " AND Classe = '$classe'";
    }
    $Resultat = $pdo->query($sql);
    if($Resultat->num_rows > 0){
      while($row = $Resultat->fetch_assoc()){
        $eleve[] = $row;
      }
      $Resultat->close();

    }else{
      echo "aucun resultat trouvé";
    }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <h1>Ajouter un eleve</h1>
  <form method="POST">

    <label for="Nom">Nom</label>
    <input type="text" id="Nom" name="nom" required><br>

    <label for="Prenom">Prenom</label>
    <input type="text" id="Prenom" name="prenom" required><br>

    <label for="Numero">Numero</label>
    <input type="number" id="Numero" name="numero" required><br>

    <label for="Classe">Classe</label>
    <input type="text" id="Classe" name="classe" required><br>

    <input type="submit" value="ajouter" name="ajouter">
     
    <h1>Rechercher un eleve e</h1>
    <form method="GET">
      <label for="numero">Numero</label>
      <input type="number" id="numero" name="numero"><br>
      <label for="Classe">Classe</label>
      <input type="text" id="Classe" name="classe"><br>
      <input type="submit" value="Rechercher" name="Rechercher">
      
  </form>
</body>
</html>
