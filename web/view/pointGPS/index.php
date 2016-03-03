<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Les points GPS de la base de donnees</title>
    </head>

    <body>
        <h1>Les points GPS d'OSM !</h1>
 
        <?php
        $points = display_points(100);
        
        foreach($points as $point)
        {
        ?>
        <div>
            <p>
                <?php  
                    $point->display();
                ?>
            </p>
        </div>
        <?php
        }
        ?>
    </body>
</html>