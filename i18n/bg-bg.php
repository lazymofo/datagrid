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
$this->delete_confirm      = 'Сигурни ли сте, че искате да изтриете този запис?';
$this->update_grid_confirm = 'Сигурни ли сте, че искате да изтриете [count] запис(а)?';

// validation general error 
$this->validate_text_general = "Липсва или е грешно въведено";

// form buttons
$this->form_add_button    = "<input type='submit' value='Добави' class='lm_button'>";
$this->form_update_button = "<input type='submit' value='Обнови' class='lm_button'>"; 
$this->form_back_button   = "<input type='button' value='&lt; Назад' class='lm_button dull' onclick='_back();'>";
$this->form_delete_button = "<input type='button' value='Изтрий' class='lm_button error' onclick='_delete();'>"; 

// titles in the <th> of top of the edit form 
$this->form_text_title_add    = 'Нов запис';   
$this->form_text_title_edit   = 'Промяна на запис';
$this->form_text_record_saved = 'Записът е запомнен';
$this->form_text_record_added = 'Записът е добавен';

// links on grid
$this->grid_add_link    = "<a href='[script_name]action=edit&amp;[qs]' class='lm_grid_add_link'>Нов запис</a>";
$this->grid_edit_link   = "<a href='[script_name]action=edit&amp;[identity_name]=[identity_id]&amp;[qs]'>[промяна]</a>";
$this->grid_delete_link = "<a href='#' onclick='return _delete(\"[identity_id]\");'>[изтриване]</a>";
$this->grid_export_link = "<a href='[script_name]_export=1&amp;[qs]' title='Свали CSV'>Експорт CSV</a>";

// search box
$this->grid_search_box = "
<form action='[script_name]' class='lm_search_box'>
    <input type='text' name='_search' value='[_search]' size='20' class='lm_search_input'>
    <a href='[script_name]' style='margin: 0 10px 0 -20px; display: inline-block;' title='Изчисти'>x</a> <!-- this title attribute may be localized -->
    <input type='submit' class='lm_button lm_search_button' value='Търси'> <!-- this value attribute may be localized --> 
    <input type='hidden' name='action' value='search'>[query_string_list]
</form>"; 


// grid messages
$this->grid_text_record_added     = "Записът е добавен";
$this->grid_text_changes_saved    = "Промените са запомнени";
$this->grid_text_record_deleted   = "Записът е изтрит";
$this->grid_text_save_changes     = "Запомни промените";
$this->grid_text_delete           = "Изтрий";
$this->grid_text_no_records_found = "Няма намерен запис(и)";

// pagination text
$this->pagination_text_use_paging = 'на страници';
$this->pagination_text_show_all   = 'покажи всички';
$this->pagination_text_records    = 'Запис(а)';
$this->pagination_text_go         = 'Отиди на';
$this->pagination_text_page       = 'Страница';
$this->pagination_text_of         = 'от';
$this->pagination_text_next       = 'Напред&gt;';
$this->pagination_text_back       = '&lt;Назад';

// delete upload link text
$this->text_delete_image = 'изтрий изображението';
$this->text_delete_document = 'изтрий документа';

// relative paths for --image or --document uploads
// paths are created at runtime as needed
$this->upload_path = 'uploads';            // required when using  input types
$this->thumb_path = 'thumbs';              // optional, leave blank if you don't need thumbnails

// output date formats
$this->date_out = 'Y/m/d';
$this->datetime_out = 'Y/m/d H:i'; //'d.m.Y, H:i';
