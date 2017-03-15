<?php
class EbayProductGiorgiosaud extends WP_List_Table{
	/**
    * Constructor, we override the parent to pass our own arguments
    * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
    */
	public $items;
	public $pages;
	public $totalItems;
	public $entriesPerPage;
	function __construct($items, $pages,$totalItems,$entriesPerPage) {
		parent::__construct( array(
			'singular'=> 'wp_ebay_products_list', //Singular label
			'plural' => 'wp_ebay_products_lists', //plural label, also this well be one of the table css class
			'ajax'   => false //We won't support Ajax for this table
			));
		$this->items = $items;
		$this->pages = $pages;
		$this->totalItems=$totalItems;
		$this->entriesPerPage=$entriesPerPage;

	}
	/**
 * Add extra markup in the toolbars before or after the list
 * @param string $which, helps you decide if you add the markup after (bottom) or before (top) the list
 */
	function extra_tablenav( $which ) {
		if ( $which == "top" ){
      //The code that goes before the table is here
			echo"Hello, I'm before the table";
		}
		if ( $which == "bottom" ){
      //The code that goes after the table is there
			echo"Hi, I'm after the table";
		}
	}
	/**
 * Define the columns that are going to be used in the table
 * @return array $columns, the array of columns to use with the table
 */
	function get_columns() {
		return $columns= array(
			'col_link_id'=>__('ID'),
			'col_link_name'=>__('Name'),
			'col_link_url'=>__('Url'),
			);
	}
	/**
 * Decide which columns to activate the sorting functionality on
 * @return array $sortable, the array of columns that can be sorted by the user
 */
	public function get_sortable_columns() {
		return $sortable = array(
			'col_link_id'=>'link_id',
			'col_link_name'=>'link_name',
			);
	}
	/**
 	* Prepare the table with different parameters, pagination, columns and table elements
 	*/
 	function prepare_items() {
 		global $_wp_column_headers;
 		// $totalitems
 		// if(empty($paged) || !is_numeric($paged) || $paged<=0 ){ $paged=1; } //How many pages do we have in total? $totalpages = ceil($totalitems/$perpage); //adjust the query to take pagination into account if(!empty($paged) && !empty($perpage)){ $offset=($paged-1)*$perpage; $query.=' LIMIT '.(int)$offset.','.(int)$perpage; } /* -- Register the pagination -- */ 
 		$this->set_pagination_args( array(
 			"total_items" => $this->totalitems,
 			"total_pages" => $this->pages,
 			"per_page" => $this->entriesPerPage,
 			) );
 		$columns = $this->get_columns();
 		$_wp_column_headers[$screen->id]=$columns;
 		$elementos=array();
 		foreach ($this->items as $item) {
 			array_push(
 				$elementos,array(
 					'ID'=>$item['itemId'],
 					'Name'=>$item['title'],
 					'URL'=>$item['viewItemURL'],
 					)
 				);
 		}
 		$this->items = $elementos;


 	}
 	/**
 * Display the rows of records in the table
 * @return string, echo the markup of the rows
 */
 	function display_rows() {

   //Get the records registered in the prepare_items method
 		$records = $this->items;

   //Get the columns registered in the get_columns and get_sortable_columns methods
 		list( $columns, $hidden ) = $this->get_column_info();

   //Loop for each record
 		if(!empty($records)){foreach($records as $rec){

      //Open the line
 			echo '< tr id="record_'.$rec->link_id.'">';
 			foreach ( $columns as $column_name => $column_display_name ) {

         //Style attributes for each col
 				$class = "class='$column_name column-$column_name'";
 				$style = "";
 				if ( in_array( $column_name, $hidden ) ) $style = ' style="display:none;"';
 				$attributes = $class . $style;

         //edit link
 				$editlink  = '/wp-admin/link.php?action=edit&link_id='.(int)$rec->link_id;

         //Display the cell
 				switch ( $column_name ) {
 					case "col_link_id":  echo '< td '.$attributes.'>'.stripslashes($rec->link_id).'< /td>';   break;
 					case "col_link_name": echo '< td '.$attributes.'>'.stripslashes($rec->link_name).'7< /td>'; break;
 					case "col_link_url": echo '< td '.$attributes.'>'.stripslashes($rec->link_url).'< /td>'; break;
 					case "col_link_description": echo '< td '.$attributes.'>'.$rec->link_description.'< /td>'; break;
 					case "col_link_visible": echo '< td '.$attributes.'>'.$rec->link_visible.'< /td>'; break;
 				}
 			}

      //Close the line
 			echo'< /tr>';
 		}}
 	}


 }
// 	private $xml;
// 	public $eBayId;
// 	public $title;
// 	public $description;
// 	public $mainPicture;
// 	public $qty;
// 	public $price;
// 	public $specificationsTitles;
// 	public $specifications;
// 	public $compatibilityTitles;
// 	public $compatibility;
// 	public $conditionitemsion;
// 	publpages
	// private $PROPERTY;
	// private $PROPERTY;

// 	public function __construct($xml)
// 	{
// 		$this->xml = $xml;
// 		$this->specifications=new stdClass();
// 		$this->specificationsTitles=array();
// 		$this->compatibility=array();
// 		$this->parseXML();
// 	}
// 	static public function slugify($text)
// 	{
//   // replace non letter or digits by -
// 		$text = preg_replace('~[^\pL\d]+~u', '', $text);

//   // transliterate
// 		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

//   // remove unwanted characters
// 		$text = preg_replace('~[^-\w]+~', '', $text);

//   // trim
// 		$text = trim($text, '-');

