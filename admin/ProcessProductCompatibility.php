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
				$headerElement=$this->details->ItemCompatibilityList->Compatibility[0];
				foreach($headerElement->NameValueList as $listElement){
					if($listElement->Name!=''){
						$column=array('c'=>$listElement->Name->__toString());
						array_push($header,$column);
					}

				}
				$column=array(
					'c'=>'Compatibility Notes');
				array_push($header,$column);
				var_dump(get_field('compatible_table'));
				die();
				update_field('compatible_table', $table, $query->post->ID);
				foreach($this->details->ItemCompatibilityList->Compatibility as $compatible){


				}
			}
				// var_dump($this->details->ItemCompatibilityList);
				// die();
				
				// echo 'Product Id '.$query->post->ID;
		}
		else{
			echo 'not Found post with Ebay Id'.$this->idEbay;
		}
	}
}
