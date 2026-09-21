# 3004ICT-WAD-Project

A Web Application Development Project

This application has been designed to be used internally by a Tree Farm.

Note about the base URL:

    Due to the environment that this application was built in, this application has been built to enforce the specified base application URL.
    
    Please update this line in your .env file:

        APP_URL=https://<your directory structure>/TreeFarm/public

    This ensures that the application works successfully, even if the application is not located immediately under your html folder.

Note about the use of Third-Party API:

    The Delivery Distance calculation is done using the free OpenRouteService APIs.

    You can create a free account here: https://account.heigit.org/signup

    Once you have created your account, please add this to your .env file:

        # API Key for OpenRouteService
        ORS_API_KEY=<your API key>

    The environment that this application was created in required the use of a Proxy Server in order to make outgoing HTTPS requests.  Please either update those proxy settings in SalesController.php to match your Proxy Server; or remove them if your environment doesn't require a Proxy Server.

