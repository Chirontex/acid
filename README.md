# ACID — After Cron is Dead

ACID is a web application designed to perform periodic access to the site without using Сron.

How to use:
1. Copy the application files to your server.
2. Open **config.php** and change the value of the *$password*.
3. Go to the main page of the application and specify URL, time interval and query headers for your task. You can also declare a success phrase - a phrase that should be contained in the content of the response from the site in case of a successful request. Otherwise, the status will display the full content of the response page along with headers.
