# 3004ICT-WAD-Project

A Web Application Development Project

This application has been designed to be used internally by a Tree Farm.

The Delivery Distance calculation is done using the free OpenRouteService APIs.

You can create a free account here: https://account.heigit.org/signup

Once you have created your account, please add this to your .env file:

# API Key for OpenRouteService
ORS_API_KEY=<your API key>

As this application has also been built to enforce the specified application URL, please update this line in your .env file:

APP_URL=https://<your directory structure>/TreeFarm/public

This ensures that the application works successfully, even if the application is not located immediately under your html folder.
