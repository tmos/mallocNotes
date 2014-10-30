<?php
require_once 'global/config.php';
require_once 'global/tools.php';
require_once 'models/base.php';
$db = new PDO(SQL_DSN, SQL_USERNAME, SQL_PASSWORD);
Model_Base::set_db($db);
session_set_cookie_params(6000, '/', '', false, true);
session_start();
// date_default_timezone_set('Europe/Paris');
define('BASEURL', dirname($_SERVER['SCRIPT_NAME']));
ob_start();
if (isset($_SERVER['PATH_INFO'])) {
    $args = explode('/', $_SERVER['PATH_INFO']);
    $found = false;
    if (count($args) >= 3) {
        $controller = $args[1];
        $method = $args[2];
        $params = array();
        for ($i = 3;$i < count($args);$i++) {
            $params[] = $args[$i];
        }
        $controller_file = dirname(__FILE__) . '/controllers/' . $controller . '.php';
        if (is_file($controller_file)) {
            require_once $controller_file;
            $controller_name = 'Controller_' . ucfirst($controller);
            if (class_exists($controller_name)) {
                $c = new $controller_name;
                if (method_exists($c, $method)) {
                    $found = true;
                    call_user_func_array(array($c, $method), $params);
                }
            }
        }
    }
    if (!$found) {
        http_response_code(404);
        include ('views/errors/404.php');
    }
} else {
    include 'views/home.php';
}
$content = ob_get_clean();
/**
 * Utilisé pour localiser l'application dans le CSS. J'aurais aimé éviter de dupliquer ce code
 * (issu du traitement de l'url), mais je n'ai pas réussi à jouer avec la portée des variables…
 */
if (isset($_SERVER['PATH_INFO'])) {
    $args = explode('/', $_SERVER['PATH_INFO']);
    $found = false;
    if (count($args) >= 3) {
        $whereami = $args[1] . " " . $args[2];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Malloc(sizeof(notes));</title>
        <link rel="stylesheet" href="<?=BASEURL
?>/assets/css/style.css">
    </head>

    <body>
        <?php
			include 'views/header.php';
			include 'views/menu.php';
		?>
		<div class="WrapMain">
	        <main class="Wrap-main Main">
	            <?php
					if (isset($_SESSION['message'])) {
					    $m = $_SESSION['message'];
					    echo ('<div class="' . $m['type'] . '">');
                            echo($m['text']);
                        echo('</div>');
					    unset($_SESSION['message']);
					}
					echo ($content);
				?>
	        </main>
		</div>

        <?php
			include 'views/footer.php';
		?>
    </body>
</html>
