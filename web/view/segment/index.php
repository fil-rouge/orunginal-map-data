<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Display segments</title>
    </head>

    <body>
        <h1>Parsed segments from DB</h1>
 
        <?php
        echo 'Number of segments = '.count($segments).'<br/>';
        
        foreach($segments as $segment)
        {
        ?>
        <div>
            <p>
                <?php  
                    $segment->display();
                ?>
            </p>
        </div>
        <?php
        }
        ?>
    </body>
</html>