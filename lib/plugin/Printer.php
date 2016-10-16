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
	 * Holds the letter template.
	 * @var string
	 */
	private $template = null;

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
		$this->dompdf = new Dompdf();

		// Setup
		$this->set_options();
	}

	/**
	 * Setup options for Dompdf.
	 * @return  void
	 */
	private function set_options()
	{
		$this->dompdf->set_paper(array(0, 0, 325.98, 646.299), 'landscape');
		$this->dompdf->set_option('isHtml5ParserEnabled', true);
		$this->dompdf->set_option('isRemoteEnabled', true);
		$this->dompdf->set_option('chroot', __DIR__ . '/templates');
	}

	/**
	 * [output description]
	 * @return [type] [description]
	 */
	public function output()
	{
		$this->dompdf->loadHtmlFile(__DIR__ . '/templates/letter.html');
		$this->dompdf->render();
		$this->dompdf->stream(time() . '_document', array(0, 0));
	}
}

/**
 * Return the new initiated instance of KD_Letters class.
 */
return (new Printer());