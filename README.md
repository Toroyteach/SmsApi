# SmsApi
simple api sms

This is a relative simple API implementation of sending a sinle sms using Clickatell client. Makes use of mysql database

How to use 
clone the repo to your server
Copy the sql script to your database server to create the database and tables

on the /inc/config.php change the USE_DB to 1 if you want to use the database
Note for good recording its advised to use database. It is currently set to 0 by default


Make a post request to the url ./Interview/index.php with the number and the message you would like to send
the callback url will be listed from ./Interview/callback.php. I could not test it via localhost or locally because it doesnt work 
but if it was deployed on a real server then it would work.

Some numbers wont recieve the text since they have not been added in the Clickatell dashboard.
I ran out of time but i had wanted to finish off with testing since i had started. but i faced some bit of challanges since the time i got the task. 
