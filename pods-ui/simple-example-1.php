<?php
$object = pods('name_of_pod');
$fields = array();

//iterate through registered fields
foreach($object->fields as $field => $data) {
	$fields[$field] = array('label' => $data['label']);
}

//if we want to have all fields but don't show particular one
unset($fields['field_name']);

//if we want to alter parameters for particular field
$fields['field_name'] = array( 'label' => 'some_different_label');

//if we want to hide some fields on edit screen but still have them on add screen
$edit_fields = $fields;
unset($edit_fields['field_name']);

//fields visible on manage screens
$manage_fields = array('few', 'manage', 'fields');

$object->ui = array(
    'fields' => array(
        'add' => $fields,
        'edit' => $edit_fields,
        'manage' => $your_manage_fields,
    ),
    //other parameters
);

pods_ui($object);
