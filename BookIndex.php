<?php

$valid = false;
$error = "";	

if(isset($_POST["submit"])){
    
    $name = $_POST["search"];
    
    if(empty($name))
    {
        
        $error = " Please Enter A Search Term";
    }
    else{
        
        $nameString = str_replace(" ", "%20", $name);
        
        if(substr($nameString,-3) == "%20"){
          
          $name = chop($nameString, substr($nameString,-3)); 
         
        }
        else
        {
           $name = $nameString; 
        }
        
        $url = file_get_contents("https://openlibrary.org/search.json?title=$name", true);
        
        $json = json_decode($url);
        
        $jsonError = json_decode($url,true);
        //echo "<pre>";
        //print_r($json);
        //echo "</pre>";
     
        
        if($jsonError['Response'] == "False"){
            
            if($jsonError['Error'] == "book not found!")
            {
                
                $error = "Searched book Not Found!";
            }
            else
            {
                $error = "Please Enter A valid Search Term";
            }
        }
        else
        {
            sort($json->docs);
            $valid = true;
        }

    }
}
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset "UTF-8"/>
        <title>Book Search</title>
        <?php include_once("styles.php");?>
    </head>

    <body>
        <div class="container">
            <div class="jumbotron">
                <a href="index.php"><h2 style="float:right">Movie Search<i class="fa fa-search" aria-hidden="true">&nbsp;</i></h2></a>
                <h1>Book Search<i class="fa fa-search" aria-hidden="true">&nbsp;</i></h1>
                <form name="bookSearch" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
                    <label id="errorMessage" class="errMsg">
                        <?php echo "$error";?>
                    </label>
                    <input id="search" type="text" name="search" placeholder="Search..."  />
                    <input id="submitButton" type="submit" name="submit" value="submit">
                </form>
            </div>
        </div>

        <?php if($valid == true): ?>
            <div class="container">
                <div class="tbl-header">
                    <table>
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>ISBN</th>
                                <th>Title</th>
                                <th>Author_name</th>
                                <th>Publish_year</th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <div class="tbl-content">
                    <table>
                        <tbody>

                            <?php foreach ($json->docs as $book): ?>
                                <tr>
                                    <td class="imdbID">
                                        <?php
                                            echo $book->key; 
                                        ?></td>
                                    <td>
                                        <?php 
                                              $arr = $book->isbn[0];
                                              //$book1 = json_encode($arr);
                                              echo "<a href=\"getBook.php?id=$arr\">$arr</a>";
                                            //echo $book->isbn[0]; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        
                                            echo $book->title; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                       
                                            echo $book->author_name[0]; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            echo $book->publish_year[0]; 
                                        ?>
                                    </td>
                                </tr>

                                <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif;?>
    </body>

    </html>