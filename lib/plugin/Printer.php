<?php
/**
 * Printer.php
 * 
 * Printer class that exectures the printing logic.
 *
 * @package     KD-Letters
 * @author      Romas Navašinskas
 * @copyright   2016 www.kaledudirbtuves.lt
 * @license     NONE
 */
class Printer
{
	/**
	 * Holds the instance of KD_Letters class.
	 * @var KD_Letters object
	 */
	private $kdl = null;

	/**
	 * Initialisses the Printer class and creates a connection between the
	 * KD_Letters object and this class.
	 * 
	 * @param  KD_Letters $kdl Instance of KD_Letters class.
	 * @return void
	 */
	public function setup(KD_Letters $kdl)
	{
		$this->kdl = $kdl;

		/**
		 * Autoload composer dependecies,
		 * which contain dompdf/dompdf vendor lib.
		 */
		require_once COMPOSER . '/autoload.php';
	}
}

/**
 * Return the new initiated instance of KD_Letters class.
 */
return (new Printer());