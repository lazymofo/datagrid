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
$this->delete_confirm      = 'Weet je zeker dat je dit record wilt verwijderen?';
$this->update_grid_confirm = 'Weet je zeker dat je [count] record(s) wilt verwijderen?';

// validation general error 
$this->validate_text_general = "Ontbrekende of onjuiste input";

// form buttons
$this->form_add_button    = "<input type='submit' value='Voeg toe' class='lm_button'>";
$this->form_update_button = "<input type='submit' value='Werk bij' class='lm_button'>"; 
$this->form_back_button   = "<input type='button' value='&lt; Terug/annuleer' class='lm_button dull' onclick='_back();'>";
$this->form_delete_button = "<input type='button' value='Verwijder' class='lm_button error' onclick='_delete();'>"; 

// titles in the <th> of top of the edit form 
$this->form_text_title_add    = 'Record toevoegen';   
$this->form_text_title_edit   = 'Record wijzigen';
$this->form_text_record_saved = 'Record opgeslagen';
$this->form_text_record_added = 'Record toegevoegd';

// links on grid
$this->grid_add_link    = "<a href='[script_name]action=edit&amp;[qs]' class='lm_grid_add_link'>Voeg een record toe</a>";
$this->grid_edit_link   = "<a href='[script_name]action=edit&amp;[identity_name]=[identity_id]&amp;[qs]'>[Wijzig]</a>";
$this->grid_delete_link = "<a href='#' onclick='return _delete(\"[identity_id]\");'>[Verwijder]</a>";
$this->grid_export_link = "<a href='[script_name]_export=1&amp;[qs]' title='Download CSV'>Exporteren</a>";

// search box
$this->grid_search_box = "
<form action='[script_name]' class='lm_search_box'>
    <input type='text' name='_search' value='[_search]' size='20' class='lm_search_input'>
    <a href='[script_name]' style='margin: 0 10px 0 -20px; display: inline-block;' title='Wis input'>x</a> <!-- this title attribute may be localized -->
    <input type='submit' class='lm_button lm_search_button' value='Zoek'> <!-- this value attribute may be localized --> 
    <input type='hidden' name='action' value='search'>[query_string_list]
</form>"; 


// grid messages
$this->grid_text_record_added     = "Record toegevoegd";
$this->grid_text_changes_saved    = "Wijzigingen opgeslagen";
$this->grid_text_record_deleted   = "Record verwijderd";
$this->grid_text_save_changes     = "Sla wijzigingen op";
$this->grid_text_delete           = "Verwijder";
$this->grid_text_no_records_found = "Geen records gevonden";

// pagination text
$this->pagination_text_use_paging = 'Toon paginanummers';
$this->pagination_text_show_all   = 'Toon alles';
$this->pagination_text_records    = 'record(s)';
$this->pagination_text_go         = 'Ga';
$this->pagination_text_page       = 'Pagina';
$this->pagination_text_of         = 'van';
$this->pagination_text_next       = 'Volgende&gt;';
$this->pagination_text_back       = '&lt;Terug';

// delete upload link text
$this->text_delete_image = 'Verwijder afbeelding';
$this->text_delete_document = 'Verwijder document';

// relative paths for --image or --document uploads
// paths are created at runtime as needed
$this->upload_path = 'uploads';            // required when using  input types
$this->thumb_path = 'thumbs';              // optional, leave blank if you don't need thumbnails

// output date formats
$this->date_out = 'd-m-Y';
$this->datetime_out = 'd-m-Y h:i A';

