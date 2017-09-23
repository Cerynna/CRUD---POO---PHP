<?php
include("conect.php");
include("bdd_class.php");

$jeremy = new articles(SERVEUR, USER, PASS, BDD);

//$results = $jeremy->listingtArticle();
//$jeremy->insertArticle('Article 2','LOLOLOL','Moi');


if (isset($_GET['verif'])) {
    if (!empty($_POST)) {

        $newMessage = $_POST['message'];
        $newAuteur = $_POST['auteur'];
        $newTitre = $_POST['titre'];

        // VERIF USER NAME //
        if (empty($newTitre)) {
            $erreur .= "Il faut mettre un titre boulard <br />";
        }

        // VERIF USER MAIL //
        if (empty($newAuteur)) {
            $erreur .= "Et l'auteur c'est pour les chien ? <br />";
        }

        // VERIF USER THEMATIQUE //
        if (empty($newMessage)) {
            $erreur .= "Ah bah oui un article sans message ! <br />";
        }

        if (!empty($erreur)) {

            print_r($erreur);


        } else {
            $messageClient = $jeremy->insertArticle("$newTitre", "$newMessage", "$newAuteur");

            header("refresh:1;url=./");
        }
    }

} elseif (isset($_GET['modif'])) {

    $idArticleModif = $_GET['modif'];
    $auteurArticleModif = $_POST['auteur'];
    $contenueArticleModif = $_POST['message'];
    $titreArticleModif = $_POST['titre'];

    $messageClient = $jeremy->updatetArticle($idArticleModif, $titreArticleModif, $contenueArticleModif, $auteurArticleModif);

    header("refresh:1;url=./");


} elseif (isset($_GET['validDelete'])) {

    $idArticleModif = $_GET['validDelete'];

    $messageClient = $jeremy->deletetArticle($idArticleModif);

    header("refresh:1;url=./");


}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Page Description">
    <meta name="author" content="hysterias">
    <title>Page Title</title>

    <!-- Bootstrap -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>


    <![endif]-->
    <style>
        .tdTittle {
            padding-left: 10px;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="page-header">
    <h1>My blog of the Night <small>by Hystérias</small></h1>
</div>
<div class="container">
    <div class="row">

        <div class="col-md-6">
            <?php if (isset($_GET['upload'])): ?>

                <?php
                $idArticle = $_GET['upload'];
                $artcleUpload = $jeremy->oneArticle($idArticle);

                ?>
                <legend>Modifier un article</legend>
                <form action="?modif=<?php echo $artcleUpload['id']; ?>" method="post" role="form">
                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" class="form-control" name="titre" id="titre" placeholder="Titre..."
                               value="<?php echo $artcleUpload['titre']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="auteur">Auteur</label>
                        <input type="text" class="form-control" name="auteur" id="auteur" placeholder="Auteur..."
                               value="<?php echo $artcleUpload['auteur']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label><br/>
                        <textarea name="message" id="message" cols="50"
                                  rows="10"><?php echo $artcleUpload['contenue']; ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-info"><i class="glyphicon glyphicon-send"></i> Submit</button>
                </form>
            <?php elseif (isset($_GET['delete'])): ?>

                <?php
                $idArticle = $_GET['delete'];
                $artcleDelete = $jeremy->oneArticle($idArticle);
                ?>
                <legend>Suppréssion d'article</legend>

                <h1><?php echo $artcleDelete['titre']; ?>
                    <small>ecrit par <?php echo $artcleDelete['auteur']; ?></small>
                </h1>
                <p>
                    <?php echo $artcleDelete['contenue']; ?>
                </p>
                <a href="?validDelete=<?php echo $idArticle; ?>" class="btn btn-success"><i
                            class="glyphicon glyphicon-ok"></i></a><a href="./" class="btn btn-danger"><i
                            class="glyphicon glyphicon-remove-sign"></i></a>

            <?php elseif (isset($_GET['modif'])): ?>

                <?php if (!empty($messageClient)) : ?>
                    <legend>Modifier un article</legend>
                    <div class="alert alert-info" role="alert">
                        <?php echo $messageClient; ?>
                    </div>
                <?php endif; ?>

            <?php elseif (isset($_GET['validDelete'])): ?>

                <?php if (!empty($messageClient)) : ?>
                    <legend>Suppréssion d'article</legend>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $messageClient; ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <form action="?verif" method="post" role="form">
                    <legend>Crée un article</legend>

                    <div class="form-group">
                        <label for="titre">Titre</label>
                        <input type="text" class="form-control" name="titre" id="titre" placeholder="Titre...">
                    </div>
                    <div class="form-group">
                        <label for="auteur">Auteur</label>
                        <input type="text" class="form-control" name="auteur" id="auteur" placeholder="Auteur...">
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label><br/>
                        <textarea name="message" id="message" cols="50" rows="10"></textarea>
                    </div>
                    <button type="submit" class="btn btn-info"><i class="glyphicon glyphicon-send"></i> Submit</button>
                </form>
            <?php endif; ?>


        </div>
        <div class="col-md-6">
            <legend>Listing des articles</legend>

            <ul class="list-group">

                <?php
                $results = $jeremy->listingtArticle();
                foreach ($results as $result) :
                    ?>

                    <li class="list-group-item">
                        <table>
                            <tr>
                                <td width="30px"><a href="?upload=<?php echo $result['id'] ?>" class="btn btn-info"><i
                                                class="glyphicon glyphicon-wrench"></i></a></td>
                                <td class="tdTittle"><?php echo $result['titre'] ?></td>
                                <td><a href="?delete=<?php echo $result['id'] ?>" class="btn btn-danger"><i
                                                class="glyphicon glyphicon-trash"></i></a></td>
                            </tr>

                        </table>

                    </li>
                    <?php
                endforeach;


                //print_r($results);
                ?>
            </ul>


        </div>
    </div>

</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>