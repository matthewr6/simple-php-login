# simple-php-login
A simple PHP login engine with four scripts - one for registering, one for logging in, one for checking the login, and one for logging out.

# How to Use
Preferably, the three scripts should all be in the same file, with the connection PHP script (if a separate file) in that same folder.  `register.php`, `login.php` and `logout.php` are form actions, while `login_status.php` is an included file in your PHP page.
The `login_status.php` file creates a variable called `$is_logged_in`, which simply signifies whether the user is logged in or not.  The user's username is stored in `$_SESSION['username']`.
