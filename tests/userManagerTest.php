<?php
include_once '../classes/util/UserManager.php';
include_once '../classes/service/UserService.php';

// echo "Create new user with login and password 'user' in db... <br>";
// $userService = new UserService();
// $createResut = $userService->create(new User(null, 'user', 'user', 'user@user.user', false, new DateTime()));
// var_dump($createResut);
// echo "<br><br>";

echo "TEST USER MANAGER CREATE<br>";
$testUserManager = new UserManager();
var_dump($testUserManager);
echo "<br><br>";

echo '
<form method="post" action="userManagerLoginTest.php">
login <input type="text" name="login"> <br>
hasło <input type="text" name="password"> <br>
<input type="submit" name="submit">
</form>
';