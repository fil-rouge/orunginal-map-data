<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Display nodes</title>
    </head>

    <body>
        <h1>Parsed nodes from DB</h1>
 
        <?php
        echo 'Number of nodes = '.count($nodes).'<br/>';
        
        foreach($nodes as $node)
        {
        ?>
        <div>
            <p>
                <?php  
                    $node->display();
                ?>
            </p>
        </div>
        <?php
        }
        ?>
    </body>
</html>