<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Display segments</title>
    </head>

    <body>
        <h1>Parsed segments from DB</h1>
        <div>
            <p>
                <?php  
                    display_s2p(1000);

                    display_segments(1000);
                ?>
            </p>
        </div>
    </body>
</html>