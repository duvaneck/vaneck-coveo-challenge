<?php
/**
*=================================================================
* Create by : Vaneck Duclair
* Date : 2018-10-19
* modify : 2018-10-21
*=================================================================
* Using the file s3.php this php leaf allows
* retrieve information and connect to an Aws s3 instance to perform different actions:
* create a bucket and add a file, as well as retrieve different information.
*=================================================================
*/

/* appel de la class s3 déclaré dans le fichier aws3*/
if (!class_exists('S3')) require_once 'aws3.php';

/*masquer les warning de php*/
ini_set('display_errors', 0 );

/*Parrametter le fuseau horaire à montreal*/
date_default_timezone_set('America/Montreal');
/* formt monetaire local US*/
setlocale(LC_MONETARY,"en_US");

// information d'acces au compte aws
if (!defined('awsAccessKey')) define('awsAccessKey', 'change-this');
if (!defined('awsSecretKey')) define('awsSecretKey', 'change-this');

// Instancier la classe
$s3 = new S3(awsAccessKey, awsSecretKey);

// validation si il exite un fichier pour l'upload
if(isset($_FILES['file'])){

$file = $_FILES['file'];
	// File details
	$name = $file['name'];
	$tmp_name = $file['tmp_name'];

$extension  = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

	//temp detail
	$key = md5(uniqid());
	$tmp_file_name = $key.".".$extension;


/**/
$uploadFile = $_FILES['file']['tmp_name']; // attribusion du fichier temporaire < la variable
$bucketName = uniqid($_POST['bucketName']); //creation d'un bucket temporaire pour stoqué notre file temp


// verification de l'existance du fichier
if (!file_exists($uploadFile) || !is_file($uploadFile))
	exit("\nERROR: No such file: $uploadFile\n\n");

// Créer un bucket avec un accès en lecture publique
if ($s3->putBucket($bucketName, S3::ACL_PUBLIC_READ)) {
	echo "Created bucket {$bucketName}".PHP_EOL;

	// Inserer le fichier (également avec un accès public en lecture)
	if ($s3->putObjectFile($uploadFile, $bucketName, baseName($uploadFile), S3::ACL_PUBLIC_READ)) {
		echo "S3::putObjectFile(): File copied to {$bucketName}/".baseName($uploadFile).PHP_EOL;


		// Obtenir le contenu de notre bucket à partirde son nom
		$contents = $s3->getBucket($bucketName);


		// Obtenir des informations sur l'objet upload
		$info = $s3->getObjectInfo($bucketName, baseName($uploadFile));

	} else {
		echo "S3::putObjectFile(): Failed to copy file\n";
	}
} else {
	echo "S3::putBucket(): Unable to create bucket (it may already exist and/or be owned by someone else)\n";
}
}


// Vérifiez si CURL est installer si non installé, installez-le et réessayez.
if (!extension_loaded('curl') && !@dl(PHP_SHLIB_SUFFIX == 'so' ? 'curl.so' : 'php_curl.dll'))
	exit("\nERROR: CURL extension not loaded\n\n");

// Validation si la clé aws a été renségnée
if (awsAccessKey == 'change-this' || awsSecretKey == 'change-this')
	exit("\n<br/>ERREUR: informations d'accès AWS requises\n\nVeuillez modifier les lignes suivantes dans le fichier details.php:\n\n".
	"define('awsAccessKey', 'change-me');\ndefine('awsSecretKey', 'change-me');\n\n");

//Titre pour la section concernant la liste des buckets
echo '
			<div class="container">
				<fieldset>
					<h5><b>	Informations S3:</b></h5>

				</fieldset>
			</div>
';

// récupération de la liste des buckets
$test = $s3->listBuckets();

?>

<!DOCTYPE html>
<html>
<head>
<title>Coveo challenge</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
  <script>
  $(document).ready(function() {
    $('#example').DataTable();
} );
  </script>
