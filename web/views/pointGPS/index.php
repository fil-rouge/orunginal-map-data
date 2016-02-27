<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Les points GPS de la base de donnees</title>
    </head>

    <body>
        <h1>Les points GPS d'OSM !</h1>
        <p>Derniers points d'OSM :</p>
 
        <?php
        foreach($points as $point)
        {
        ?>
        <div>
            <p>
                <?php echo 'ID: ' . $point['id'] . ' | Lat: ' . $point['lat'] . ' | Lon: ' . $point['lon'] . '<br/>'; ?>
                <br />
            </p>
        </div>
        <?php
        }
        ?>
    </body>
</html>