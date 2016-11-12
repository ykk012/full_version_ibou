{"changed":false,"filter":false,"title":"index.php","tooltip":"/index.php","value":"<?php\n/**\n * CodeIgniter\n *\n * An open source application development framework for PHP\n *\n * This content is released under the MIT License (MIT)\n *\n * Copyright (c) 2014 - 2016, British Columbia Institute of Technology\n *\n * Permission is hereby granted, free of charge, to any person obtaining a copy\n * of this software and associated documentation files (the \"Software\"), to deal\n * in the Software without restriction, including without limitation the rights\n * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell\n * copies of the Software, and to permit persons to whom the Software is\n * furnished to do so, subject to the following conditions:\n *\n * The above copyright notice and this permission notice shall be included in\n * all copies or substantial portions of the Software.\n *\n * THE SOFTWARE IS PROVIDED \"AS IS\", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR\n * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,\n * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE\n * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER\n * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,\n * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN\n * THE SOFTWARE.\n *\n * @package\tCodeIgniter\n * @author\tEllisLab Dev Team\n * @copyright\tCopyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)\n * @copyright\tCopyright (c) 2014 - 2016, British Columbia Institute of Technology (http://bcit.ca/)\n * @license\thttp://opensource.org/licenses/MIT\tMIT License\n * @link\thttps://codeigniter.com\n * @since\tVersion 1.0.0\n * @filesource\n */\n\n/*\n *---------------------------------------------------------------\n * APPLICATION ENVIRONMENT\n *---------------------------------------------------------------\n *\n * You can load different configurations depending on your\n * current environment. Setting the environment also influences\n * things like logging and error reporting.\n *\n * This can be set to anything, but default usage is:\n *\n *     development\n *     testing\n *     production\n *\n * NOTE: If you change these, also change the error_reporting() code below\n */\n\tdefine('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');\n\n/*\n *---------------------------------------------------------------\n * ERROR REPORTING\n *---------------------------------------------------------------\n *\n * Different environments will require different levels of error reporting.\n * By default development will show errors but testing and live will hide them.\n */\nswitch (ENVIRONMENT)\n{\n\tcase 'development':\n\t\terror_reporting(-1);\n\t\tini_set('display_errors', 1);\n\tbreak;\n\n\tcase 'testing':\n\tcase 'production':\n\t\tini_set('display_errors', 0);\n\t\tif (version_compare(PHP_VERSION, '5.3', '>='))\n\t\t{\n\t\t\terror_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);\n\t\t}\n\t\telse\n\t\t{\n\t\t\terror_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);\n\t\t}\n\tbreak;\n\n\tdefault:\n\t\theader('HTTP/1.1 503 Service Unavailable.', TRUE, 503);\n\t\techo 'The application environment is not set correctly.';\n\t\texit(1); // EXIT_ERROR\n}\n\n/*\n *---------------------------------------------------------------\n * SYSTEM DIRECTORY NAME\n *---------------------------------------------------------------\n *\n * This variable must contain the name of your \"system\" directory.\n * Set the path if it is not in the same directory as this file.\n */\n\t$system_path = 'system';\n\n/*\n *---------------------------------------------------------------\n * APPLICATION DIRECTORY NAME\n *---------------------------------------------------------------\n *\n * If you want this front controller to use a different \"application\"\n * directory than the default one you can set its name here. The directory\n * can also be renamed or relocated anywhere on your server. If you do,\n * use an absolute (full) server path.\n * For more info please see the user guide:\n *\n * https://codeigniter.com/user_guide/general/managing_apps.html\n *\n * NO TRAILING SLASH!\n */\n\t$application_folder = 'application';\n\n/*\n *---------------------------------------------------------------\n * VIEW DIRECTORY NAME\n *---------------------------------------------------------------\n *\n * If you want to move the view directory out of the application\n * directory, set the path to it here. The directory can be renamed\n * and relocated anywhere on your server. If blank, it will default\n * to the standard location inside your application directory.\n * If you do move this, use an absolute (full) server path.\n *\n * NO TRAILING SLASH!\n */\n\t$view_folder = '';\n\n\n/*\n * --------------------------------------------------------------------\n * DEFAULT CONTROLLER\n * --------------------------------------------------------------------\n *\n * Normally you will set your default controller in the routes.php file.\n * You can, however, force a custom routing by hard-coding a\n * specific controller class/function here. For most applications, you\n * WILL NOT set your routing here, but it's an option for those\n * special instances where you might want to override the standard\n * routing in a specific front controller that shares a common CI installation.\n *\n * IMPORTANT: If you set the routing here, NO OTHER controller will be\n * callable. In essence, this preference limits your application to ONE\n * specific controller. Leave the function name blank if you need\n * to call functions dynamically via the URI.\n *\n * Un-comment the $routing array below to use this feature\n */\n\t// The directory name, relative to the \"controllers\" directory.  Leave blank\n\t// if your controller is not in a sub-directory within the \"controllers\" one\n\t// $routing['directory'] = '';\n\n\t// The controller class file name.  Example:  mycontroller\n\t// $routing['controller'] = '';\n\n\t// The controller function you wish to be called.\n\t// $routing['function']\t= '';\n\n\n/*\n * -------------------------------------------------------------------\n *  CUSTOM CONFIG VALUES\n * -------------------------------------------------------------------\n *\n * The $assign_to_config array below will be passed dynamically to the\n * config class when initialized. This allows you to set custom config\n * items or override any default config values found in the config.php file.\n * This can be handy as it permits you to share one application between\n * multiple front controller files, with each file containing different\n * config values.\n *\n * Un-comment the $assign_to_config array below to use this feature\n */\n\t// $assign_to_config['name_of_config_item'] = 'value of config item';\n\n\n\n// --------------------------------------------------------------------\n// END OF USER CONFIGURABLE SETTINGS.  DO NOT EDIT BELOW THIS LINE\n// --------------------------------------------------------------------\n\n/*\n * ---------------------------------------------------------------\n *  Resolve the system path for increased reliability\n * ---------------------------------------------------------------\n */\n\n\t// Set the current directory correctly for CLI requests\n\tif (defined('STDIN'))\n\t{\n\t\tchdir(dirname(__FILE__));\n\t}\n\n\tif (($_temp = realpath($system_path)) !== FALSE)\n\t{\n\t\t$system_path = $_temp.DIRECTORY_SEPARATOR;\n\t}\n\telse\n\t{\n\t\t// Ensure there's a trailing slash\n\t\t$system_path = strtr(\n\t\t\trtrim($system_path, '/\\\\'),\n\t\t\t'/\\\\',\n\t\t\tDIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR\n\t\t).DIRECTORY_SEPARATOR;\n\t}\n\n\t// Is the system path correct?\n\tif ( ! is_dir($system_path))\n\t{\n\t\theader('HTTP/1.1 503 Service Unavailable.', TRUE, 503);\n\t\techo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);\n\t\texit(3); // EXIT_CONFIG\n\t}\n\n/*\n * -------------------------------------------------------------------\n *  Now that we know the path, set the main path constants\n * -------------------------------------------------------------------\n */\n\t// The name of THIS file\n\tdefine('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));\n\n\t// Path to the system directory\n\tdefine('BASEPATH', $system_path);\n\n\t// Path to the front controller (this file) directory\n\tdefine('FCPATH', dirname(__FILE__).DIRECTORY_SEPARATOR);\n\n\t// Name of the \"system\" directory\n\tdefine('SYSDIR', basename(BASEPATH));\n\n\t// The path to the \"application\" directory\n\tif (is_dir($application_folder))\n\t{\n\t\tif (($_temp = realpath($application_folder)) !== FALSE)\n\t\t{\n\t\t\t$application_folder = $_temp;\n\t\t}\n\t\telse\n\t\t{\n\t\t\t$application_folder = strtr(\n\t\t\t\trtrim($application_folder, '/\\\\'),\n\t\t\t\t'/\\\\',\n\t\t\t\tDIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR\n\t\t\t);\n\t\t}\n\t}\n\telseif (is_dir(BASEPATH.$application_folder.DIRECTORY_SEPARATOR))\n\t{\n\t\t$application_folder = BASEPATH.strtr(\n\t\t\ttrim($application_folder, '/\\\\'),\n\t\t\t'/\\\\',\n\t\t\tDIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR\n\t\t);\n\t}\n\telse\n\t{\n\t\theader('HTTP/1.1 503 Service Unavailable.', TRUE, 503);\n\t\techo 'Your application folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;\n\t\texit(3); // EXIT_CONFIG\n\t}\n\n\tdefine('APPPATH', $application_folder.DIRECTORY_SEPARATOR);\n\n\t// The path to the \"views\" directory\n\tif ( ! isset($view_folder[0]) && is_dir(APPPATH.'views'.DIRECTORY_SEPARATOR))\n\t{\n\t\t$view_folder = APPPATH.'views';\n\t}\n\telseif (is_dir($view_folder))\n\t{\n\t\tif (($_temp = realpath($view_folder)) !== FALSE)\n\t\t{\n\t\t\t$view_folder = $_temp;\n\t\t}\n\t\telse\n\t\t{\n\t\t\t$view_folder = strtr(\n\t\t\t\trtrim($view_folder, '/\\\\'),\n\t\t\t\t'/\\\\',\n\t\t\t\tDIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR\n\t\t\t);\n\t\t}\n\t}\n\telseif (is_dir(APPPATH.$view_folder.DIRECTORY_SEPARATOR))\n\t{\n\t\t$view_folder = APPPATH.strtr(\n\t\t\ttrim($view_folder, '/\\\\'),\n\t\t\t'/\\\\',\n\t\t\tDIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR\n\t\t);\n\t}\n\telse\n\t{\n\t\theader('HTTP/1.1 503 Service Unavailable.', TRUE, 503);\n\t\techo 'Your view folder path does not appear to be set correctly. Please open the following file and correct this: '.SELF;\n\t\texit(3); // EXIT_CONFIG\n\t}\n\n\tdefine('VIEWPATH', $view_folder.DIRECTORY_SEPARATOR);\n\n/*\n * --------------------------------------------------------------------\n * LOAD THE BOOTSTRAP FILE\n * --------------------------------------------------------------------\n *\n * And away we go...\n */\nrequire_once BASEPATH.'core/CodeIgniter.php';\n","undoManager":{"mark":-1,"position":-1,"stack":[]},"ace":{"folds":[],"scrolltop":780,"scrollleft":0,"selection":{"start":{"row":0,"column":0},"end":{"row":0,"column":0},"isBackwards":false},"options":{"guessTabSize":true,"useWrapMode":false,"wrapToView":true},"firstLineState":{"row":56,"state":"php-start","mode":"ace/mode/php"}},"timestamp":1465819298711}