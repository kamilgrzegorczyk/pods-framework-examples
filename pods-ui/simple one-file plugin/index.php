<?php
/*
Plugin Name: Very simple PODS framework UI management plugin
Plugin URI: http://lowgravity.pl
Description:  Manages PODS UI functionalities
Author: Kamil Grzegorczyk
Version: 1.0
Author URI: http://lowgravity.pl
*/

function initialize_admin () {

	//set Your icon URL here
    $icon = '';

    //adding page object -> http://codex.wordpress.org/Function_Reference/add_object_page
    add_object_page('LowGravity Pods', 'LG Pods', 'manage_options', 'lg-pods', 'display_info_page', $icon);

    //in order to not duplicate top menu - first child menu have the same slug as parent
    //http://codex.wordpress.org/Function_Reference/add_submenu_page
    add_submenu_page('lg-pods', 'General Information', 'General Information', 'manage_options', 'lg-pods', 'display_info_page');

    //authors submenu
    add_submenu_page('lg-pods', 'Authors', 'Authors', 'manage_options', 'lg-authors', 'display_authors_page');

    //books submenu
    add_submenu_page('lg-pods', 'Books', 'Books', 'manage_options', 'lg-books', 'display_books_page');

}

function display_info_page() {
	//You can do various stuff here - just an example
    echo '<h2>General guidelines</h2>
    	<p>You can display various informations in here like plugin usage guidelines, copyrights or even add few options to manage - its up to You</p>';
}

function display_authors_page() {
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

function display_books_page() {
    $object = pods('books');

    //for this pod type we will also use all available fields
    $fields = array();
    foreach($object->fields as $field => $data) {
        $fields[$field] = array('label' => $data['label']);
    }  

    //adding few basic parameters
    $object->ui = array(
        'item'   => 'book',
        'items'  => 'books',
        'fields' => array(
            'add'       => $fields,
            'edit'      => $fields,
            'duplicate' => $fields,
            'manage'    => $fields,
        ),
    );         

    pods_ui($object);
}

function inform_my_friends($pieces) {

    //array with names and email adressses
    $friends_array = array(
			'Kamil' => 'kgrzegorczyk@lowgravity.pl',
			//'Johnny' => 'misterj@supercooldomain.com',
			//'Allen' => 'allen@supercooldomain.com',
		);

    //Default subject and message
	$subject = 'New book has just been added';
	$message = 'Hey %s, we just added a new book - %s  by %s. Check this out!';
    $book_title = $book_author = NULL;

    //we have to fetch that record if we want to add infomration to the email
    $book_data = pods('books', $pieces['params']->id);  

    while( $book_data->fetch() ) {

        $book_title = $book_data->field( 'name' );
        $book_author = $book_data->field( 'book_author' );
        $book_author = $book_author['name'];

    }

    //would you like to see what fields are available for you? Just uncomment this line below and retrieve them from email
    //$message .= '<pre>' . print_r($book_data, true) . '</pre>';

    //send emails to each of our friends
	foreach($friends_array as $friend_name => $friend_email) {
		wp_mail( $friend_email, $subject, sprintf($message, $friend_name, $book_title, $book_author));
	}
}

add_action('admin_menu','initialize_admin');

//hiding 'pods' menu from admin sidebar
//If we are building our own UI then it would be good to hide that
add_filter( 'pods_admin_menu_secondary_content', '__return_false' ); 

//Inform our friends each time the book is created
//if you want to send email on each save:
//add_filter('pods_api_post_save_pod_item_books', 'inform_my_friends', 10, 1);
add_filter('pods_api_post_create_pod_item_books', 'inform_my_friends', 10, 1);