<?php 
class ProcessProductCompatibility{
	public $idEbay;
	public $details;

	public function __construct($idEbay, $details){

		$this->idEbay = $idEbay;
		$this->details = $details;
	}
	public function newOrUpdateCompatibility(){
		$args = array(
			'post_type'  => 'product',
			'meta_query' => array(
				'key'     => '_ebay_id',
				'value'   => $this->idEbay,
				'compare' => '=',
				)
			);
		$query=new WP_Query($args);
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				echo 'Product Id '.$query->post->ID;
			}
		}
		else{
			echo 'not Found post with Ebay Id'.$this->idEbay;
		}
	}
}
