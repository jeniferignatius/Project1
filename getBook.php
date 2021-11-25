<?php
$id = $_GET["id"];
$valid = false;

if($id == null)
{

	header('Location: BookIndex.php');
}
else{
    $valid = true;

    $url = file_get_contents("https://openlibrary.org/api/books?bibkeys=ISBN:$id&jscmd=data&format=json", true);
    
    $json = json_decode($url,true);
        //echo "<pre>";
        //print_r($json);
        //echo "</pre>";
    $BookTitle = $json['ISBN:'.$id]['title'];
    $BookUrl = $json['ISBN:'.$id]['url'];
    $BookKey = $json['ISBN:'.$id]['key'];
    $BookCover = $json['ISBN:'.$id]['cover']['small'];
    $BookAuthors = $json['ISBN:'.$id]['authors'][0]['name'];
    $BookISBN_10 = $json['ISBN:'.$id]['identifiers']['isbn_10'][0];
    $BookTitle = $json['ISBN:'.$id]['title'];
}
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title><?php 
            echo $BookTitle;?> | Info
        </title>
        <?php 
        include_once("styles.php");
        ?>
    </head>

    <body>
        <?php 
            if($valid == true):?>
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <img class="heroImg" src="<?php echo $BookCover ?>">
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <h1 class="heroHeader">
                        <?php
                            echo $BookTitle;?>
                        </h1>
                    </div>
                </div>

                <section class="infoContainer">
                    <table>
                        <tr>
                            <th>
                                <p>ISBN</p>
                            </th>
                            <td>
                                <p>
                                    <?php echo $id;?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                               
                                <p>Title</p>
                            </th>
                            <td>
                                <p>
                                    <?php echo $BookTitle;?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <p>Url</p>
                            </th>
                            <td>
                                <p>
                                    <?php echo $BookUrl;?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <p>Authors</p>
                            </th>
                            <td>
                                <p>
                                    <?php echo $BookAuthors;?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <p>Key</p>
                            </th>
                            <td>
                                <p>

                                    <?php echo $BookKey;?>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th class="lastTD">
                                <p>ISBN_10</p>
                            </th>
                            <td class="lastTD">
                                <p>
                                    <?php echo $BookISBN_10;?>
                                </p>
                            </td>
                        </tr>
                    </table>
                    <div class="row">
                        <div class="col-md-12 backButton">
                            <a href="BookIndex.php">Back</a>
                        </div>
                    </div>
                </section>

            </div>

            <?php endif;?>
    </body>

    </html>