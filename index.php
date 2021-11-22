<?php

$valid = false;
$error = "";

if (isset($_POST["submit"])) {

    $name = $_POST["search"];

    if (empty($name)) {

        $error = " Please Enter A Search Term";
    } else {

        $nameString = str_replace(" ", "%20", $name);

        if (substr($nameString, -3) == "%20") {

            $name = chop($nameString, substr($nameString, -3));
        } else {
            $name = $nameString;
        }

        $url = file_get_contents("http://www.omdbapi.com/?s=$name&apikey=51110af3&y=&plot=short&r=json", true);

        $json = json_decode($url);

        $jsonError = json_decode($url, true);

        if ($jsonError['Response'] == "False") {

            if ($jsonError['Error'] == "Movie not found!") {

                $error = "Searched Movie Not Found!";
            } else {
                $error = "Please Enter A valid Search Term";
            }
        } else {
            sort($json->Search);
            $valid = true;
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset "UTF-8" />
    <title>Movie Search</title>
    <?php include_once("styles.php"); ?>
</head>

<body>
    <div class="container" style="mask-image: url('poster.jpg');">
        <div class="jumbotron">
        <a href="BookIndex1.php"><h2 style="float:right">Book Search<i class="fa fa-search" aria-hidden="true">&nbsp;</i></h2></a>
            <h1>Movie Search<i class="fa fa-search" aria-hidden="true">&nbsp;</i></h1>
            <form name="movieSearch" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <label id="errorMessage" class="errMsg">
                    <?php echo "$error"; ?>
                </label>
                <input id="search" type="text" name="search" placeholder="Search..." />
                <input id="submitButton" type="submit" name="submit" value="submit">
            </form>
        </div>
    </div>

    <?php if ($valid == true) : ?>
        <div class="container">
            <div class="tbl-header">
                <table>
                    <thead>
                        <tr>
                            <th>IMDB ID</th>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Year Released</th>
                            <th>Poster</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="tbl-content">
                <table>
                    <tbody>

                        <?php foreach ($json->Search as $movie) : ?>
                            <tr>
                                <td class="imdbID">
                                    <?php
                                    echo "<a href=\"getMovie.php?id=$movie->imdbID\">$movie->imdbID</a>";
                                    ?></td>
                                <td>
                                    <?php
                                    echo $movie->Title;
                                    ?>
                                </td>
                                <td>
                                    <?php

                                    echo $movie->Type;
                                    ?>
                                </td>
                                <td>
                                    <?php

                                    echo $movie->Year;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    echo "<img src=\"$movie->Poster\"";
                                    ?>
                                </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</body>

</html>