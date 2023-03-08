<?php

$title="Ajout d'un type de cours";

include 'partials/header.php';

require 'request/catalogue.dao.php';

require 'services/imageService.php';

$types = getTypes();
?>
<div class="container-md mt-5">
    <div class="h-100 p-5 text-bg-info text-white rounded-3">
        <h1>Création d'un type</h1>
        <p class="h3">Bienvenue sur la page d'ajout de type</p>
        <a class="btn btn-outline-light btn-lg" href="index.php">Retourner à l'accueil</a>
    </div>
    <?php
        // AJOUT
        if( isset($_POST['libelle']))
        {
            try{
                $success = addType($_POST['libelle']);
                if($success){ ?>
                    <div class="container-md">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <p>La création s'est bien déroulée</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                <?php }else{ ?>
                    <div class="container-md">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <p>La création ne s'est pas bien déroulée</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                <?php }
            }catch(Exception $e){
                echo $e->getMessage();
            }

            $types = getTypes();
        }

        // SUPPRESSION
        if(isset($_GET['type']) && $_GET['type'] === 'suppression' && isset($_GET['idType']))
        {
            $typeNameToDelete = getTypeNameToDelete($_GET['idType']);
            ?>
            <div class="container-md">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <p>Voulez vous vraiment supprimer le type <strong><?= $typeNameToDelete ?></strong> ?</p>
                    <p>Attention, si vous supprimer un type, tous les cours associés seront également supprimé.</p>
                    <a href="?deleteType=<?= $_GET['idType'] ?>" class="btn btn-outline-danger">Confirmer</a>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
    <?php }

    if(isset($_GET['deleteType']))
    {
        $success = deleteType($_GET['deleteType']);
        if($success){ ?>
            <div class="container-md">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <p>La suppression du type s'est bien déroulée</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php }else{?>
            <div class="container-md">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <p>Erreur lors de la suppression</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php }
        $types = getTypes();
    }?>

    <div class="mt-5 w-75 mx-auto">
        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="libelle">Nom du type :</label>
                <input class="form-control mt-3" id="libelle" name="libelle" type="text" placeholder="Saisir le nom du nouveau type" />
            </div>
            <input type="submit" value="Enregistrer" class="btn btn-primary btn-lg mt-5" />
        </form>
        
        
            <div class="form-group mt-3">
                <label for="idType">Liste des types:</label>
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php foreach($types as $type): ?>
                            <form method="GET" action="" enctype="multipart/form-data" class="mt-5">
                            <tr>
                                <td><?= $type['idType'] ?></td>
                                <td><?= $type['libelle'] ?></td>
                                <td>
                                    <input type="hidden" name="idType" value="<?= $type['idType'] ?>" />
                                    <input type="hidden" name="type" value="suppression" />
                                    <input type="submit" value="Supprimer" class="btn btn-danger" />
                                </td>
                            </tr>
                            </form>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            
            <!-- <input type="submit" value="Enregistrer" class="btn btn-primary btn-lg mt-5" /> -->
    </div>
</div>
<?php
include 'partials/footer.php';
