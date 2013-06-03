<?php
//defining pods object
$object = pods('name_of_pod');

//altering pods object
$object->ui = array(

	//singular item label
	'item' 		=> 'label', //car, book

	//plural items label
	'items'     => 'label', //cars, books

	//field definitions
	'fields'    => array(
			'add'       => $add_fields_array,
			'edit'      => $edit_fields_array,
			'duplicate' => $duplicate_fields_array,
			//What columns to show on manage screen - old 'columns' parameter
			'manage'    => $manage_fields_array,
			//What columns to show on the Reorder page
			'reorder'   => $reorder_fields_array,
			//as of 2.1 export feature is not working yet
			'export' 	=> $export_fields_array,
		),

	//default sort
	'orderby' => 'column_name', // like 't.column_name DESC'

	//those fields will be independently searchable
	'filters'			=> array('field_name'),

	//action button labels
	'label'     => array(
		'add'       => 'add_label',
		'edit'      => 'edit_label',
		'duplicate' => 'delete_label',
		),

	//Enable the Reordering interface
	'reorder' => array(
		//the column name to be reordered (works best if it's a Number column type)
		'on'      => 'column_name',
		//sort column name on reordering screen
		'orderby' => 'column_name',
		),

	// user persistent settings for show_per_page, orderby, search, and filters
	// allowed: search, filters, show_per_page, orderby (priority under session)
	'user' 		=> array(
			'orderby',
			'show_per_page',
		),

	//An array of custom actions
	'actions_custom' => array(
			//A custom function to use when listing Pod Items (bypasses the Pods UI)
			'manage' => 'function_name',
			//A custom function to use when reordering Pod Items (bypasses the Pods UI)
			'reorder' => 'function_name',
			//A custom function to use when adding a Pod Item (bypasses the Pods UI)
			'add' => 'function_name',
			//A custom function to use when editing a Pod Item (bypasses the Pods UI)
			'edit' => 'function_name',
			//A custom function to use when duplicating a Pod Item (bypasses the Pods UI)
			'duplicate' => 'function_name',
			//A custom function to use when deleting a Pod Item (bypasses the Pods UI)
			'delete' => 'function_name',
			//A custom function to use when action=save in URL, useful to use when you have your own custom forms using $_POST
			'save' => 'function_name',
		),

	//Set the action to set in the URL after particular action
	'action_after' => array(
			'add'       => 'string', //default 'edit'
			'edit'      => 'string', //default 'edit'
			'duplicate' => 'string', //default 'edit'
        ),

	'action_links' => array(
			//Override the array that builds the edit link, you may supply a string with the name of a helper to get the array from - or give the array itself
			'edit'      => $edit_link,
			//Override the link used for 'View', by default it's set to use the Pods 'detail_url' setting
			'view'      => $view_link,
			//Override the link used for 'Duplicate'
			'duplicate' => $duplicate_link,
		),

	//Whether or not to show the search box above the Manage screen when listing items. Set to 'false' to turn off
	'searchable' => TRUE,

	//Whether or not to search across all fields (excluding pick fields, which you can enable in 'search_across_picks'). Set to 'false' to turn off
	'search_across' => TRUE,

	//Whether or not to search across all pick fields. Set to 'true' to turn on
	'search_accross_picks' => TRUE,

	//An array of actions to disable, if you supply 'add' and/or 'edit' it will also disable the link on the Manage screens
	'actions_disabled' => $disabled_actions_array,

	//An array of actions to hide, if you supply 'add' and/or 'edit' it will also hide the link on the Manage screens
	'actions_hidden' 	=> $hidden_actions_array,

	//which fields should be available for filtering? Like: array('pick_field_name_1', 'pick_field_name_2')
	'filters' => array('pick_field_name_1', 'pick_field_name_2'),

	//enable enhanced filters? This allows You to show new fancy enhanced select filters for pick and date fields
	'filters_enhanced' => true,

	//bulk actions - at the time of the writing(2.1) You can pass the array of bulk actions
	//at the moment this will only enable checkboxes, actions still have to be defined
	'actions_bulk' => array(
		'name_of_action'         => array(
			'label' => 'Delete everything',
		),
		'name_of_another_action' => array(
			'label' => 'Rule the world',
		),
	),

	//You can define various buttons with predefined manage views in here which will be filtered based on Your custom WHERE clause
	//at the moment (2.1) You can define views but can't define where clauses
	'views' => array(
		'view_variable_1' => 'Nice label 1',
		'view_variable_2' => 'Nice label 2',
	),
    /* Restrict example based on https://github.com/pods-framework/pods/issues/623#issuecomment-12730649
    'edit' => array(
        'relation' => 'OR', // default is AND
        // Relationship (provide traversal field to reference)
        'favorite_colors.name' => array( // must like BOTH: green and blue
            'relation' => 'AND', // default is OR
            'green',
            'blue'
        ),
        // Simple Relationship
        'hated_colors' => array( // must hate ANY of: red or yellow
            'red',
            'yellow'
        ),
        // Yes/No field
        'generally_cool' => 1 // must be generally cool
    ),
    //'field name' value has to be equal the current logged in user ID (field can be multi select and return an array of user IDs)
    'author_restrict' => 'field_name',
    */

    'restrict' => array(
        'edit' => null,
        'duplicate' => null,
        'delete' => null,
        'author_restrict' => null
    ),
);

pods_ui($object);
