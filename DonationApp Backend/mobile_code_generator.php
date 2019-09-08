<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <div class="text-center" style="margin-top:1rem">
            <p>Authorization Code:</P>
            <?php
            require_once "./sq_config.php";

            function getAuthzCode($authorizationResponse) {

                // Extract the returned authorization code from the URL
                $authorizationCode = $authorizationResponse['code'];
            
                # If there is no authorization code, log the error and throw an exception
                if (!$authorizationCode) {
                error_log('Authorization failed!');
                throw new \Exception("Error Processing Request: Authorization failed!", 1);
                }
            
                return $authorizationCode;
            }

            function getOAuthToken($authorizationCode) {

                // Create an OAuth API client
                $oauthApi = new SquareConnect\Api\OAuthApi();
                $body = new \SquareConnect\Model\ObtainTokenRequest();
            

                $applicationId = _SQ_APP_ID;
                $applicationSecret = _SQ_APP_SECRET;
                // Set the POST body
                $body->setClientId($applicationId);
                $body->setClientSecret($applicationSecret);
                $body->setGrantType("authorization_code");  
                $body->setCode($authorizationCode);
            
                try {
                    $result = $oauthApi->obtainToken($body);
                } catch (Exception $e) {
                    error_log  ($e->getMessage());
                    throw new Exception("Error Processing Request: Token exchange failed!", 1);
                }
            
                $accessToken = $result->getAccessToken();
                $refreshToken = $result->getRefreshToken();
                
                // Return both the access token and refresh token
                return array($accessToken, $refreshToken);
            }

            # Call the function
            try {
                $authorizationCode = getAuthzCode($_GET);
                list($accessToken, $refreshToken) = getOAuthToken($authorizationCode);
                
            } catch (Exception $e) {
                echo $e->getMessage();
                error_log($e->getMessage());
            }

            // Create and configure a new API client object
            $defaultApiConfig = new \SquareConnect\Configuration();
            $defaultApiConfig->setAccessToken($accessToken);

            $defaultApiClient = new \SquareConnect\ApiClient($defaultApiConfig);

            // Create a MobileAuthorizationApi client to request an authorization code
            $mobileAuthzClient = new \SquareConnect\Api\MobileAuthorizationApi($defaultApiClient);
            $body = new \SquareConnect\Model\CreateMobileAuthorizationCodeRequest();
            $body->setLocationId(getLocationId());
            $apiResponse = $mobileAuthzClient->CreateMobileAuthorizationCode($body);
            $mobileCode = $apiResponse->getAuthorizationCode();

            echo '<input id="authorization_code" type="text" value="' . $mobileCode . '" readonly>';
            ?>
            <button id="copy_code_button" class="btn btn-primary">Copy Code</button>
        </div>
    </body>
    <script>
        var textField = document.querySelector("#authorization_code");
        var copyButton = document.querySelector("#copy_code_button");
        copyButton.addEventListener("click", () => {
            textField.select();
            document.execCommand("copy");
            copyButton.classList.toggle("btn-primary");
            copyButton.classList.toggle("btn-success");
        });
    </script>
</html>