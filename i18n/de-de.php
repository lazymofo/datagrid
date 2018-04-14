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
$this->delete_confirm      = 'Sind Sie sicher, dass Sie diesen Eintrag löschen möchten?';
$this->update_grid_confirm = 'Sind Sie sicher, dass Sie diese [count] Einträge löschen möchten?';

// validation general error 
$this->validate_text_general = "Fehlender oder ungültiger Eintrag";

// form buttons
$this->form_add_button    = "<input type='submit' value='Hinzufügen' class='lm_button'>";
$this->form_update_button = "<input type='submit' value='Aktualisieren' class='lm_button'>"; 
$this->form_back_button   = "<input type='button' value='&lt; Zurück' class='lm_button dull' onclick='_back();'>";
$this->form_delete_button = "<input type='button' value='Löschen' class='lm_button error' onclick='_delete();'>"; 

// titles in the <th> of top of the edit form 
$this->form_text_title_add    = 'Eintrag hinzufügen';   
$this->form_text_title_edit   = 'Eintrag bearbeiten';
$this->form_text_record_saved = 'Eintrag gespeichert';
$this->form_text_record_added = 'Eintrag hinzugefügt';

// links on grid
$this->grid_add_link    = "<a href='[script_name]action=edit&amp;[qs]' class='lm_grid_add_link'>Neuer Eintrag</a>";
$this->grid_edit_link   = "<a href='[script_name]action=edit&amp;[identity_name]=[identity_id]&amp;[qs]'>[ändern]</a>";
$this->grid_delete_link = "<a href='#' onclick='return _delete(\"[identity_id]\");'>[löschen]</a>";
$this->grid_export_link = "<a href='[script_name]_export=1&amp;[qs]' title='CSV herunterladen'>Exportieren</a>";

// search box
$this->grid_search_box = "
<form action='[script_name]' class='lm_search_box'>
    <input type='text' name='_search' value='[_search]' size='20' class='lm_search_input'>
    <a href='[script_name]' style='margin: 0 10px 0 -20px; display: inline-block;' title='Suche zurücksetzen'>x</a>
    <input type='submit' class='lm_button lm_search_button' value='Suche'>
    <input type='hidden' name='action' value='search'>[query_string_list]
</form>"; 


// grid messages
$this->grid_text_record_added     = "Eintrag hinzugefügt";
$this->grid_text_changes_saved    = "Änderungen gespeichert";
$this->grid_text_record_deleted   = "Eintrag gelöscht";
$this->grid_text_save_changes     = "Änderungen speichern";
$this->grid_text_delete           = "Löschen";
$this->grid_text_no_records_found = "Keine Einträge gefunden";

// pagination text
$this->pagination_text_use_paging = 'use paging';
$this->pagination_text_show_all   = 'alle anzeigen';
$this->pagination_text_records    = 'Einträge'; // singular: "Eintrag", looks better than "Eintrag/Einträge"
$this->pagination_text_go         = 'aufrufen'; // not the best translation, but no better idea
$this->pagination_text_page       = 'Seite';
$this->pagination_text_of         = 'von';
$this->pagination_text_next       = 'Nächste&gt;';
$this->pagination_text_back       = '&lt;Vorherige';

// delete upload link text
$this->text_delete_image = 'Bild löschen';
$this->text_delete_document = 'Dokument löschen';

// relative paths for --image or --document uploads
// paths are created at runtime as needed
$this->upload_path = 'uploads';            // required when using  input types
$this->thumb_path = 'thumbs';              // optional, leave blank if you don't need thumbnails

// output date formats
$this->date_out = 'd.m.Y';
$this->datetime_out = 'd.m.Y, H:i';

