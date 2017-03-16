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
			'post_type' => 'product',
			'meta_key' => '_ebay_id',
			'meta_value' => $this->idEbay,
			);
		$query=new WP_Query($args);
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$header=array();
				$column=array();
				foreach($this->details->ItemCompatibilityList->Compatibility as $compatible){
					var_dump($compatible[0]);
				}
				// var_dump($this->details->ItemCompatibilityList);
				// die();
				// var_dump(get_field('compatible_table'));
				// echo 'Product Id '.$query->post->ID;
			}
		}
		else{
			echo 'not Found post with Ebay Id'.$this->idEbay;
		}
	}
}
