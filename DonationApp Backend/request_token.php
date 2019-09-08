<html>
    <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .btn {
            margin-top: 2rem;
        }
    </style>
    </head>
    <body>
        <?php
        require_once "./sq_config.php";

        // Set the permissions
        $permissions = urlencode(
            "PAYMENTS_WRITE " .
            "PAYMENTS_READ " .
            "PAYMENTS_WRITE_IN_PERSON"
        );

        // Display the OAuth link
        echo '<div class="text-center"><a href="https://' .
        _SQ_DOMAIN . _SQ_AUTHZ_URL .
        '?client_id=' . _SQ_APP_ID .
        '&scope=' . $permissions. '" class ="btn btn-primary btn-lg">' . 
        'Authorize this application</a></div>';
        ?>
    </body>
</html>