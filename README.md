# events_site
Events registering site w/ user register and login functionality, and accompanied SQL database

This was a graded year 2 university project. The site allows users to sign up and register for events. Staff users can add/update events, admins can view registrations of all users.

# Installation
Use XAMPP with phpmyadmin - edit the database_conn.php file to include your own details. Import the database with the tgne.sql file. Go to home.php, and log in at the top using these provided logins for each user type:

test_user, password
test_staff, password
administrator, password

As a user, you can view events and register/unregister for them, as well as leave feedback and reports.

As a staff member, you can add and edit events on the staff.php page. The buttons take you to pages where you can delete the event, update the event's details or add media to the event.

As an admin, you can access all the registrations for each event in the database as well as reports in the admin.php page.
