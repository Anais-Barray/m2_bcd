
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Simple chat</title>
    <!-- external libs -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- my libs -->
    <link rel="stylesheet" href="css/style.css">
    
  </head>
  <body>
    <div id="main">
      <div class="page-header" id="title">
        <h1>Le super chat <small>Postez vos messages</small><img class="img-circle" src="http://arbre-a-chat-pas-cher.fr/wp-content/uploads/2014/09/Chat-1.jpg"></h1>
      </div>
      
      <form id="msg-form" action="php/add_msg.php" method="POST">
        <div class="form-group">
          <label for="usr">Nom</label>
          <input type="text" class="form-control" id="nom" name="nom">
        </div>
        <div class="form-group">
          <label for="comment">Message</label>
          <textarea class="form-control" rows="5" id="msg" name="msg"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>

      <br/>
      <br/>
      <form action="index.php">
          <button class="btn btn-info pull-right">Refresh</button>
      </form>
      <div id="messages">
<?php
      include 'php/get_latest_msg.php';

      $data = get_messages();
      foreach ($data["msgs"] as $msg) {
         echo '<div class="panel panel-default">';
         echo '<div class="panel-heading">';
         echo '<h3 class="panel-title">' . $msg['nom'] . '</h3>';
         echo '</div>';
         echo '<div class="panel-body">';
         echo $msg['msg'];
         echo '</div></div>';
      }

?>

      
        </div>
      
    </div>
  </body>
</html>
