<?php
/**
 * Configuration for: Debug mode
 * Debugging mode switch. To show/hide debug related contents throuout thew app.
 * Set to false in production.
 */
define("DEBUG_MODE", false);

/**
 * Configuration for: Application name
 * Name to be used/displayed throughout the app
 */
define("APP_NAME", "sumatra-api");

/**
 * API version number
 */
define("API_VERSION", "v1.0");

/**
 * Configuration for: API URL
 * This is the base url of our api. if you go live with your app, put your full domain name here.
 * if you are using a (different) port, then put this in here, like http://mydomain:8888/subfolder/
 * Set PATH_BASE to empty string if using root html folder of the domain or subdomain.
 * Note: The trailing slashes are important!
 */
define('PATH_BASE', 'sumatra-api/');
define('URL', 'http://localhost:8888/' . PATH_BASE);

/**
 * Configuration for: Public folder URL
 * This is the URL that the public folder will be accessible at.
 */
define('PUBLIC_URL', 'http://localhost:8888/sumatra-database/public/');

/**
 * Configuration for: Folders
 * There's no need to change this, unless the folders get renamed.
 */
define('LIBS_PATH', 'libs/');
define('CONTROLLER_PATH', 'controllers/');
define('MODELS_PATH', 'models/');
define('VIEWS_PATH', 'views/');

/**
 * Configuration for: Images folder
 * IMG_ORIG original images (private)
 * IMG_PATH resized and tiled images (public)
 */
define('IMG_ORIG', '../images/');
define('IMG_PATH', '../public/img/taxa/');

/**
 * Configuration for: Database
 *
 * DB_TYPE The used database type. Note that other types than "mysql" might break the db construction currently.
 * DB_HOST The mysql hostname, usually localhost or 127.0.0.1
 * DB_NAME The database name
 * DB_USER The username
 * DB_PASS The password
 * DB_PORT The mysql port, 3306 by default (?), find out via phpinfo() and look for mysqli.default_port.
 * DB_CHARSET The charset, necessary for security reasons. Check Database.php class for more info.
 */
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'my_app');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_PORT', '3306');
define('DB_CHARSET', 'utf8');

/**
 * Configuration for: Images refresh token
 * This token is to be used to refresh the preview images and tiles from original files.
 * This is just to keep the refresh operation from being run publicaly.
 * But it can not be harmfull - if refresh is hit when there arew no changes in the original files it does not have any effect.
 */
define('IMG_TOKEN', 'tshO2XkyV2hx340Nrrmd8X~uvUDg9E');
