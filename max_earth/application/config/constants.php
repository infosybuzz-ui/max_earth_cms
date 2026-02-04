<?php
defined('BASEPATH') OR exit('No direct script access allowed');

defined('REGEX_APLHA_SPACE') or define('REGEX_APLHA_SPACE' , '/^[a-zA-Z\s]+$/i');
defined('REGEX_APLHA_SPACE_R') or define('REGEX_APLHA_SPACE_R' , '/[^a-zA-Z ]/g');

defined('REGEX_APLHA') or define('REGEX_APLHA' , '/^[A-Za-z]+$/i');
defined('REGEX_APLHA_R') or define('REGEX_APLHA_R' , '/[^a-zA-Z]/g');

defined('REGEX_NUM') or define('REGEX_NUM' , '/^[0-9]+$/i');
defined('REGEX_NUM_R') or define('REGEX_NUM_R' , '/[^0-9]/g');

defined('REGEX_APLHA_NUM') or define('REGEX_APLHA_NUM' , '/^[A-Za-z0-9]+$/i');
defined('REGEX_APLHA_NUM_R') or define('REGEX_APLHA_NUM_R' , '/[^A-Za-z0-9]/g');

defined('REGEX_APLHA_NUM_SPACE') or define('REGEX_APLHA_NUM_SPACE' , '/^[A-Za-z0-9\s]+$/i');
defined('REGEX_APLHA_NUM_SPACE_R') or define('REGEX_APLHA_NUM_SPACE_R' , '/[^A-Za-z0-9\s]/g');

defined('REGEX_VALID_ADDR') or define('REGEX_VALID_ADDR' , '/^[A-Za-z0-9\s\.\#\-\,\/]+$/i');
defined('REGEX_VALID_ADDR_R') or define('REGEX_VALID_ADDR_R' , '/[^A-Za-z0-9\s\.\#\-\,\/]/g');

defined('REGEX_FLOAT') or define('REGEX_FLOAT' , '/^[0-9\.]+$/i');
defined('REGEX_FLOAT_R') or define('REGEX_FLOAT_R' , '/[^0-9\.]/g');

defined('REGEX_VALID_BSNLID') or define('REGEX_VALID_BSNLID' , '/^[a-zA-Z0-9\_\-\.\/]+$/i');
defined('REGEX_VALID_BSNLID_R') or define('REGEX_VALID_BSNLID_R' , '/[^a-zA-Z0-9\_\-\.\/]/g');

defined('REGEX_VALID_ADMIN_USERNAME') or define('REGEX_VALID_ADMIN_USERNAME' , '/^[a-zA-Z0-9\_]+$/i');
defined('REGEX_VALID_ADMIN_USERNAME_R') or define('REGEX_VALID_ADMIN_USERNAME_R' , '/[^a-zA-Z0-9\_]/g');

defined('REGEX_VALID_DESC') or define('REGEX_VALID_DESC' , '/^[A-Za-z0-9\s\.\-\,]+$/i');
defined('REGEX_VALID_DESC_R') or define('REGEX_VALID_DESC_R' , '/[^A-Za-z0-9\s\.\-\,]/g');

defined('REGEX_DATE') or define('REGEX_DATE' , '/^[0-9\-]+$/i');
defined('REGEX_DATE_R') or define('REGEX_DATE_R' , '/[^0-9\-]/g');

defined('REGEX_PLAN_NAME') or define('REGEX_PLAN_NAME' , '/^[a-zA-Z0-9\_\s]+$/i');
defined('REGEX_PLAN_NAME_R') or define('REGEX_PLAN_NAME_R' , '/[^a-zA-Z0-9\_\s]/g');

defined('REGEX_PLAN_CODE') or define('REGEX_PLAN_CODE' , '/^[a-zA-Z0-9\_]+$/i');
defined('REGEX_PLAN_CODE_R') or define('REGEX_PLAN_CODE_R' , '/[^a-zA-Z0-9\_]/g');

defined('REGEX_VALID_IP') or define('REGEX_VALID_IP' , '/^[0-9\.]+$/i');
defined('REGEX_VALID_IP_R') or define('REGEX_VALID_IP_R' , '/[^0-9\.]/g');

defined('REGEX_C_NAME') or define('REGEX_C_NAME' , '/^[a-zA-Z\s\.]+$/i');
defined('REGEX_C_NAME_R') or define('REGEX_C_NAME_R' , '/[^a-zA-Z\s\.]/g');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

