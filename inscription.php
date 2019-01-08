
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="../../../../favicon.ico">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

  <title>Merci pour votre inscription</title>

  <!-- Bootstrap core CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <!-- Custom styles for this template -->
  <!-- class="bg-light"  -->
</head>

<body >
  <style type="text/css">
  .marquee {
    width: 100%;
    line-height: 50px;
    /*background-color: red;*/
    /*color: white;*/
    white-space: nowrap;
    overflow: hidden;

    box-sizing: border-box;
    transition: stroke-dashoffset 0.1s;
    animation: marquee 15s linear infinite;
    animation-play-state: running, running;
  }

  @keyframes marquee {
    0%   { transform: translate(100%, 0); }
    100% { transform: translate(-100%, 0); }
  }

</style>



  <div class="container">

  <div class="jumbotron text-lg-center text-md-center text-sm-center">

    <?php
    

    if (!empty($_POST)) {


      $servername = "localhost";
      $username = "francofun";
      $password = "Defi_1820";
      $dbname = "francofun";


      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "francofun";


    

        
        // Create connection
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $email = trim(addslashes($_POST["email"]));
        $em = $conn->query("SELECT * FROM dictee WHERE d_email='".$email."'");
        if ($em->fetch()) {
          printf("<div class='offset-2 col-8'>\n");
          ?>
          <h1 class="display-3">Désole!</h1>
          <p class="lead"><strong>Cet email a déja été utiliseé. Veuillez utiliser un autre email disponible.</p>
          <p>Au plaisir de vous voir nombreux :-)</p>
          <hr>
          <p>
            Des questions? <a href="mailto:koitaissiaka@gmail.com">Contactez-nous</a>
          </p>
          <p class="lead">
            
            <a class="btn btn-primary btn-sm" href="./colorlib-regform-12/index.html" role="button">Retour à la page d'acceuil</a>
          </p>
          <?php
          printf("</div>\n");

        }
        else
        {

          // prepare and bind
          $stmt = $conn->prepare("INSERT INTO dictee (d_nom, d_prenom, d_email, d_tel, d_camp, d_lang, d_job, d_age) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

          // set parameters and execute
          $d_nom = trim(addslashes(htmlentities($_POST["name"])));
          $d_prenom = trim(addslashes(htmlentities($_POST["prenom"])));
          $d_email = trim(addslashes($_POST["email"]));
          $d_tel = trim(addslashes($_POST["phone_number"]));
          $d_camp = trim(addslashes($_POST["campus"]));
          $d_lang = trim(addslashes($_POST["langue"]));
          $d_job = trim(addslashes($_POST["job"]));
          $d_age = trim(addslashes($_POST["age"]));


          $res = $stmt->execute([$d_nom, $d_prenom, $d_email, $d_tel, $d_camp, $d_lang, $d_job, $d_age ]);



          printf("<div class='offset-2 col-8'>\n");
          if($res)
          {
            ?>
            <h1 class="display-3">Merci!</h1>
            <p class="lead"><strong>Votre inscription a été effectu&eacute;e avec succ&egrave;s&nbsp;!<br></strong> Vous allez bient&ocirc;t recevoir un courriel confirmant votre inscription.</p>
            <p>Au plaisir de vous voir nombreux  :-)</p>
            <hr>
            <p>
              Des questions? <a href="mailto:koitaissiaka@gmail.com">Contactez-nous</a>
            </p>
            <p class="lead">
              <a class="btn btn-primary btn-sm" href="./colorlib-regform-12/index.html" role="button">Retour à la page d'acceuil</a>
            </p>
            <?php


            require_once ('lib/SendGrid.php');

            $urli = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
            $cible = "inscription.php";
            $pos = stripos($urli, $cible );
            $home_url=  substr($urli , 0,$pos);

            $url = 'https://api.sendgrid.com/';
            $user = 'udemcoop';
            $pass = 'Coop_2017';

            $corps = "Bonjour " . $d_nom . ",<br/><br/>";
            $corps .= "Ceci confirme votre inscription a la grande dictée de l'acadie.<br/><br/>";
            $corps .= "Au plaisir de vous voir bientot;!<br/><br/>";
            $corps .= "Sinc&egrave;rement,<br/><br/>";
            $corps .= "l'&eacute;quipe d'<a href='http://$home_url'>GRANDE DICTEE DE L ACADIE 2019</a>.";
            $corps = "<p>" . $corps . "</p>";

            $from = "koitaissiaka@gmail.com";

            $params = array(
              'api_user' => $user,
              'api_key' => $pass,
              'to' => $email,
              'subject' => 'GRANDE DICTEE DE L ACADIE 2019',
              'html' => $corps,

              'from' => $from
            );

            $request = $url.'api/mail.send.json';

            $session = curl_init($request);
            // Tell curl to use HTTP POST
            curl_setopt ($session, CURLOPT_POST, true);
            // Tell curl that this is the body of the POST
            curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
            // Tell curl not to return headers, but do return the response
            curl_setopt($session, CURLOPT_HEADER, false);
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
            // obtain response
            $response = curl_exec($session);
            curl_close($session);



          }
        }
      }
       

        catch(PDOException $e)
        {
          printf($e);
          printf("&nbsp;<br/>\n");
          printf("<h3>D&eacute;sol&eacute; il y a eu un probl&egrave;me :-(</h3><br/>\n");
          printf("&nbsp;<br/>\n");
          printf("<h3>Veuillez r&eacute;essayer svp&nbsp;:<br/></h3>\n");
          printf("&nbsp;<br/>\n");
          printf("<h3><a href='./index.html'>Inscription</a></h3>\n");

        }
        finally{
          printf("</div>\n");
          // $stmt->close();
          //$conn->close();
        }
      }



        ?>
      </div></div>
      <footer class="my-3 text-muted text-center text-small">

        <p class="mb-1">&copy; 2018 GRANDE DICTEE DE L'ACADIE </p>
      </footer>
    </body>
    </html>
