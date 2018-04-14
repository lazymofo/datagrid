<?php
/*
Thanks to RenZo for this translation
*/

// javascript dialogs
$this->delete_confirm      = 'Etes-vous sûr de vouloir supprimer cette entrée?';
$this->update_grid_confirm = 'Etes-vous sûr de vouloir supprimer [count] entrée(s)?';

// validation general error 
$this->validate_text_general = "Entrée manquante ou invalide";

// form buttons
$this->form_add_button    = "<input type='submit' value='Ajouter' class='lm_button'>";
$this->form_update_button = "<input type='submit' value='Enregistrer' class='lm_button'>"; 
$this->form_back_button   = "<input type='button' value='&lt; Retour' class='lm_button dull' onclick='_back();'>";
$this->form_delete_button = "<input type='button' value='Supprimer' class='lm_button error' onclick='_delete();'>"; 

// titles in the <th> of top of the edit form
$this->form_text_title_add    = 'Ajout';
$this->form_text_title_edit   = 'Edition';
$this->form_text_record_saved = 'Entrée modifiée';
$this->form_text_record_added = 'Entrée ajoutée';

// links on grid
$this->grid_add_link    = "<a href='[script_name]action=edit&amp;[qs]' class='lm_grid_add_link'>Ajouter</a>";
$this->grid_edit_link   = "<a href='[script_name]action=edit&amp;[identity_name]=[identity_id]&amp;[qs]'>[editer]</a>";
$this->grid_delete_link = "<a href='#' onclick='return _delete(\"[identity_id]\");'>[supprimer]</a>";
$this->grid_export_link = "<a href='[script_name]_export=1&amp;[qs]' title='Download CSV'>Export</a>";

// search box
$this->grid_search_box = "
<form action='[script_name]' class='lm_search_box'>
    <input type='text' name='_search' value='[_search]' size='20' class='lm_search_input'>
    <a href='[script_name]' style='margin: 0 10px 0 -20px; display: inline-block;' title='Clear Search'>x</a> <!-- this title attribute may be localized -->
    <input type='submit' class='lm_button lm_search_button' value='Rechercher'> <!-- this value attribute may be localized --> 
    <input type='hidden' name='action' value='search'>[query_string_list]
</form>"; 


// grid messages
$this->grid_text_record_added     = "Entrée ajoutée";
$this->grid_text_changes_saved    = "Modifications enregistrées";
$this->grid_text_record_deleted   = "Entrée supprimée";
$this->grid_text_save_changes     = "Enregistrer";
$this->grid_text_delete           = "Supprimer";
$this->grid_text_no_records_found = "Aucune entrée trouvée";

// pagination text
$this->pagination_text_use_paging = 'utiliser la pagination';
$this->pagination_text_show_all   = 'montrer tout';
$this->pagination_text_records    = 'Entrée(s)';
$this->pagination_text_go         = 'Aller';
$this->pagination_text_page       = 'Page';
$this->pagination_text_of         = 'sur';
$this->pagination_text_next       = 'Suivant&gt;';
$this->pagination_text_back       = '&lt;Précédent';

// delete upload link text
$this->text_delete_image = 'supprimer image';
$this->text_delete_document = 'supprimer document';

// relative paths for --image or --document uploads
// paths are created at runtime as needed
$this->upload_path = 'uploads';            // required when using  input types
$this->thumb_path = 'thumbs';              // optional, leave blank if you don't need thumbnails

// output date formats
$this->date_out = 'd/m/Y';
$this->datetime_out = 'd/m/Y h:i A';

