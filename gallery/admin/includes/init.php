<?php


defined('DS') ? null : define ('DS', DIRECTORY_SEPARATOR);

define('SITE_ROOT', 'C:' . DS . 'Users' . DS . 'GBXFR' . DS . 'PHP' . DS . 'xampp' . DS . 'htdocs' . DS . 'OOP' . DS . 'gallery');

defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT . DS . 'admin' . DS . 'includes');


require_once(INCLUDES_PATH.DS."functions.php");
require_once(INCLUDES_PATH.DS."new_config.php");
require_once(INCLUDES_PATH.DS."database.php");
require_once(INCLUDES_PATH.DS."db_object.php");
require_once(INCLUDES_PATH.DS."user.php");
require_once(INCLUDES_PATH.DS."photo.php");
require_once(INCLUDES_PATH.DS."session.php");
require_once(INCLUDES_PATH.DS."comment.php");
require_once(INCLUDES_PATH.DS."paginate.php");





?>