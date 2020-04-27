<?php 
/**
 * @version    2.0.0
 * @package    com_angkor
 * @author     Alex Chartier <alex@skurvishenterprises.com>
 * @copyright  2020 Skurvish Enterprises
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
 
/* Autoloader for the angkor classes */

spl_autoload_register(function($classname) { 
	/* Don't process any that are not in our namespace */
	if (strpos($classname, 'Skurvish') === false) return;
	if (strpos($classname, 'Angkor') === false) return;
	/* build the path and filename for the include */
	$filename = JPATH_LIBRARIES.'/skurvish/angkor/' . strtolower(basename(str_replace("\\", DIRECTORY_SEPARATOR, $classname))) . '.php';
	/* Check that it exists and if so load it */
	if (file_exists($filename)) {
		require_once($filename);
	}
});