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
$this->delete_confirm      = 'Er du sikker på du vil slette denne række?';
$this->update_grid_confirm = 'Er du sikker på du vil slette [count] række(r)?';

// validation general error 
$this->validate_text_general = "Manglende oplysninger eller fejl i input";

// form buttons
$this->form_add_button    = "<input type='submit' value='Tilføj' class='lm_button'>";
$this->form_update_button = "<input type='submit' value='Opdatér' class='lm_button'>"; 
$this->form_back_button   = "<input type='button' value='&lt; Tilbage' class='lm_button dull' onclick='_back();'>";
$this->form_delete_button = "<input type='button' value='Slet' class='lm_button error' onclick='_delete();'>"; 

// titles in the <th> of top of the edit form 
$this->form_text_title_add    = 'Tilføj Række';   
$this->form_text_title_edit   = 'Ret Række';
$this->form_text_record_saved = 'Række gemt';
$this->form_text_record_added = 'Række tilføjet';

// links on grid
$this->grid_add_link    = "<a href='[script_name]action=edit&amp;[qs]' class='lm_grid_add_link'>Tilføj række</a>";
$this->grid_edit_link   = "<a href='[script_name]action=edit&amp;[identity_name]=[identity_id]&amp;[qs]'>[redigere]</a>";
$this->grid_delete_link = "<a href='#' onclick='return _delete(\"[identity_id]\");'>[slette]</a>";
$this->grid_export_link = "<a href='[script_name]_export=1&amp;[qs]' title='Download CSV'>Eksportér</a>";

// search box
$this->grid_search_box = "
<form action='[script_name]' class='lm_search_box'>
    <input type='text' name='_search' value='[_search]' size='20' class='lm_search_input'>
    <a href='[script_name]' style='margin: 0 10px 0 -20px; display: inline-block;' title='Ryd Søg'>x</a> <!-- this title attribute may be localized -->
    <input type='submit' class='lm_button lm_search_button' value='Søg'> <!-- this value attribute may be localized --> 
    <input type='hidden' name='action' value='search'>[query_string_list]
</form>"; 


// grid messages
$this->grid_text_record_added     = "Række tilføjet";
$this->grid_text_changes_saved    = "Rettelse gemt";
$this->grid_text_record_deleted   = "Række slettet";
$this->grid_text_save_changes     = "Gem ændringer";
$this->grid_text_delete           = "Slet";
$this->grid_text_no_records_found = "Imgen rækker fundet";

// pagination text
$this->pagination_text_use_paging = 'use paging';
$this->pagination_text_show_all   = 'Vis alle';
$this->pagination_text_records    = 'Række(r)';
$this->pagination_text_go         = 'Start';
$this->pagination_text_page       = 'Side';
$this->pagination_text_of         = 'af';
$this->pagination_text_next       = 'Næste&gt;';
$this->pagination_text_back       = '&lt;Tilbage';

// delete upload link text
$this->text_delete_image = 'slet billede';
$this->text_delete_document = 'slet dokument';

// relative paths for --image or --document uploads
// paths are created at runtime as needed
$this->upload_path = 'uploads';            // required when using  input types
$this->thumb_path = 'thumbs';              // optional, leave blank if you don't need thumbnails

// output date formats
$this->date_out = 'Y-m-d';
$this->datetime_out = 'Y-m-d H:i';

