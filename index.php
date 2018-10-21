<!DOCTYPE html>
<html lang="en">
<head>
  <title>Coveo challenge</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
  <script>

  $(document).ready(function() {

	$("#bucketDetail").load('details.php');
    $('#example').DataTable();
    setTimeout(function(){ $("#loader").hide() }, 9220);
} );

var refreshId = setInterval(function()
{
     $('#bucketDetail').fadeOut("slow").load("details.php").fadeIn("slow");
}, 100000);

$(function () {
	    $('#NewBucket').on('submit', function (e) {
	        // On empêche le navigateur de soumettre le formulaire
	        e.preventDefault();

    		var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();
		    var bucketName = $('#bucketName').val();
		        $.ajax({
					 url: $form.attr('action'),
					 type: $form.attr('method'),
					 contentType: false, // obligatoire pour de l'upload
					 processData: false, // obligatoire pour de l'upload
					 data: data,
					 success: function(html) { // Je récupère la réponse du fichier PHP
             $("#NewBucket")[0].reset();
					// alert(bucketName);
				 	}
	        });
	    });
	});
  function numberWithCommas(number) {
      var parts = number.toString().split(".");
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
      return parts.join(".");
  }
  $(document).ready(function() {

      var num =  $(".currency").text();
      var commaNum = numberWithCommas(num);
       $(".currency").text(commaNum);
  });
</script>
<style>

</style>
</head>
<body>

<div class="container">
  <h2>Coveo challenge</h2>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info mb-2" data-toggle="modal" data-target="#instructions">Instructions</button>

  <!-- Modal -->
  <div class="modal fade" id="instructions" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Instructions</h4>
        </div>
        <div class="modal-body">
        <p>dans le cadre du covéo challenge, il était question de récupérer de l'information d'un compte aws s3. une sorte de <b>monitoring</b> et de <b>statistique</b> en même temps. ce fut très intéréssant car cela m'a fait apprendre de nouvelles notions.<br/>

          Le tableau ci-dessous représente differents données récupéré à partir d'un compte amazone s3. comme vous pouvez le remarquer il n'y a pas les couts :-). En effet ma principal difficulté est de trouver combien tout cela nous coute.
          Je me demande si mon approche est correct c'est à dire comprendre comment tout ceci est facturé et ensuite faire le calcul manuellement en php/javascript, ajax... Si quelqu'un a la réponse cette intérogation bien vouloir me contacter je suis vraiment intéréssé.
          <p>
            Vu que amazone me facture par requette bien vouloir changer les creds avant de tester l'upload ou allez doucement car mon compte bancaire souffre lol

          <br/>Lets enjoy ;-).
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

</div>
<div class="container">
  <fieldset>
  <h5><b>Upload un fichier dans un nouveau bucket:</b></h5>
    <form class="form-inline" id="NewBucket" action="details.php" method="post" enctype="multipart/form-data" autocomplete="off">
      <label for="bucketName" class="mb-2 mr-sm-2">Compartiment:</label>
      <input type="text" class="form-control mb-2 mr-sm-2" id="bucketName" name="bucketName" placeholder="Bucket" required>
      <label for="file" class="mb-2 mr-sm-2">Fichier:</label>
      <input type="file" name="file" class="form-control mb-2 mr-sm-2" id="file" required>

      <button type="submit" class="btn btn-primary mb-2">Submit</button><br/>

    </form>
  </fieldset>
</div>

<div class="container">
  <div id="loader">
    <div class="loader">
      <div class="loader-inner">
        <div class="loader-line-wrap">
          <div class="loader-line"></div>
        </div>
        <div class="loader-line-wrap">
          <div class="loader-line"></div>
        </div>
        <div class="loader-line-wrap">
          <div class="loader-line"></div>
        </div>
        <div class="loader-line-wrap">
          <div class="loader-line"></div>
        </div>
        <div class="loader-line-wrap">
          <div class="loader-line"></div>
        </div>
      </div>
      </div>
  </div>
  <div id="bucketDetail">
  </div>
</div>
</body>
</html>
