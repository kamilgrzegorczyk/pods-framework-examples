<?php 
Class LGPodsAdmin {

    //what permissions are needed to access pages
	const PERMISSIONS = 'manage_options';
	//Slug for main page object
	const MENU_SLUG   = 'lg_pods';

	public static function initialize_plugin() {

		//initializing menus
		add_action('admin_menu', array('LGPodsAdmin','initialize_admin_area'));

		//doing some other various stuff
	}

	public static function initialize_admin_area () {

		//set Your icon URL here
        $icon = '';

        //adding page object -> http://codex.wordpress.org/Function_Reference/add_object_page
        add_object_page('LowGravity Pods', 'LG Pods', self::PERMISSIONS, self::MENU_SLUG, array('LGPodsAdmin', 'display_info_page'), $icon);

        //in order to not duplicate top menu - first child menu have the same slug as parent
        //http://codex.wordpress.org/Function_Reference/add_submenu_page
        add_submenu_page(self::MENU_SLUG, 'General Information', 'General Information', self::PERMISSIONS, self::MENU_SLUG, array('LGPodsAdmin', 'display_info_page'));

        //genres submenu
        add_submenu_page(self::MENU_SLUG, 'Genres', 'Genres', self::PERMISSIONS, 'lg-genres', array('LGPodsAdmin', 'display_genres_page'));

        //authors submenu
        add_submenu_page(self::MENU_SLUG, 'Authors', 'Authors', self::PERMISSIONS, 'lg-authors', array('LGPodsAdmin', 'display_authors_page'));

        //books submenu
        add_submenu_page(self::MENU_SLUG, 'Books', 'Books', self::PERMISSIONS, 'lg-books', array('LGPodsAdmin', 'display_books_page'));

    }

    public static function display_info_page() {

    	//You can do various stuff here - just an example

        echo '<h2>General guidelines</h2>
        	<p>You can display various informations in here like plugin usage guidelines, copyrights or even add few options to manage - its up to You</p>';
    }

    public static function display_genres_page() {

    	//initialize pods
        $object = pods('genres');

        //for this pod type we will use all available fields
        $fields = array();
        foreach($object->fields as $field => $data) {
            $fields[$field] = array('label' => $data['label']);
        }       

        //adding few basic parameters
        $object->ui = array(
            'item'   => 'genre',
            'items'  => 'genres',
            'fields' => array(
                'add'       => $fields,
                'edit'      => $fields,
                'duplicate' => $fields,
                'manage'    => $fields,
            ),
        );         

        //pass parameters
        pods_ui($object);
    }

    public static function display_authors_page() {
        //initialize pods
        $object = pods('authors');

        //for this pod type we will also use all available fields
        $fields = array();
        foreach($object->fields as $field => $data) {
            $fields[$field] = array('label' => $data['label']);
        }       

        //adding few basic parameters
        $object->ui = array(
            'item'   => 'author',
            'items'  => 'authors',
            'fields' => array(
                'add'       => $fields,
                'edit'      => $fields,
                'duplicate' => $fields,
                'manage'    => $fields,
            ),
        );         

        //pass parameters
        pods_ui($object);
    }

    public static function display_books_page() {
        $object = pods('books');

        //simple dynamic description functionality - just an idea
        $stock_desc = '';
        if(isset($_GET['action']) AND isset($_GET['id']) AND $_GET['action'] == 'edit') {
        	$stock_desc = 'According to ERP software currently we have <strong>'. self::get_erp_stock($_GET['id']) .'</strong> books on stock';
        } 

        //fields on add / edit screen
        $fields = array(
        	'name',
        	'permalink',
        	'book_author',
        	'book_genre',
        	'stock' => array ('description' => $stock_desc),
        );

        //fields for manage screen
        $manage_fields = array(
        	'name',
        	'book_author',
        	'book_genre',
        	'stock', 
        );

        //adding few basic parameters
        $object->ui = array(
            'item'   => 'book',
            'items'  => 'books',
            'fields' => array(
                'add'       => $fields,
                'edit'      => $fields,
                'duplicate' => $fields,
                'manage'    => $manage_fields,
            ),
            //fields we want to filter
            'filters' => array(
            	'book_author', 'book_genre', 'created'
            ),
            //we need to enable enhanced filters
           'filters_enhanced' => true,

            //views are not working fully yet but lets implement them just to give you basic idea what they can be used for
            'views' => array(
		        'newest' => 'Show recent ones',
		        'no-stock' => 'Out of stock',
		    )

        );         

        pods_ui($object);
    }

    public static function get_erp_stock($book_id) {

    	//some fake function which "connects" to external source of data and gets the quantity for us
    	return rand(0,100);

    }

}