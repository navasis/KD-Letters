<?php
/**
 * KD-Letters.php
 * 
 * The overall controller of KD-Letters plugin.
 *
 * @package     KD-Letters
 * @author      Romas Navašinskas
 * @copyright   2016 www.kaledudirbtuves.lt
 * @license     NONE
 */
class KD_Letters
{
	/**
	 * Dispatches plugin's actions and calls.
	 * @return void
	 */
	public function dispatch()
	{
		$this->register_actions();
		$this->register_scripts();

		if (isset($_GET['generate_letters']) && $_GET['page'] == 'kd-letters')
		{
			$this->generate();
		}
	}

	/**
	 * Adds admin menu page.
	 * @return void
	 */
	public function admin_menu() 
	{
		add_options_page('Generuoti laiškus', 'Generuoti laiškus', 'manage_options', 'kd-letters', array($this, 'admin_menu_options'));
	}
	
	/**
	 * Controlls the admin menu page view and renders it.
	 * @return void
	 */
	public function admin_menu_options()
	{
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		$total_orders = $this->get_num_total_orders();
		$waiting_orders = $this->get_num_waiting_orders();
		$progress = round(($waiting_orders / $total_orders) * 100);

		include __DIR__ . '/templates/admin_menu.php';
	}

	/**
	 * Registers plugin actions.
	 * @return void
	 */
	private function register_actions()
	{
		add_action('admin_menu', array($this, 'admin_menu'));
	}

	/**
	 * Registers plugin styles and scripts.
	 * @return void
	 */
	private function register_scripts()
	{
		if (is_admin()) {
			// Load our main stylesheet.
			wp_enqueue_style('kd-letters', plugin_dir_url( __FILE__ ) . '/templates/style/kd-letters.css');
		}
	}

	/**
	 * Returns the total number of orders.
	 * @return int Number of orders.
	 */
	private function get_num_total_orders()
	{
		return wp_count_posts('order_paysera')->publish;
	}

	/**
	 * Returns the total number of awaiting orders to be printed.
	 * @return int Number of orders.
	 */
	private function get_num_waiting_orders()
	{
		return sizeof($this->get_waiting_orders());
	}

	/**
	 * Returns the array of awaiting orders to be printed.
	 * @return array Array of orders.
	 */
	public function get_waiting_orders()
	{
		return get_posts(array(
			'posts_per_page' => -1,
			'orderby' => 'date',
			'order' => 'DESC',
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key' => '_kd_letters_generated',
					'compare' => 'NOT EXISTS'
				),
				array(
					'key' => '_kd_letters_generated',
					'value' => '0'
				)
			),
			'post_type' => 'order_paysera'
		));
	}

	/**
	 * Creates a PDF file with print-ready KD letters.
	 * @return void
	 */
	private function generate()
	{
		$printer = require_once __DIR__ . '/Printer.php';
		$orders  = $this->get_waiting_orders();
		
		$printer->setup($this);

		/*foreach ($orders as $order) {
			$printer->add($order);
		}

		$printer->print();*/
	}
}

/**
 * Return the new initiated instance of KD_Letters class.
 */
return (new KD_Letters());