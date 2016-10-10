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

use Dompdf\Dompdf;
use Dompdf\Options;

class Printer
{
	/**
	 * Holds the instance of KD_Letters class.
	 * @var KD_Letters object
	 */
	private $kdl = null;

	/**
	 * Holds the instance of dompdf/dompdf class.
	 * @var Dompdf
	 */
	private $dompdf = null;

	/**
	 * Holds the dompdf/dompdf options class.
	 * @var Options
	 */
	private $options = null;

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

		// Class injection
		$this->options = new Options();
		$this->dompdf = new Dompdf($this->options);

		// Setup
		$this->set_options();
	}

	/**
	 * Setup options for Dompdf.
	 * @return  void
	 */
	private function set_options()
	{
		$this->dompdf->set_paper(array(
			0, 0,
			311.81, 623.622
		));
	}
}

/**
 * Return the new initiated instance of KD_Letters class.
 */
return (new Printer());