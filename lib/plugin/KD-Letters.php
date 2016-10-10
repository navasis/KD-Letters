<?php
/**
 * KD-Letters.php
 * 
 * Description
 *
 * @package     KD-Letters
 * @author      Romas Navašinskas
 * @copyright   2016 www.kaledudirbtuves.lt
 * @license     NONE
 */
class KD_Letters
{
	/**
	 * [dispatch description]
	 * @return [type] [description]
	 */
	public function dispatch()
	{
		add_action('admin_menu', array($this, 'admin_menu'));

		if (is_admin()) {
			// Load our main stylesheet.
			wp_enqueue_style('kd-letters', plugin_dir_url( __FILE__ ) . '/templates/style/kd-letters.css');
		}
	}

	/**
	 * [admin_menu description]
	 * @return [type] [description]
	 */
	public function admin_menu() 
	{
		add_options_page('Generuoti laiškus', 'Generuoti laiškus', 'manage_options', 'kd-letters', array($this, 'admin_menu_options'));
	}
	
	/**
	 * [admin_menu_options description]
	 * @return [type] [description]
	 */
	public function admin_menu_options()
	{
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		$total_orders = $this->get_total_orders();
		$waiting_orders = $this->get_waiting_orders();
		$progress = round(($waiting_orders / $total_orders) * 100);

		include __DIR__ . '/templates/admin_menu.php';
	}

	/**
	 * [get_total_orders description]
	 * @return [type] [description]
	 */
	private function get_total_orders()
	{
		return wp_count_posts('order_paysera')->publish;
	}

	/**
	 * [get_waiting_orders description]
	 * @return [type] [description]
	 */
	private function get_waiting_orders()
	{
		$posts = get_posts(array(
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

		return sizeof($posts);
	}
}

/**
 * Return the new initiated instance of KD_Letters class.
 */
return (new KD_Letters());