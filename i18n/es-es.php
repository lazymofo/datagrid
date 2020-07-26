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
$this->delete_confirm      = '¿Estás seguro de que quieres eliminar el registro?';
$this->update_grid_confirm = '¿Estás seguro de que quieres eliminar el registro [count]?';

// validation general error 
$this->validate_text_general = "Inserimento Mancante o Invalido";

// form buttons
$this->form_add_button    = "<input type='submit' value='Añadir' class='lm_button'>";
$this->form_update_button = "<input type='submit' value='Actualizar' class='lm_button'>"; 
$this->form_back_button   = "<input type='button' value='Atrás' class='lm_button dull' onclick='_back();'>";
$this->form_delete_button = "<input type='button' value='Eliminar' class='lm_button error' onclick='_delete();'>"; 

// titles in the <th> of top of the edit form 
$this->form_text_title_add    = 'Añadir registro';   
$this->form_text_title_edit   = 'Modificar registro';
$this->form_text_record_saved = 'Registro guardado';
$this->form_text_record_added = 'Registro añadido';

// links on grid
$this->grid_add_link    = "<a href='[script_name]action=edit&amp;[qs]' class='lm_grid_add_link'>Añadir un registro</a>";
$this->grid_edit_link   = "<a href='[script_name]action=edit&amp;[identity_name]=[identity_id]&amp;[qs]'>[modifica]</a>";
$this->grid_delete_link = "<a href='#' onclick='return _delete(\"[identity_id]\");'>[elimina]</a>";
//$this->grid_edit_link   = "<a href='[script_name]action=edit&amp;[identity_name]=[Id]&amp;[qs]'>[modifica]</a>";
//$this->grid_delete_link = "<a href='#' onclick='return _delete(\"[Id]\");'>[elimina]</a>";
$this->grid_export_link = "<a href='[script_name]_export=1&amp;[qs]' title='Download CSV'>Exportar</a>";

// search box
$this->grid_search_box = "
<form action='[script_name]' class='lm_search_box'>
    <input type='text' name='_search' value='[_search]' size='20' class='lm_search_input'>
    <a href='[script_name]' style='margin: 0 10px 0 -20px; display: inline-block;' title='Borrar búsqueda'>x</a> <!-- this title attribute may be localized -->
    <input type='submit' class='lm_button lm_search_button' value='Buscar'> <!-- this value attribute may be localized --> 
    <input type='hidden' name='action' value='search'>[query_string_list]
</form>"; 


// grid messages
$this->grid_text_record_added     = "Registro añadido";
$this->grid_text_changes_saved    = "Modificación guardada";
$this->grid_text_record_deleted   = "Registro eliminado";
$this->grid_text_save_changes     = "Guardar cambios";
$this->grid_text_delete           = "Eliminar";
$this->grid_text_no_records_found = "No se han encontrado registros";

// pagination text
$this->pagination_text_use_paging = 'usar la paginación';
$this->pagination_text_show_all   = 'mostrar todo';
$this->pagination_text_records    = 'Registro';
$this->pagination_text_go         = 'Ir a';
$this->pagination_text_page       = 'Pagina';
$this->pagination_text_of         = 'de';
$this->pagination_text_next       = 'Siguiente&gt;';
$this->pagination_text_back       = '&lt;Anterior';

// delete upload link text
$this->text_delete_image = 'eliminar imagen';
$this->text_delete_document = 'eliminar documento';

// relative paths for --image or --document uploads
// paths are created at runtime as needed
$this->upload_path = 'uploads';            // required when using  input types
$this->thumb_path = 'thumbs';              // optional, leave blank if you don't need thumbnails

// output date formats
$this->date_out = 'Y/m/d';
$this->datetime_out = 'Y/m/d H:i:s';

