<?php
/*
 * LazyMofo Data Grid
 * http://lazymofo.wdschools.com/
 * License: MIT
 * 
 * localization: pt-br - Brazilian Portuguese
 * License: MIT
 * Version: 2017-09-25
 * 
 * Contributor: Fabio Cordeiro - fabio@2f.com.br
 */

//Official Brazilian Time
$this->timezone = 'UTC-3';                         // if no timezone is set in the application, then this timezone is set for strtotime. http://php.net/manual/en/timezones.others.php

//Brazilian and European format
$this->date_in = 'Y-m-d';                        // input format into database, no need to change this
$this->datetime_in = 'Y-m-d H:i:s';              

$this->date_out = 'd/m/Y';                       // output date
$this->datetime_out = 'd/m/Y H:i';             // output datetime

$this->validate_text_general = "Conteúdo incompleto ou inválido"; // generic message displayed at the top when validation error occurs, optional

$this->delete_confirm      = 'Tem certeza para excluir este registro?';       // javascript popup confirmation
$this->update_grid_confirm = 'Tem certeza para excluir [count] registro(s)?'; // javascript popup confirmation when deleting on the grid

$this->form_add_button    = "<input type='submit' value='Adicionar' class='lm_button'>";
$this->form_update_button = "<input type='submit' value='Alterar' class='lm_button'>"; 
$this->form_back_button   = "<input type='button' value='&lt; Volar' class='lm_button dull' onclick='_back();'>"; // use type=button for delete and cancel so form presses the right button with enter key
$this->form_delete_button = "<input type='button' value='Excluir' class='lm_button error' onclick='_delete();'>"; 
//2f alterar original
$this->form_duplicate_button = "<input type='button' value='Duplicar' class='lm_button'>"; 
$this->form_duplicate_button = "<input type='button' value='Duplicar' class='lm_button' onclick='_duplicate();'>"; 

$this->form_text_title_add    = 'Novo';   // titles in the <th> of top of the edit form 
$this->form_text_title_edit   = 'Alterar';
$this->form_text_record_saved = 'Salvo'; // customize success messages
$this->form_text_record_added = 'Adicionado';


$this->grid_add_link    = "<a href='[script_name]action=edit&amp;[qs]' class='lm_grid_add_link'>Adicionar Novo</a>";  // link at displayed at the top to add a new record. [script_name] placeholder  will be populated by grid()
$this->grid_edit_link   = "<a href='[script_name]action=edit&amp;[identity_name]=[identity_id]&amp;[qs]'>[alterar]</a>"; // note special [identity_name] and [identity_id] placeholders that will be populated by grid()
$this->grid_delete_link = "<a href='#' onclick='return _delete(\"[identity_id]\");'>[excluir]</a>";
$this->grid_export_link = "<a href='[script_name]_export=1&amp;[qs]' title='Download CSV'>Exportar</a>";

$this->grid_search_box = "<form action='[script_name]' class='lm_search_box'><input type='text' name='_search' value='[_search]' size='20' class='lm_search_input'><a href='[script_name]' style='margin: 0 10px 0 -20px; display: inline-block;' title='Limpar Busca'>x</a><input type='submit' value='Buscar' class='lm_button lm_search_button'><input type='hidden' name='action' value='search'>[query_string_list]</form>"; 

$this->grid_text_record_added     = "Adicionado";
$this->grid_text_changes_saved    = "Salvo";
$this->grid_text_record_deleted   = "Excluído";
$this->grid_text_save_changes     = "Salvo";
$this->grid_text_delete           = "Excluído";
$this->grid_text_no_records_found = "Não Encontrado";

$this->pagination_text_use_paging = '[use paging]';
$this->pagination_text_show_all   = '[show all]';
$this->pagination_text_records    = 'Linha(s)';
$this->pagination_text_go         = 'Ir';
$this->pagination_text_page       = 'Página';
$this->pagination_text_of         = 'de';
$this->pagination_text_next       = 'Proximo&gt;';
$this->pagination_text_back       = '&lt;Voltar';

$this->export_separator = ';';           // separator for csv export

