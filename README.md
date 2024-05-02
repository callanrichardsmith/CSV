# CSV
I was asked to create this for an interview. Use at your own discretion as I am a beginner programmer.

This is a simple program that uploads a CSV file of any length to a SQLite3 database.

1. For this script to work, you will need to install PHP 8.3, SQLite, Laravel Herd and DBeaver.
2. Make sure you create your project folder with the index.php file in it, and put your project folder in the Laravel Herd folder on your main drive.
3. Create a folder named 'output' in your project folder. When the script runs, the csv file will appear in the output folder that you have created.
4. You can run the script by typing [yourprojectfoldername].test in the web browser if your project folder is in the Laravel Herd folder.
5. Once the 1000000 record csv file has been created, you can view it through DBeaver. In DBeaver, click on 'File', then click on 'New'. In the drop down box select 'Database Connection'. Search for SQLite and click 'Next'. In the next screen click 'Open' and navigate to your project folder where you will now see a 'test.db' file. Open the test.db file. This should open the CSV file to view in DBeaver. 
