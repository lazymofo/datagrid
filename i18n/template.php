<?php
/*
Instructions:

- To contribute a localization file populate the variables below with standards of your language + country
- For HTML inputs, only edit the value= attribute, but not if the value contains a [placeholder]
- Don't edit [placeholders]
- Name the file in the following format: 2letterlanguage-2lettercountry.php, for example en-us.php

country codes: https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2
language codes: https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes

Thanks for your help!
-Ian
*/

// javascript dialogs
$this->delete_confirm      = 'Are you sure you want to delete this record?';
$this->update_grid_confirm = 'Are you sure you want to delete [count] record(s)?';

// validation general error 
$this->validate_text_general = "Missing or Invalid Input";

// form buttons
$this->form_add_button    = "<input type='submit' value='Add' class='lm_button'>";
$this->form_update_button = "<input type='submit' value='Update' class='lm_button'>"; 
$this->form_back_button   = "<input type='button' value='&lt; Back' class='lm_button dull' onclick='_back();'>";
$this->form_delete_button = "<input type='button' value='Delete' class='lm_button error' onclick='_delete();'>"; 

// titles in the <th> of top of the edit form 
$this->form_text_title_add    = 'Add Record';   
$this->form_text_title_edit   = 'Edit Record';
$this->form_text_record_saved = 'Record Saved';
$this->form_text_record_added = 'Record Added';

// links on grid
$this->grid_add_link    = "<a href='[script_name]action=edit&amp;[qs]' class='lm_grid_add_link'>Add a Record</a>";
$this->grid_edit_link   = "<a href='[script_name]action=edit&amp;[identity_name]=[identity_id]&amp;[qs]'>[edit]</a>";
$this->grid_delete_link = "<a href='#' onclick='return _delete(\"[identity_id]\");'>[delete]</a>";
$this->grid_export_link = "<a href='[script_name]_export=1&amp;[qs]' title='Download CSV'>Export</a>";

// search box
$this->grid_search_box = "
<form action='[script_name]' class='lm_search_box'>
    <input type='text' name='_search' value='[_search]' size='20' class='lm_search_input'>
    <a href='[script_name]' style='margin: 0 10px 0 -20px; display: inline-block;' title='Clear Search'>x</a> <!-- this title attribute may be localized -->
    <input type='submit' class='lm_button lm_search_button' value='Search'> <!-- this value attribute may be localized --> 
    <input type='hidden' name='action' value='search'>[query_string_list]
</form>"; 


// grid messages
$this->grid_text_record_added     = "Record Added";
$this->grid_text_changes_saved    = "Changes Saved";
$this->grid_text_record_deleted   = "Record Deleted";
$this->grid_text_save_changes     = "Save Changes";
$this->grid_text_delete           = "Delete";
$this->grid_text_no_records_found = "No Records Found";

// pagination text
$this->pagination_text_use_paging = 'use paging';
$this->pagination_text_show_all   = 'show all';
$this->pagination_text_records    = 'Record(s)';
$this->pagination_text_go         = 'Go';
$this->pagination_text_page       = 'Page';
$this->pagination_text_of         = 'of';
$this->pagination_text_next       = 'Next&gt;';
$this->pagination_text_back       = '&lt;Back';

// delete upload link text
$this->text_delete_image = 'delete image';
$this->text_delete_document = 'delete document';

// relative paths for --image or --document uploads
// paths are created at runtime as needed
$this->upload_path = 'uploads';            // required when using  input types
$this->thumb_path = 'thumbs';              // optional, leave blank if you don't need thumbnails

// output date formats
$this->date_out = 'm/d/Y';
$this->datetime_out = 'm/d/Y h:i A';