//   // remove duplicate -
// 		$text = preg_replace('~-+~', '-', $text);

//   // lowercase
// 		$text = strtolower($text);

// 		if (empty($text)) {
// 			return 'n-a';
// 		}

// 		return $text;
// 	}
// 	protected function parseXML(){
// 		$this->eBayId = $this->xml->ItemID->__toString();
// 		$this->title = $this->xml->Title->__toString();
// 		$this->eBayUrl=$this->xml->ViewItemURLForNaturalSearch->__toString();
// 		$this->qty=$this->xml->Quantity->__toString();
// 		$this->price=$this->xml->ConvertedCurrentPrice->__toString();
// 		$this->conditionDescription=$this->xml->ConditionDescription->__toString();
// 		$this->SKU=$this->xml->SKU->__toString();
// 		$picurl=$this->xml->PictureURL[0]->__toString();
// 		$this->mainPicture=substr($picurl,0,strpos( $picurl, 'JPG' )+3);
// 		$this->descriptiontext = preg_replace('#(<[a-z ]*)(style=("|\')(.*?)("|\'))([a-z ]*>)#', '\\1\\6', strip_tags( $this->xml->Description->__toString(),'<a>'));
// 		$this->description=$this->xml->Description->__toString();

// 		// die(var_dump($this->xml->ItemSpecifics));
// 		foreach($this->xml->ItemSpecifics->NameValueList as $specifics){
// 			$fullName=$specifics->Name->__toString();
// 			$name=$this->slugify($fullName);
// 			$this->specificationsTitles[$name]=$fullName;
// 			$val=$specifics->Value->__toString();
// 			$this->specifications->{$name}=$val;
// 		}
// 		$compatibilityList = json_decode(json_encode($this->xml->ItemCompatibilityList), TRUE);

// 		if(isset($compatibilityList["Compatibility"])){
// 			foreach($compatibilityList["Compatibility"] as $compatibilityItem){
// 			// dd($compatibilityItem);
// 				$compatibleFull=new stdClass();
// 				if(count($compatibilityItem["CompatibilityNotes"])>0){
// 					$compatibleFull->notes=$compatibilityItem["CompatibilityNotes"];
// 				}
// 				foreach($compatibilityItem["NameValueList"] as $compatibleElement){

// 					if(count($compatibleElement)>0){
// var_dump($this->specificationsTitles);	
// 		foreach ($this->speci
// 		}
// 	}
// 	/* Import media from url
// 	*
// 	* @param string $file_url URL of the existing file from the original site
// 	* @param int $post_id The post ID of the post to which the imported media is to be attached
// 	*
// 	* @return boolean True on success, false on failure
// 	*/
// 	public function SaveOrUpdate(){
// 		return $this;
// 	}

// 	public function fetch_media_for_post($file_url, $post_id) {
// 		require_once(ABSPATH . 'wp-load.php');
// 		require_once(ABSPATH . 'wp-admin/includes/image.php');
// 		global $wpdb;

// 		if(!$post_id) {
// 			return false;
// 		}

// 		//directory to import to	
// 		$artDir = 'wp-content/uploads/importedmedia/';

// 		//if the directory doesn't exist, create it	
// 		if(!file_exists(ABSPATH.$artDir)) {
// 			mkdir(ABSPATH.$artDir);
// 		}

// 	//rename the file... alternatively, you could explode on "/" and keep the original file name
// 		$ext = array_pop(explode(".", $file_url));
// 	$new_filename = 'product-'.$post_id.".".$ext; //if your post has multiple files, you may need to add a random number to the file name to prevent overwrites

// 	if (@fclose(@fopen($file_url, "r"))) { //make sure the file actually exists
// 		copy($file_url, ABSPATH.$artDir.$new_filename);

// 		$siteurl = get_option('siteurl');
// 		$file_info = getimagesize(ABSPATH.$artDir.$new_filename);

// 	//create an array of attachment data to insert into wp_posts table
// 		$artdata = array();
// 		$artdata = array(
// 			'post_author' => 1, 
// 			'post_date' => current_time('mysql'),
// 			'post_date_gmt' => current_time('mysql'),
// 			'post_title' => $new_filename, 
// 			'post_status' => 'inherit',
// 			'comment_status' => 'closed',
// 			'ping_status' => 'closed',
// 			'post_name' => sanitize_title_with_dashes(str_replace("_", "-", $new_filename)),				
// 			'post_modified' => current_time('mysql'),
// 			'post_modified_gmt' => current_time('mysql'),
// 			'post_parent' => $post_id,
// 			'post_type' => 'attachment',
// 			'guid' => $siteurl.'/'.$artDir.$new_filename,
// 			'post_mime_type' => $file_info['mime'],
// 			'post_excerpt' => '',
// 			'post_content' => ''
// 			);

// 		$uploads = wp_upload_dir();
// 		$save_path = $uploads['basedir'].'/importedmedia/'.$new_filename;

// 	//insert the database record
// 		$attach_id = wp_insert_attachment( $artdata, $save_path, $post_id );

// 	//generate metadata and thumbnails
// 		if ($attach_data = wp_generate_attachment_metadata( $attach_id, $save_path)) {
// 			wp_update_attachment_metadata($attach_id, $attach_data);
// 		}

// //optional make it the featured image of the post it's attached to
// 		$rows_affected = $wpdb->insert($wpdb->prefix.'postmeta', array('post_id' => $post_id, 'meta_key' => '_thumbnail_id', 'meta_value' => $attach_id));
// 	}
// 	else {
// 		return false;
// 	}

// 	return true;
// }
// }