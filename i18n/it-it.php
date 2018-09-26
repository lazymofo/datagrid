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
$this->delete_confirm      = 'Sei sicuro di voler eliminare questo record?';
$this->update_grid_confirm = 'Sei sicuro di voler eliminare [count] record?';

// validation general error 
$this->validate_text_general = "Inserimento Mancante o Invalido";

// form buttons
$this->form_add_button    = "<input type='submit' value='Aggiungi' class='lm_button'>";
$this->form_update_button = "<input type='submit' value='Aggiorna' class='lm_button'>"; 
$this->form_back_button   = "<input type='button' value='&lt; Indietro' class='lm_button dull' onclick='_back();'>";
$this->form_delete_button = "<input type='button' value='Elimina' class='lm_button error' onclick='_delete();'>"; 

// titles in the <th> of top of the edit form 
$this->form_text_title_add    = 'Aggiungi Record';   
$this->form_text_title_edit   = 'Modifica Record';
$this->form_text_record_saved = 'Record Salvato';
$this->form_text_record_added = 'Record Aggiunto';

// links on grid
$this->grid_add_link    = "<a href='[script_name]action=edit&amp;[qs]' class='lm_grid_add_link'>Aggiungi un Record</a>";
$this->grid_edit_link   = "<a href='[script_name]action=edit&amp;[identity_name]=[identity_id]&amp;[qs]'>[modifica]</a>";
$this->grid_delete_link = "<a href='#' onclick='return _delete(\"[identity_id]\");'>[elimina]</a>";
$this->grid_export_link = "<a href='[script_name]_export=1&amp;[qs]' title='Download CSV'>Esporta</a>";

// search box
$this->grid_search_box = "
<form action='[script_name]' class='lm_search_box'>
    <input type='text' name='_search' value='[_search]' size='20' class='lm_search_input'>
    <a href='[script_name]' style='margin: 0 10px 0 -20px; display: inline-block;' title='Pulisci Ricerca'>x</a> <!-- this title attribute may be localized -->
    <input type='submit' class='lm_button lm_search_button' value='Cerca'> <!-- this value attribute may be localized --> 
    <input type='hidden' name='action' value='search'>[query_string_list]
</form>"; 


// grid messages
$this->grid_text_record_added     = "Record Aggiunto";
$this->grid_text_changes_saved    = "Modifiche salvate";
$this->grid_text_record_deleted   = "Record Eliminato";
$this->grid_text_save_changes     = "Salva Modifiche";
$this->grid_text_delete           = "Elimina";
$this->grid_text_no_records_found = "Nessun record trovato";

// pagination text
$this->pagination_text_use_paging = 'usa la paginazione';
$this->pagination_text_show_all   = 'mostra tutti';
$this->pagination_text_records    = 'Record';
$this->pagination_text_go         = 'Vai';
$this->pagination_text_page       = 'Pagina';
$this->pagination_text_of         = 'di';
$this->pagination_text_next       = 'Successivo&gt;';
$this->pagination_text_back       = '&lt;Precedente';

// delete upload link text
$this->text_delete_image = 'elimina immagine';
$this->text_delete_document = 'elimina documento';

// relative paths for --image or --document uploads
// paths are created at runtime as needed
$this->upload_path = 'uploads';            // required when using  input types
$this->thumb_path = 'thumbs';              // optional, leave blank if you don't need thumbnails

// output date formats
$this->date_out = 'd/m/Y';
$this->datetime_out = 'd/m/Y h:i A';