</head>
	<body class="container">

		<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
					<th>#</th>
					<th>Nom</th>
					<th>D. création</th>
					<th>Nb de fichiers</th>
					<th>Taille bucket</th>
					<th>Lieu</th>
					<th>D. mise-à-jour</th>
					<th>T. Stockage</th>
					<th>cout</th>
            </tr>
        </thead>
        <tbody>
		<?php
					$i = 0;
					$t = 0;
					foreach($test['buckets'] as $donnee)
				   {
					   $nom = $test['buckets'][$i]['name'];
					   $taille = $s3->getBucket($nom);
					   $nbfiles = sizeof($taille);
					   $dateModification = $s3->getBucketSize($nom);
					   $location = $s3->getBucketLocation($nom);
					   $dateNum =$test['buckets'][$i]['time'];
					   $size = 0;
		?>
            <tr>
                <td><?php echo $t+1; ?></td>
                <td><?php echo $nom; ?></td>
                <td><?php echo date('d/m/Y', $dateNum);?></td>
                <td><?php echo $nbfiles; ?></td>
                <td class="unité">
								<?php
								/* pour determiner la taille il faut lister le contenu de chaque bucket et les additionner */
									for($y=0;$y<=($nbfiles-1);$y++)
									{
										$size +=  $taille[$y]['size'];
									}
									/*conversion des unités pour un affichage plus propre et adéquat*/
										if ($size/1000 < 1) {
												echo $size.' byte';
										}elseif ($size/1000 > 1 && $size/1000 <= 999) {
											$kb = $size/1000;
											echo $kb.' Kb';
										}elseif ($size/1000000 > 1 && $size/1000000 <= 999999) {
											$mb = $size/1000000;
											echo $mb.' Mb';
										}elseif ($size/1000000000 > 1 && $size/1000000000 <= 999999999) {
											$gb = $size/1000000000;
											echo $gb.' Gb';
										}elseif ($size/1000000000000 > 1 && $size/1000000000000 <= 999999999999) {
											$gb = $size/1000000000000;
											echo $gb.' Tb';
										}

								?>
							</td>
				<td><?php echo $location; ?></td>
                <td><?php
							$dateModif = $taille[$nbfiles-1]['time'];
							if(isset($dateModif))
							{
								echo date('d/m/Y', $dateModif);
							}else{
								echo date('d/m/Y', $dateNum);
							}

					?>
				</td>
                <td>
				<?php
					// afficher le type de stockage de chaque éléments contenudans chaque bucket (sans doublon)
					for($y=0;$y<=($nbfiles-1);$y++)
					{
						if($y == 0)
						{
							$intermediaire = $taille[$y]['Storage'];
							echo $taille[$y]['Storage'].'<br/>';
						}elseif($y > 0){
								if($taille[$y]['Storage'] != $intermediaire)
								{
									echo $taille[$y]['Storage'];
								}
						}
					}

				?>
				</td>
                <td class="currency">
									<?php
										// faire le calcul des cous sur la base de la facturation de amazon
										$cout = 0;
										for($y=0;$y<=($nbfiles-1);$y++)
										{
											if($intermediaire = $taille[$y]['Storage'] == 'STANDARD')
											{
												$cout += ($size/1000000)*0.0390;

											}if($intermediaire = $taille[$y]['Storage'] == 'STANDARD_IA')
											{
												$cout += ($size/1000000)*0.0200;

											}else {
												$cout += ($size/1000000)*0.006 ;
											}
										}
										echo "$ ".$cout;
									?>

								</td>
            </tr>
        <?php
			$nbfiles = 0;
			$t++;
			$i++;
		   }
		?>

        </tbody>
        <tfoot>
            <tr>
					<th>#</th>
					<th>Nom</th>
					<th>D. création</th>
					<th>Nb de fichiers</th>
					<th>Taille bucket</th>
					<th>Lieu</th>
					<th>D. mise-à-jour</th>
					<th>T. Stockage</th>
					<th>cout</th>
            </tr>
        </tfoot>
    </table>
	</body>
</html>
