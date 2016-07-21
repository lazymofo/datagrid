<?php

// php crud datagrid for mysql and php5
// MIT License - http://lazymofo.wdschools.com/
// send feedback or questions lazymofo@wdschools.com
// version 2016-07-08

class lazy_mofo{

    public $dbh = false;                    // required, pass the PDO connection object into the constructor
    public $table = '';                     // required, table for use for sql_insert(), sql_update(), sql_update_grid() and sql_delete()
    public $identity_name = '';             // required, column name of id primary key 

    public $rename = array();               // associative array of column names and friendly names. example: array('prod_id' => 'Product ID') 

    public $uri_path = '';                  // experimental - to specify URI used for WordPress admin plugins

    public $query_string_list = '';         // comma delimited list of variable names to carry around in the URL

    public $exclude_field = array();        // don't allow users to update or insert into these fields, even if data is posted. place the field name in the key of the array. example: $lm->exclude_field['is_admin'] = '';

    public $form_sql = '';                  // render form from fields retuned in sql statement. if blank then 'select * from table where identity_name = identity_id' is used. when no record is found then a blank form to ADD a record is displayed
    public $form_sql_param = array();       // associative array to bind named parameters to form_sql. use to pass in identity_id when specifiying form_sql.
    public $form_input_control = array();   // for form(), define inputs like select boxes, document uploads, etc... *info on usage below*
    public $form_default_value = array();   // for form(), define default values for columns when adding a record. if auto_populate_control = true then this array will be populated from the defaults in the database. 
    public $form_display_identity = true;   // display identity value when editing a record
    public $form_additional_html = '';      // add any addition html inside the <form> after the form buttons.
    public $form_text_input_size = 35;      // size of text inputs on form()

    public $grid_sql = '';                  // render grid with desired sql. defaults to 'select *, identity_name from table'. *important* to display [edit] and [delete] links, the identity must be the last column in the sql statement. this arangement allows grid to display data without showing the identity.
    public $grid_sql_param = array();       // associative array to bind variables to grid_sql. see php docs on PDOStatement->execute for more info.
    public $grid_default_order_by = '';     // free-form 'order by' clause. Not used if grid_sql is specified. Example: column1 desc, column2 asc
    public $grid_input_control = array();   // for grid(), define inputs like select boxes, checkboxes, etc... *info on usage below*
    public $grid_output_control = array();  // for grid(). define outputs like --email to make a clickable mailto or --document to make a link. *info on usage below*
    public $grid_multi_delete = false;      // display checkboxes on grid to allow for multiple record delete
    public $grid_show_search_box = false;   // display search field at the top - grid_sql must be altered to accomodate search
    public $grid_limit = 200;               // pagination limit number of records per page
    public $grid_repeat_header_at = 0;      // interval of records to repeat header column titles at
    public $grid_show_images = false;       // option to show images inside the grid, otherwise a link is displayed for --image type
    public $grid_ellipse_at = 30;           // limit number of characters displayed, set to 0 to disable truncation
    public $grid_text_input_size = 10;      // size of text input when input is displayed

    public $text_input_max_length_default = 0;  // global max_length attribute for input. 0 is disabled
    public $text_input_max_length = array();    // array of column names to max length integers, optional

    public $auto_populate_controls = true;      // have get_columns() populate input and output controls according to meta data for types --date, --datetime, --number and --textarea. also, populate default values.

    public $on_insert_validate = array();       // example : $lm->on_insert_validate['field_name'] = array(string $regexp_or_user_function, string $error_message[, string $tip_placeholder , boolean optional_input]); 
    public $on_update_validate = array();
    public $validate_tip_in_placeholder = true; // allow input placeholder to display validation tip
    public $validate_text_general = "Missing or Invalid Input"; // generic message displayed at the top when validation error occurs, optional

    public $on_insert_user_function = '';       // user function called before data is inserted, updated, or deleteed. return a string error message for server-side validation. Can be used to formating _POST data.
    public $on_update_user_function = '';
    public $on_delete_user_function = '';
    public $on_update_grid_user_function = '';

    public $after_insert_user_function = '';    // user function names to be called after data is inserted, updated, or deleteed.
    public $after_update_user_function = '';
    public $after_delete_user_function = '';
    public $after_update_grid_user_function = '';

    public $cast_user_function = array();       // user function for casting data, example : $lm->cast_function['field_name'] = 'my_casting_function'

    public $return_to_edit_after_insert = true; // redirect to edit screen after adding or updating a record. if false, user is sent back to grid view.
    public $return_to_edit_after_update = true; 

    public $redirect_using_js = false; // redirect to a page using java-script instead of header modification by means of PHP. 

    // upload paths                             // relative path names only! paths are created at runtime as needed
    public $upload_path = 'uploads';            // required when using --image or --document input types
    public $thumb_path = 'thumbs';              // optional, leave blank if you don't need thumbnails

    // image settings    
    public $upload_width = 400;                 // 0 height or width means no resizing or cropping
    public $upload_height = 400;
    public $upload_crop = false;                // crop versus resize: resize keeps the original aspect ratio but limits the size of the image
    public $thumb_width = 100;
    public $thumb_height = 100;
    public $thumb_crop = true;

    public $image_quality = 80;                       // image quality when resizing and cropping, 1-100
    public $image_style = "style='height: 100px;'";   // apply style to all images displayed. limiting size is nice to keep things orderly.

    public $charset_mysql = 'utf8';                   // charset for mysql communications
    public $charset = 'UTF-8';                        // charset for output

    public $timezone = 'UTC';                         // if no timezone is set in the application, then this timezone is set for strtotime. http://php.net/manual/en/timezones.others.php

    public $date_in = 'Y-m-d';                        // input format into database, no need to change this
    public $datetime_in = 'Y-m-d H:i:s';              

    // US date format
    public $date_out = 'm/d/Y';                       // output date
    public $datetime_out = 'm/d/Y h:i A';             // output datetime

    // non-US date format
    //public $date_out = 'd/m/Y';
    //public $datetime_out = 'd/m/Y h:i A';

    // ISO-ish date format, or when using html5 date input
    //public $date_out = 'Y-m-d';
    //public $datetime_out = 'Y-m-d H:i';

    public $restricted_numeric_input = '/[^0-9\.\-]/';// optional, regular expression of what numbers are allowed to be sent to the database. helpful to remove dollar signs and spaces. many non-US countries use comma instead of decimal points and spaces instead of commas.

    public $upload_allow_list = '.mp3 .jpg .jpeg .png .gif .doc .docx .xls .xlsx .txt .pdf'; // space delimted file name extentions. include period

    public $delete_confirm      = 'Are you sure you want to delete this record?';       // javascript popup confirmation
    public $update_grid_confirm = 'Are you sure you want to delete [count] record(s)?'; // javascript popup confirmation when deleting on the grid

    public $form_add_button    = "<input type='submit' value='Add' class='lm_button'>";
    public $form_update_button = "<input type='submit' value='Update' class='lm_button'>"; 
    public $form_back_button   = "<input type='button' value='&lt; Back' class='lm_button dull' onclick='_back();'>"; // use type=button for delete and cancel so form presses the right button with enter key
    public $form_delete_button = "<input type='button' value='Delete' class='lm_button error' onclick='_delete();'>"; 

    public $form_text_title_add    = 'Add Record';   // titles in the <th> of top of the edit form 
    public $form_text_title_edit   = 'Edit Record';
    public $form_text_record_saved = 'Record Saved'; // customize success messages
    public $form_text_record_added = 'Record Added';

    public $grid_add_link    = "<a href='[script_name]action=edit&amp;[qs]' class='lm_grid_add_link'>Add a Record</a>";  // link at displayed at the top to add a new record. [script_name] placeholder  will be populated by grid()
    public $grid_edit_link   = "<a href='[script_name]action=edit&amp;[identity_name]=[identity_id]&amp;[qs]'>[edit]</a>"; // note special [identity_name] and [identity_id] placeholders that will be populated by grid()
    public $grid_delete_link = "<a href='#' onclick='return _delete(\"[identity_id]\");'>[delete]</a>";
    public $grid_export_link = "<a href='[script_name]_export=1&amp;[qs]' title='Download CSV'>Export</a>";

    public $grid_search_box = "<form action='[script_name]' class='lm_search_box'><input type='text' name='_search' value='[_search]' size='20' class='lm_search_input'><a href='[script_name]' style='margin: 0 10px 0 -20px; display: inline-block;' title='Clear Search'>x</a><input type='submit' value='Search' class='lm_button lm_search_button'><input type='hidden' name='action' value='search'>[query_string_list]</form>"; 

    public $grid_text_record_added     = "Record Added";
    public $grid_text_changes_saved    = "Changes Saved";
    public $grid_text_record_deleted   = "Record Deleted";
    public $grid_text_save_changes     = "Save Changes";
    public $grid_text_delete           = "Delete";
    public $grid_text_no_records_found = "No Records Found";

    public $pagination_text_use_paging = '[use paging]';
    public $pagination_text_show_all   = '[show all]';
    public $pagination_text_records    = 'Record(s)';
    public $pagination_text_go         = 'Go';
    public $pagination_text_page       = 'Page';
    public $pagination_text_of         = 'of';
    public $pagination_text_next       = 'Next&gt;';
    public $pagination_text_back       = '&lt;Back';

    public $text_delete_image = 'delete image';
    public $text_delete_document = 'delete document';

    public $export_csv_file_name = '';
    public $export_separator = ',';           // separator for csv export
    public $export_delim = '"';               // delimiter for csv export 
    public $export_delim_escape = '"';        // if delim is used in content add this string before for escaping

    public $delim = '|'; // when using mutiple checkboxes or multipleselect, delimiter for values

    public $select_first_option_blank = true; // make first option blank on dropdown --select and --selectmultiple inputs

    private $set_names = false; 


    function __construct($dbh){

        if(!$dbh)
            die('Pass in a PDO object connected to the mysql database.');

        if(!(get_magic_quotes_gpc() == 0) && (get_magic_quotes_runtime() == 0))
            echo('Warning: lazy mofo requires magic_quotes be disabled.');

        $this->dbh = $dbh; 

        $timezone = @date_default_timezone_get();
        if($timezone == '' || $timezone == 'UTC')
            date_default_timezone_set($this->timezone);

        // avoid notices for this noonce token
        if(!isset($_SESSION['_csrf']))
            $_SESSION['_csrf'] = '';

    }

    
    function run(){

        // purpose: built-in controller 

        switch($this->get_action()){
            case "edit":          $this->edit();        break;
            case "insert":        $this->insert();      break;
            case "update":        $this->update();      break;
            case "update_grid":   $this->update_grid(); break;
            case "delete":        $this->delete();      break;
            default:              $this->index();
        }

    }

    
    function edit($error = ''){

        // purpose: called from contoller to display form() and add or edit a record

        echo $this->form($error);

    }


    function insert(){

        // purpose: called from contoller to display insert() data
        
        $error = '';

        // validation system
        $is_valid = $this->validate($this->on_insert_validate);
        if(!$is_valid)
            $error = $this->validate_text_general; //optional general error at the top

        // call user function to validate or whatever
        if($is_valid && $this->on_insert_user_function != '')
            $error = call_user_func($this->on_insert_user_function);

        // go back on validation error
        if($error != '' || !$is_valid){
            $this->edit($error);
            return;
        }

        // insert data
        $id = $this->sql_insert();

        // user function after insert
        if($this->after_insert_user_function != '')
            call_user_func($this->after_insert_user_function, $id);
        
        // send user back to edit screen if desired
        $action = '';
        if($this->return_to_edit_after_insert)
            $action = 'action=edit&';

        // redirect user
        $url = $this->get_uri_path() . "{$action}_success=1&$this->identity_name=$id&" . $this->get_qs(''); // do carry items defined in query_string_list, '' removes the default
        $this->redirect($url, $id);

    }


    function update(){

        // purpose: called from contoller to display update() data

        $error = '';

        // validation system
        $is_valid = $this->validate($this->on_update_validate);
        if(!$is_valid)
            $error = $this->validate_text_general; //optional general error at the top

        // call user function to validate or whatever
        if($is_valid && $this->on_update_user_function != '')
            $error = call_user_func($this->on_update_user_function);

        // go back on validation error
        if($error != '' || !$is_valid){
            $this->edit($error);
            return;
        }

        // update data
        $id = $this->sql_update();

        // user function after update
        if($this->after_update_user_function != '')
            call_user_func($this->after_update_user_function);
        
        // send user back to edit screen if desired
        $action = '';
        if($this->return_to_edit_after_update)
            $action = 'action=edit&';

        // redirect user
        $url = $this->get_uri_path() . "{$action}_success=2&$this->identity_name=$id&" . $this->get_qs();
        $this->redirect($url, $id);

    }


    function update_grid(){

        // purpose: called from contoller to display update() data

        // call user function to validate or whatever
        $error = '';
        if($this->on_update_grid_user_function != '')
            $error = call_user_func($this->on_update_grid_user_function);

        // go back on validation error
        if($error != ''){
            $this->index($error);
            return;
        }
        
        // update data
        $flag = $this->sql_update_grid();

        // user function after updates
        if($this->after_update_grid_user_function != '')
            call_user_func($this->after_update_grid_user_function);

        // redirect user
        $url = $this->get_uri_path() . "_success=2&" . $this->get_qs();
        $this->redirect($url, $flag);

    }


    function delete(){

        // purpose: called from contoller to display update() data

        // call user function to validate or whatever
        $error = '';
        if($this->on_delete_user_function != '')
            $error = call_user_func($this->on_delete_user_function);

        // go back on validation error
        if($error != ''){
            if($_POST['_called_from'] == 'form')
                $this->edit($error);
            else
                $this->index($error);

            return;
        }
        
        // delete data
        $flag = $this->sql_delete();

        // user function after delete
        if($this->after_delete_user_function != '')
            call_user_func($this->after_delete_user_function);

        // redirect user
        $url = $this->get_uri_path() . "_success=3&" . $this->get_qs();
        $this->redirect($url, $flag);

    }


    function index($error = ''){

        // purpose: called from contoller to display update() data

        echo $this->grid($error);

    }

    
    function sql_delete(){

        // purpose: delete the requested record
        // returns: false on error, true on success
        
        $identity_id = $this->cast_id($_POST[$this->identity_name]);

        if($identity_id == 0){
            $this->display_error("missing identity_value", 'delete()');
            return false;
        }

        if(!$this->upload_delete($this->table, $this->identity_name, $identity_id, '*', $this->form_input_control))
            return false;

        $sql_param = array(':identity_id' => $identity_id);
        $sql = "delete from `$this->table` where `$this->identity_name` = :identity_id limit 1";
        if($this->query($sql, $sql_param, 'delete()') === false)
            return false;

    }


    function sql_insert(){

        // purpose: generate insert sql statement from the data posted and table's meta data
        // returns: false on error, id returned on success

        $columns = $this->get_columns();

        if(mb_strlen($this->table) == 0 || count($columns) == 0){
            $this->display_error("missing tablename, or get_columns() failed", 'insert()');
            return false;
        }

        // format list of fields from posted data
        $sql_fields = '';
        foreach($_POST as $key => $val){

            // checkboxes require a special hidden field to identify unchecked values
            if(mb_substr($key, -9) == '-checkbox')
                if(mb_substr($key, 0, -9) != $prev_key)
                    $key = mb_substr($key, 0, -9);

            $prev_key = $key;

            if(!(array_search($key, $columns) === false))
                $sql_fields .= "`$key`, ";  
        }
        $sql_fields = rtrim($sql_fields, ', ');
        

        // format list of values from posted data
        $sql_param = array();
        $sql_values = '';
        foreach($_POST as $key => $val){

            // don't allow updates on certain fields
            if(array_key_exists($key, $this->exclude_field))
                continue;

            // checkboxes require a special hidden field to identify unchecked values
            if(mb_substr($key, -9) == '-checkbox')
                if(mb_substr($key, 0, -9) != $prev_key)
                    $key = mb_substr($key, 0, -9);

            if(!(array_search($key, $columns) === false)){
                $safe_np = $this->safe_np($key);
                $sql_values .= ":$safe_np, ";
                $sql_param[":$safe_np"] = $this->cast_value($val, $key);
            }

            $prev_key = $key;

        }

        $sql_values = rtrim($sql_values, ', '); 
        
        $sql = "insert into `$this->table` ($sql_fields) values ($sql_values);";
        $identity_id = $this->query($sql, $sql_param, 'insert()');
        if($identity_id === false)
            return false;

        if(!$this->get_upload($columns, $this->table, $this->identity_name, $identity_id))
            return false;

        return $identity_id;
    }


    function sql_update(){

        // purpose: generate and run update sql statement from the data posted and table's meta data
        // returns: false on error, true on success

        $columns = $this->get_columns();
        $identity_id = $this->cast_id($_POST[$this->identity_name]);

        if(mb_strlen($this->table) == 0 || $identity_id == 0 || count($columns) == 0){
            $this->display_error("missing tablename, or missing identity_value, or get_columns() failed", 'update()');
            return false;
        }

        // posted values are saved here for pdo execute
        $sql_param = array();
        $sql_param[':identity_id'] = $identity_id;

        // make sql statement from key and values in $_POST data
        $sql_set = '';
        foreach($_POST as $key => $val){

            // don't allow updates on certain fields
            if(array_key_exists($key, $this->exclude_field))
                continue;

            // checkboxes require a special hidden field so unchecked values are detectable
            if(mb_substr($key, -9) == '-checkbox')
                if(!array_key_exists(mb_substr($key, 0, -9), $_POST))
                    $key = mb_substr($key, 0, -9);
            
            if(!(array_search($key, $columns) === false)){
                $safe_np = $this->safe_np($key);
                $sql_set .= "`$key` = :$safe_np, "; 
                $sql_param[":$safe_np"] = $this->cast_value($val, $key);
            }

        }
        $sql_set = rtrim($sql_set, ', ');

        // run sql update
        if($sql_set != ''){

            $sql_final = "update `$this->table` set $sql_set where `$this->identity_name` = :identity_id;";
            
            if($this->query($sql_final, $sql_param, 'update()') === false)
                return false;
        }

        if(!$this->get_upload($columns, $this->table, $this->identity_name, $identity_id))
            return false;

        return $identity_id;

    }


    function sql_update_grid(){

        // purpose: generate multiple update sql statements from editable fields in grid()
        // returns: false on error, true on success

        $columns = $this->get_columns('grid');
        $skip_update_on_column_name = '';

        $table = $this->table;
        $identity_name = $this->identity_name;
        $input_control = $this->grid_input_control;

        if(mb_strlen($table) == 0 || count($columns) == 0 || (count($input_control) == 0 && $this->grid_multi_delete == false)){
            $this->display_error("missing table name, or get_columns(), or grid_input_control is empty", 'update_grid()');
            return false;
        }

        // optimization flag
        $run_upload = false;
        if(array_search('--image', $input_control) || array_search('--document', $input_control))
            $run_upload = true;

        // gather all identity ids from suffix of input_name-identity_id
        $arr_identity_id = array();
        $prev_identity_id = 0;
        $post = array_merge($_POST, $_FILES);
        foreach($post as $key => $val){
            
            if(!mb_strstr($key, '-'))
                continue;    
            
            $identity_id = $this->cast_id(mb_substr($key, mb_strrpos($key, '-') + 1));

            if($identity_id == 0)
                continue;

            if($identity_id != $prev_identity_id)
                array_push($arr_identity_id, $identity_id);

            $prev_identity_id = $identity_id;
        }

        // run updates
        $sql_final = '';
        $sql_param = array();
        $this->dbh->beginTransaction();
        foreach($arr_identity_id as $identity_id){

            $sql_set = '';
            $sql_param[':identity_id'] = $identity_id;

            // loop thur editable columns
            foreach($input_control as $column_name => $control){

                if(array_search($column_name, $columns) === false)
                    continue;

                if($column_name == $skip_update_on_column_name)
                    continue;

                if($this->is_upload($input_control, $column_name))
                    continue;

                $safe_np = $this->safe_np($column_name);
                $sql_set .= "`$column_name` = :$safe_np, ";
                $sql_param[":$safe_np"] = $this->cast_value(@$_POST["$column_name-$identity_id"], $column_name, 'grid');

            }

            // append statements
            if(mb_strlen($sql_set) > 0){
                
                $sql_set = rtrim($sql_set, ', ');
                $sql_final = "update `$table` set $sql_set where `$identity_name` = :identity_id;\n";

                if($this->query($sql_final, $sql_param, 'sql_update_grid()') === false)
                    return false;
                $sql_param = array();
            
            }

        }
        $this->dbh->commit();

        // upload files
        if($run_upload)
            foreach($arr_identity_id as $identity_id)
                $this->get_upload($columns, $table, $identity_name, $identity_id, $context);

        // get records to delete
        $arr_delete = @$_POST['_delete'];
        if(!is_array($arr_delete))
            $arr_delete = array();

        // delete records
        $sql = '';
        $sql_param = array();
        foreach($arr_delete as $identity_id){

            if($run_upload)
                $this->upload_delete($table, $identity_name, $identity_id, '*', $input_control);

            $sql = "delete from `$table` where `$identity_name` = :identity_id;";
            $sql_param = array(':identity_id' => $identity_id);
            if($this->query($sql, $sql_param, 'sql_update_grid() - delete') === false)
                return false;

        }

        return true;

    }

    
    function form($error = ''){

        // purpose: generate a form to edit or add a record
        // if a record is found the form will be populated for editing, otherwise the form is empty and form is for adding/inserting data
        // $error = error message to display before form, often from server-side validation
        // returns: html

        if(mb_strlen($this->identity_name) == 0 || (mb_strlen($this->grid_sql) && mb_strlen($this->table) == 0)){
            $this->display_error("missing grid_sql and table (one is required), or missing identity_name", 'form()');
            return;
        }

        $identity_id = $this->cast_id(@$_GET[$this->identity_name]);
        if($identity_id == 0)
            $identity_id = $this->cast_id(@$_POST[$this->identity_name]);

        $sql = $this->form_sql;
        $sql_param = $this->form_sql_param;
        
        // make sql statement from table name if no sql was provided
        if(mb_strlen($sql) == 0){
            $sql_param = array(':identity_id' => $identity_id);
            $sql = "select * from `$this->table` where `$this->identity_name` = :identity_id";
        }

        // run query
        $result = $this->query($sql, $sql_param, 'form()');

        // quit on error
        if($result === false)
            return;

        $columns = $this->get_columns('form');
        $count = count($result);
        $_posted = intval(@$_POST['_posted']);

        // success messages 
        $success = intval(@$_GET['_success']);
        if($success == 1)
            $success = $this->form_text_record_added;
        elseif($success == 2)
            $success = $this->form_text_record_saved; 
        else
            $success = '';

        // are we adding (blank form) or editing (populated form) a record
        if($count == 0){
            $action = 'add';
            $title = $this->form_text_title_add;
            $validate = $this->on_insert_validate;
        }
        else{
            $action = 'edit';
            $title = $this->form_text_title_edit;
            $validate = $this->on_update_validate;
        }

        // get 1 row of data if available
        $row = false;
        $identity_id = 0; // id fetched below
        if(count($result) > 0){
            $row = $result[0];
            $identity_id = $this->cast_id($row[$this->identity_name]);
        }

        if($action == 'edit' && $identity_id == 0)
            $error .= "Missing identity_id. If using a custom form_sql statement be sure to include the identity. ";
    
        // query string is used here in form() to maintain pagination and sort data so user can return back to the same place in grid results 
        $qs = $this->get_qs();
        if(mb_strlen($qs) > 0)
            $qs = "$qs";
        
        $uri_path = $this->get_uri_path();

        $html  = "<div id='lm'>\n";
        $html .= "<form action='$uri_path$qs' method='post' enctype='multipart/form-data'>\n";
        $html .= "<input type='hidden' name='_csrf' value='$_SESSION[_csrf]'>\n";
        $html .= "<input type='hidden' name='_posted' value='1'>\n";

        if(mb_strlen($error) > 0)
            $html .= "<div class='lm_error'><b>$error</b></div>\n";
        
        if(mb_strlen($success) > 0)
            $html .= "<div class='lm_success'><b>$success</b></div>\n";
        
        $html .= "<table cellpadding='2' cellspacing='1' border='0' class='lm_form'>\n";

        if(mb_strlen($title) > 0)
            $html .= "<tr>\n    <th colspan='2'>$title</th>\n</tr>\n";

        // loop thru fields
        foreach($columns as $column_name){

            if($column_name == $this->identity_name && ($this->form_display_identity == false || $action == 'add'))
                continue;

            // get data from database or repost
            if($_posted == 1 && !mb_stristr(@$this->form_input_control[$column_name], 'readonly'))
                $value = @$_POST[$column_name];
            elseif($count == 0)
                $value = @$this->form_default_value[$column_name];
            else
                $value = $row[$column_name];

            // field label
            $title = $this->format_title($column_name, @$this->rename[$column_name]);

            // render the html control according to the type of data
            $control = "";    

            if($column_name == $this->identity_name)
                $control = $this->clean_out($value);
            elseif(array_key_exists($column_name, $this->form_input_control))
                $control = $this->get_input_control($column_name, $value, $this->form_input_control[$column_name], 'form', $validate);
            else
                $control = $this->get_input_control($column_name, $value, '--text', 'form', $validate);
        
            $html .= "<tr>\n";
            $html .= "    <td>$title:</td>\n";
            $html .= "    <td>$control</td>\n";
            $html .= "</tr>\n";
        }

        $html .= "</table>\n";

        if($action == 'edit')
            $html .= "<input type='hidden' name='$this->identity_name' value='$identity_id'>\n";

        // action 
        if($action == 'edit')
            $html .= "<input type='hidden' name='action' value='update'>\n";
        else
            $html .= "<input type='hidden' name='action' value='insert'>\n";
        
        // add buttons
        if($action == 'edit')
            $html .= "<div class='lm_form_button_bar'>$this->form_back_button $this->form_delete_button $this->form_update_button</div>";
        else
            $html .= "<div class='lm_form_button_bar'>$this->form_back_button $this->form_add_button</div>";

        $html .= $this->form_additional_html;
        $html .= "</form>\n";
        $html .= "</div><!-- close #lm -->\n";
        $html .= $this->delete_js($identity_id, 'form');
        
        return $html;    

    }

    
    function grid($error = ''){

        // purpose: function to list a table of records. aka data grid
        // returns: html
        // populate_from_post tells inputs to populate from $_POST instead of the database. useful to preserve data when displaying validation errors.
        // in grid_sql, select the identity_id as the last column to display the edit and delete links
        // example: $lm->grid_sql = 'select title, create_date, foo_id from foo';

        if(mb_strlen($this->identity_name) == 0 || (mb_strlen($this->grid_sql) && mb_strlen($this->table) == 0)){
            $this->display_error("missing grid_sql and table (one is required), or missing identity_name", 'form()');
            return;
        }

        // local copies 
        $sql = trim($this->grid_sql);
        $sql_param = $this->grid_sql_param;
        $grid_limit = intval($this->grid_limit);
        $uri_path = $this->get_uri_path();
        $default_order_by = $this->grid_default_order_by;

        if($default_order_by == '')
            $default_order_by = "`$this->identity_name`";

        // remove line feeds which can cause problems with parsing
        $sql = preg_replace('/[\n\r]/', ' ', $sql);

        // default queries if only table and id names were provided
        if(mb_strlen($sql) == 0)
            $sql = "select *, `$this->identity_name` from `$this->table` order by $default_order_by";

        // inject funciton for counting
        $sql = preg_replace('/^select/i', 'select sql_calc_found_rows', $sql);

        // get input
        $_posted = intval(@$_REQUEST['_posted']);
        $_search = $this->clean_out(@$_REQUEST['_search']);
        $_pagination_off = intval(@$_REQUEST['_pagination_off']);
        $_order_by = abs(intval(@$_REQUEST['_order_by'])); // order by is numeric index to column
        $_desc = abs(intval(@$_REQUEST['_desc']));         // descending order flag
        $_offset = abs(intval(@$_REQUEST['_offset']));     // pagination offset
        $_export = intval(@$_REQUEST['_export']); 
        
        $qs = $this->get_qs();

        // header links - invert current sort
        $_desc_invert = 1;
        if($_desc == 1)
            $_desc_invert = 0;

        // success messages 
        $success = intval(@$_GET['_success']);
        if($success == 1)
            $success = $this->grid_text_record_added;
        elseif($success == 2)
            $success = $this->grid_text_changes_saved;
        elseif($success == 3)
            $success = $this->grid_text_record_deleted;
        else
            $success = '';

        // column array and column count 
        $columns = $this->get_columns('grid');
        $column_count = count($columns);
        if($column_count == 0)
            return;

        // alter order
        $desc_str = '';
        if($_order_by > 0){
            if($_desc == 1)
                $desc_str = 'desc'; 
            $sql = rtrim($sql, '; '); // remove last semicolon
            $sql = preg_replace('/order\s+by\s+.+$/i', '', $sql); // remove existing order
            $sql .= " order by $_order_by $desc_str"; // add requested sort order
        }

        // remove existing limit
        $sql = preg_replace('/\s+limit\s+[0-9,\s]+$/i', '', $sql); 

        // add limit and offset for pagination
        if($_pagination_off == 0 && $_export == 0)
            $sql .= " limit $_offset, $grid_limit"; 

        // run query
        $result = $this->query($sql, $sql_param, 'grid() run query');
        if(!is_array($result))
            $result = array();

        // get count
        $count = 0;
        $sql = 'select found_rows() as cnt';
        $result_count = $this->query($sql);
        foreach($result_count as $row)
            $count = $row['cnt'];

        // export data to CSV and quit 
        if($_export == 1 && $count > 0){
            $this->export($result, $columns);
            return;    
        }

        // populate link placeholders    
        $grid_add_link = $this->grid_add_link;
        $grid_edit_link = $this->grid_edit_link;
        $grid_delete_link = $this->grid_delete_link;
        $grid_export_link = $this->grid_export_link;
        $grid_add_link = str_replace('[script_name]', $uri_path, $grid_add_link);
        $grid_add_link = str_replace('[qs]', $qs, $grid_add_link);
        $grid_edit_link = str_replace('[script_name]', $uri_path, $grid_edit_link);
        $grid_edit_link = str_replace('[qs]', $qs, $grid_edit_link);
        $grid_edit_link = str_replace('[identity_name]', $this->identity_name, $grid_edit_link);
        $grid_delete_link = str_replace('[script_name]', $uri_path, $grid_delete_link);
        $grid_delete_link = str_replace('[qs]', $qs, $grid_delete_link);
        $grid_delete_link = str_replace('[identity_name]', $this->identity_name, $grid_delete_link);
        $grid_export_link = str_replace('[script_name]', $uri_path, $grid_export_link);
        $grid_export_link = str_replace('[qs]', $qs, $grid_export_link);
        $links = $grid_edit_link . ' ' . $grid_delete_link;

        // pagination and save changes link bar
		$pagination = $this->get_pagination($count, $grid_limit, $_offset, $_pagination_off);
        $button = '';
		if(count($this->grid_input_control) > 0 || $this->grid_multi_delete == true)
            $button = "<input type='submit' name='__update_grid' value='$this->grid_text_save_changes' class='lm_button lm_save_changes_button'>";
		$pagination_button_bar = "<table cellpadding='2' cellspacing='1' border='0' width='100%' class='lm_pagination'><tr><td style='text-align: left'>$pagination</td><td style='text-align: right'>$button</td></tr></table>\n";

        // search bar
        $search_box = '';
		if($this->grid_show_search_box){
    
            // carry values defined in query_string_list
            $query_string_list_inputs = '';
            if(mb_strlen($this->query_string_list) > 0){
                $arr = explode(',', trim($this->query_string_list, ', '));
                foreach($arr as $val)
                    $query_string_list_inputs .= "<input type='hidden' name='$val' value='" . $this->clean_out(@$_REQUEST[$val]) . "'>";
            }
            
            $search_box = $this->grid_search_box;
			$search_box = str_replace('[script_name]', $uri_path . $this->get_qs('') , $search_box); // for 'x' cancel do add get_qs('') to carry query_string_list
			$search_box = str_replace('[_search]', $_search, $search_box);
			$search_box = str_replace('[_csrf]', $_SESSION['_csrf'], $search_box);
			$search_box = str_replace('[query_string_list]', $query_string_list_inputs, $search_box);
        }

		$add_record_search_bar = "<table cellpadding='2' cellspacing='1' border='0' width='100%' class='lm_add_search'><tr><td style='text-align: left'>$grid_add_link &nbsp; $grid_export_link</td><td style='text-align: right'>$search_box</td></tr></table>\n";

        // generate table header
        $head = "<tr>\n";
        if($this->grid_multi_delete)
            $head .= "<th><a href='#' onclick='return _toggle();' title='toggle checkboxes'>$this->grid_text_delete</a></th>\n";
        
        $i = 0;
        foreach($columns as $column_name){

            $title = $this->format_title($column_name, @$this->rename[$column_name]);

            if($column_name == $this->identity_name && $i == ($column_count - 1))
                $head .= "    <th></th>\n"; // if identity is last column then this is the column with the edit and delete links
            else
                $head .= "    <th><a href='{$uri_path}_order_by=" . ($i + 1) . "&_desc=$_desc_invert&" . $this->get_qs('_search') . "'>$title</a></th>\n";
        
            $i++;

        }
        $head .= "</tr>\n";
            
        // start generating output //
        $html = "<div id='lm'>\n";

        if(mb_strlen($success) > 0)
            $html .= "<div class='lm_success'><b>$success</b></div>\n";
        if(mb_strlen($error) > 0)
            $html .= "<div class='lm_error'><b>$error</b></div>\n";
        
        $html .= $add_record_search_bar;

        $html .= "<form action='$uri_path$qs' method='post' onsubmit='return _update_grid()' enctype='multipart/form-data'>\n";
        $html .= "<input type='hidden' name='_posted' value='1'>\n";
        $html .= "<input type='hidden' name='_csrf' value='$_SESSION[_csrf]'>\n";

        // quit if there's no data
        if($count <= 0){
            $html .= "<div class='lm_error'><b>$this->grid_text_no_records_found</b></div></form></div><!-- close #lm -->\n";
            return $html;    
        }    

        // buttons & pagination on top. only show if we have a lot of records
        if($count > 30)
            $html .= $pagination_button_bar;

        $html .= "<table cellpadding='2' cellspacing='1' border='0' width='100%' class='lm_grid'>\n";
        $html .= $head;

        // print rows
        $j = 0;
        foreach($result as $row){

            // highlight last updated or inserted row
            $shaded = '';
            if(@$_GET[$this->identity_name] == @$row[$this->identity_name] && mb_strlen(@$_GET[$this->identity_name]) > 0)
                $shaded = "class='lm_active'";

            // print a row
            $html .= "<tr $shaded>\n";

            // delete selection checkbox
            if($this->grid_multi_delete){
                $html .= "<td align='center'><label><input type='checkbox' name='_delete[]' value='{$row[$this->identity_name]}'></label></td>\n";
            }

            // print columns
            $i = 0;
            foreach($columns as $column_name){

                $value = $row[$column_name];

                // edit & delete links
                if($column_name == $this->identity_name && $i == ($column_count - 1))
                    $html .= "    <td nowrap>" . str_replace('[identity_id]', $value, $links) . "</td>\n";

                // input fields
                elseif(array_key_exists($column_name, $this->grid_input_control)){
                    if(mb_strlen($error) > 0 && $_posted == 1) // repopulate from previous post when validation error is displayed
                        $value = $_POST[$column_name . '-' . $row[$this->identity_name]];
                    $html .= '    <td>' . $this->get_input_control($column_name . '-' . $row[$this->identity_name], $value,  $this->grid_input_control[$column_name], 'grid') . "</td>\n";
                }

                // output
                elseif(array_key_exists($column_name, $this->grid_output_control))
                    $html .= '    <td>' . $this->get_output_control($column_name . '-' . $row[$this->identity_name], $value, $this->grid_output_control[$column_name], 'grid') . "</td>\n";

                // anything else
                else
                    $html .= '    <td>' . $this->get_output_control($column_name . '-' . $row[$this->identity_name], $value, '--text', 'grid') . "</td>\n";

                $i++; // column index
            }

            $html .= "</tr>\n";

            // repeat header
            if($this->grid_repeat_header_at > 0)
                if($j % $this->grid_repeat_header_at == 0 && $j < $count && $j > 0)
                    $html .= $head;
                
            // row counter    
            $j++;
        }

        $html .= "</table>\n";

        // buttons & pagination, close form
        $html .= $pagination_button_bar;
        $html .= "</form>\n";
        $html .= "</div><!-- close #lm -->\n";
		$html .= $this->delete_js(0, 'grid');

        return $html;

    }

    
    function delete_js($identity_id = 0, $_called_from = ''){

        // purpose: extra form & js for deleing records and going back
        // returns: html

        $uri_path = $this->get_uri_path();
        $qs = $this->get_qs(); 
        $back_link = $uri_path . $qs;

        // append id for row highlighting
        if($identity_id > 0)
            $back_link .= "&$this->identity_name=$identity_id";

        // escape for js
        $delete_confirm = str_replace("'", "\'", $this->delete_confirm);
        $update_grid_confirm = str_replace("'", "\'", $this->update_grid_confirm);

        return "
        <form action='$uri_path$qs' method='post' name='delete_js'>
        <input type='hidden' name='action' value='delete' >
        <input type='hidden' name='$this->identity_name' value='$identity_id' >
        <input type='hidden' name='_csrf' value='$_SESSION[_csrf]' >
        <input type='hidden' name='_called_from' value='$_called_from' >
        </form>

        <script type='text/javascript'>
		
		function _delete(id){

            if(!confirm('$delete_confirm'))
                return false;

            if(id)
                document.delete_js.elements['$this->identity_name'].value = id;
            
            document.delete_js.submit();
            return false;

        }    

        function _back(){

            window.location.href = '$back_link';

        }    

        function _toggle(){
        
            var form_cnt = document.forms.length;
            var i;

            for (i = 0; i < form_cnt; i++)
                for (j = 0; j < document.forms[i].length; j++)
                    if(document.forms[i].elements[j].name == '_delete[]')
                        document.forms[i].elements[j].checked = !document.forms[i].elements[j].checked;

            return false;

        }

        function _update_grid(){

            var form_cnt = document.forms.length;
            var i;
            var delete_cnt = 0;
            var msg = '$update_grid_confirm';

            for (i = 0; i < form_cnt; i++)
                for (j = 0; j < document.forms[i].length; j++)
                    if(document.forms[i].elements[j].name == '_delete[]')
                        if(document.forms[i].elements[j].checked)
                            delete_cnt++;

            if(delete_cnt == 0)
                return true;

            msg = msg.replace('[count]', delete_cnt);
            if(!confirm(msg))
                return false;

            return true;

        }
        </script>
        ";
    }
    

    function html_image_input($field_name, $file_name){

        // purpose: if image exists, display image and delete checkbox. also display file input
        // returns: html

        $html = '';
        $class = $this->get_class_name($field_name);

        if(mb_strlen($file_name) > 0){
        
            if(mb_strlen($this->thumb_path))
                $html .= "<a href='$this->upload_path/$file_name' target='_blank'><img src='$this->thumb_path/$file_name' alt='' $this->image_style ></a>";
            else
                $html .= "<a href='$this->upload_path/$file_name' target='_blank'><img src='$this->upload_path/$file_name' alt='' $this->image_style ></a>";

            $html .= " <label><input type='checkbox' name='{$field_name}-delete' value='1' >$this->text_delete_image</label><br>";
        }

        $html .= "<input type='file' name='$field_name' class='$class' size='$this->form_text_input_size'>";

        return $html;

    }


    function html_document_input($field_name, $file_name){

        // purpose: if document exists, display link and delete checkbox. also display file input
        // returns: html

        $html = '';
        $class = $this->get_class_name($field_name);

        if(mb_strlen($file_name) > 0)
            $html .= "<a href='$this->upload_path/$file_name' target='_blank'>$file_name</a> <label><input type='checkbox' name='{$field_name}-delete' value='1'>$this->text_delete_document</label><br >";

        $html .= "<input type='file' name='$field_name' class='$class' size='$this->form_text_input_size'>";

        return $html;

    }


    function html_image_output($file_name){

        // purpose: if image exists, display image depending on settings and if thumbnail exists
        // returns: html

        if(mb_strlen($file_name) == 0)
            return;

        if($this->grid_show_images == false)
            return "<a href='$this->upload_path/$file_name' target='_blank'>" . $this->clean_out($file_name, $this->grid_ellipse_at) . "</a>";
        elseif(mb_strlen($this->thumb_path))
            return "<a href='$this->upload_path/$file_name' target='_blank'><img src='$this->thumb_path/$file_name' alt='' $this->image_style ></a>";
        else
            return "<a href='$this->upload_path/$file_name' target='_blank'><img src='$this->upload_path/$file_name' alt='' $this->image_style ></a>";


    }


    function html_document_output($file_name){

        // purpose: if exists, display document link
        // returns: html

        if(mb_strlen($file_name) > 0)
            $html = "<a href='$this->upload_path/$file_name' target='_blank'>" . $this->clean_out($file_name, $this->grid_ellipse_at) . "</a>";

        return $html;

    }


    function html_html_output($value){

        // purpose: when html is displayed in grid remove the tags and just display the plain text content
        // returns: html

        if(mb_strlen($value) == 0)
            return;

        $html = strip_tags($value);
        $html = str_replace('&nbsp;', ' ', $html);

        if($this->grid_ellipse_at > 0)
            if(mb_strlen($html) > $this->grid_ellipse_at)
                $html = mb_substr($html, 0, $this->grid_ellipse_at) . "...";
        $html = str_replace('<', '&lt;', $html);
        $html = str_replace('>', '&gt;', $html);

        return $this->clean_out($html);

    }

	
	function html_radio($field_name, $value, $sql){    

        // purpose: render html radio input, note sql query should return 2 columns
        // returns: html

        static $prev_sql = '';
        static $result;
        $class = $this->get_class_name($field_name);

        // if no sql is provided render 1 = yes/ 0 = no
        if($sql == '')
            $sql = "select 1 as val, 'Yes' as opt union select 0, 'No'";

        // simple optimization
        if($prev_sql != $sql)
            $result = $this->query($sql, array(), 'html_radio()');

        $prev_sql = $sql;

        $control = '';    
        foreach($result as $row){

            $val = current($row);
            $opt = next($row);

            $checked = "";
            if($val == $value)
                $checked = "checked='checked'";
            
            $control .= "<label><input type='radio' name='$field_name' class='$class' value='" . $this->clean_out($val) . "' $checked >" . $this->clean_out($opt) . "</label> ";
        }
        
        return $control;

    }


    function html_select($field_name, $value, $sql, $sql_param = array(), $js_or_css = '', $first_option_blank = true, $multiple = 0){

        // purpose: render html select dropdown from sql query
        // returns: html
        // sample query: select 0 as val, 'no' as opt union select 1, 'yes'

        static $prev_sql = '';
        static $result;
        $out = '';
        $class = $this->get_class_name($field_name);

        // if no sql is provided render 1 = yes, 0 = no
        if($sql == '')
            $sql = "select 1 as val, 'Yes' as opt union select 0, 'No'";
	
        // simple optimization
        if($prev_sql != $sql)
            $result = $this->query($sql, $sql_param, 'html_select()');

        $prev_sql = $sql;

        if($multiple == 0){

            if($first_option_blank)
                $out .= "<option value=''>&nbsp;</option>";

            foreach($result as $row){

                $val = current($row);
                $opt = next($row);

                $selected = '';
                if($val == $value)
                    $selected = "selected='selected'";

                $out .= "<option value='" . $this->clean_out($val) . "' $selected>" . $this->clean_out($opt) . "</option>";
            }
            $out = "<select name='$field_name' class='$class' $js_or_css>$out</select>";
            return $out;
        }
            
        // render multiple select
        $out  = "";
        if($first_option_blank)
            $out .= "<option value=''>&nbsp;</option>";

        $value  = "$this->delim$value$this->delim";
        foreach($result as $row){

            $val = current($row);
            $opt = next($row);

            $selected = '';    
            if(mb_strstr($value, "$this->delim$val$this->delim"))
                $selected = "selected='selected'";
        
            $out .= "<option value='" . $this->clean_out($val) . "' $selected>" . $this->clean_out($opt) . "</option>";
        }    

        $out = "<select name='{$field_name}[]' class='$class' multiple='multiple' size='$multiple' $js_or_css>$out</select>";
        return $out;

    }


    function html_checkbox($field_name, $value, $sql, $sql_param = array()){

        // purpose: render checkbox inputs
        // returns: html

        $class = $this->get_class_name($field_name);

        // make hidden field name. an additional hidden field is require to detect presence of checkbox. 
        $i = mb_strrpos($field_name, '-');
        if($i > 0)
            $field_name_hidden = mb_substr($field_name, 0, $i) . '-checkbox' . mb_substr($field_name, $i); // grid format field_name-checkbox-identity_id
        else
            $field_name_hidden = $field_name . '-checkbox';


        // if no sql is provided just return a single checkbox for 1 = yes
        $checked = '';
        if($sql == ''){
            
            if(intval($value) > 0)
                $checked = "checked='checked'";
            
            return "<label><input type='checkbox' name='$field_name' class='$class' value='1' $checked ></label><input type='hidden' name='$field_name_hidden' value=''>";
        }

        static $prev_sql = '';
        static $result;

        // simple optimization
        if($prev_sql != $sql)
            $result = $this->query($sql, $sql_param, 'html_radio()');

        $prev_sql = $sql;

        $value  = "$this->delim$value$this->delim";
        foreach($result as $row){

            $val = current($row);
            $opt = next($row);

            $checked = '';    
            if(mb_strstr($value, "$this->delim$val$this->delim"))
                $checked = "checked='checked'";

            $html .= "<label><input type='checkbox' name='{$field_name}[]' class='$class' value='" . $this->clean_out($val) . "' $checked >" . $this->clean_out($opt) . "</label>&nbsp;";
        }
        $html .= "<input type='hidden' name='$field_name_hidden' value='0'>";

        return $html;

    }

   
    function cast_value($val, $column_name = '', $posted_from = 'form'){
        
        // purpose: cast data going into the database. set blanks null and format dates
        // returns: string
        // $column_name is not used right now but might be needed as a hack to cast by column name for databases like sqlite
        // missing types seem to always be numbers

        if(is_array($val))
            $val = implode($this->delim, $val);

        $val = trim($val);

        if($posted_from == 'grid')
            $command = @$this->grid_input_control[$column_name];
        else
            $command = @$this->form_input_control[$column_name];

        // get command only, no sql, no '--'
        $cmd = trim(mb_substr($command, mb_strrpos($command, '--') + 2));

        if(isset($this->cast_user_function[$column_name]))
            $val = call_user_func($this->cast_user_function[$column_name], $val);
        elseif($cmd == 'date')
            $val = $this->date_in($val);
        elseif($cmd == 'datetime')
            $val = $this->date_in($val, true);
        elseif($cmd == 'number' && mb_strlen($this->restricted_numeric_input) > 0)
            $val = preg_replace($this->restricted_numeric_input, '', $val);
        
        if(mb_strlen($val) == 0)
            $val = null;

        return $val;

    }


	function cast_id($str){

		// purpose: similar to intval() but supports mysql bigint and does not overflow

		if(preg_match('/-?[0-9]{1,30}/', $str))
			return $str;
		else
			return 0;

	}

    
    function clean_file_name($file_name){

        // purpose: make uniform file_names to lowercase, no dots, no spaces

        $file_name = mb_strtolower($file_name);
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $prefix = mb_substr($file_name, 0, (mb_strlen($ext) + 1) * -1); 
        $prefix = str_replace(' ', '_', $prefix);
        $prefix = preg_replace('([^0-9a-z_\-])', '', $prefix);
        return "$prefix.$ext";

    }


    function clean_out($str, $ellipse_at = 0){

        // purpose: escape html output w/ optional ellipsing

        if(is_array($str))
            $str = implode($this->delim, $str);
        elseif($ellipse_at > 0)
            if(mb_strlen($str) > $ellipse_at)
                $str = mb_substr($str, 0, $ellipse_at, $this->charset) . "...";

        // remove illegal characters
        $str = mb_convert_encoding($str, $this->charset, mb_detect_encoding($str));

        return htmlspecialchars($str, ENT_QUOTES, $this->charset);
    }


    function date_in($str, $use_time = false){

        // purpose: convert local format to database format

        if($str == '')
            return;

        // remove spaces between slash or dash delimiters. allow user to be a little sloppy.
        $str = preg_replace('/([0-9]+)\s?([\/\-]){1}\s?([0-9]+)\s?([\/\-]){1}\s?([0-9]+)/', '\1\2\3\4\5', $str);

        // strtotime requires dash delimiter when using d/m/y   
        if(preg_match('/[dj].*[mn]/', $this->date_out))
            $str = str_replace('/', '-', $str);

        $ts = strtotime($str);
        if($ts === false) 
            return;
        
        if($use_time)    
            return date($this->datetime_in, $ts);
        else
            return date($this->date_in, $ts);

    }


    function date_out($str, $use_time = false){

        // purpose: convert database format to local format

        if(mb_strlen($str) < 8)
            return; 
        
        if($use_time)
            return date($this->datetime_out, strtotime($str));
        else
            return date($this->date_out, strtotime($str));

    }


    function format_title($field_name, $friendly_name = ''){
        
        // purpose: change field name to friendly. example: first_name becomes "First Name" or EntryFee1 becomes "Entry Fee 1"
        // returns: html escaped string

        if(mb_strlen($friendly_name) > 0)
            return $this->clean_out($friendly_name);

        $friendly_name = $field_name;
        $friendly_name = preg_replace('/([a-z]{1})([A-Z]{1})/', '\1 \2', $friendly_name);
        $friendly_name = preg_replace('/([a-z]{1})([0-9]+)/i', '\1 \2 ', $friendly_name);
        $friendly_name = str_replace('_', ' ', $friendly_name);
		$friendly_name = mb_convert_case($friendly_name, MB_CASE_TITLE, $this->charset);

        return $this->clean_out($friendly_name);

    }


    function get_action(){

        // purpose: get the action/command on what function to call
        // submit buttons can be named with the action i.e. "__update" or "__delete";
        // look at the names/key posted to see if there's an action requested

        static $action;

        if(isset($action))
            return $action;

        $post_get = array_merge($_POST, $_GET);

        if(mb_strlen(@$post_get['action']) > 0)
            return $post_get['action'];

        foreach($post_get as $key => $val)
            if(mb_substr($key, 0, 2) == '__')
                return mb_substr($key, 2);

    }


    function get_input_control($column_name, $value, $command, $called_from, &$validate = array()){

        // purpose: render html input based "command", if command is then try to call a user function
        // returns: html 
        
        // parse $command into $sql and $cmd, remove delimiter
		$pos = mb_strrpos($command, '--');
		$cmd = trim(mb_substr($command, $pos + 2));
		$sql = mb_substr($command, 0, $pos);

        // default
        if(mb_strlen($cmd) == 0)
            $cmd = 'text';

        // set input size    
        if($called_from == 'grid')
            $size = $this->grid_text_input_size;
        else
            $size = $this->form_text_input_size;

        $class = $this->get_class_name($column_name); 

        $validate_error = ''; // error next to input
        $validate_tip = '';   // tip next to input
        $validate_placeholder = ''; // text in placeholder - text inputs only
        $validate_placeholder_alternative = ''; // placeholder setting disabled - move text next to input 

        // display tip or error next to input, not both
        if(@$validate[$column_name][4] === false)
            $validate_error = "<span class='lm_validate_error'>" . $this->clean_out($validate[$column_name][1]) . "</span>";
        elseif(@$validate[$column_name][2] != '')
            $validate_tip = "<span class='lm_validate_tip'>" . $this->clean_out($validate[$column_name][2]) . "</span>";

        // always try to get a placeholder for the text inputs
        if($this->validate_tip_in_placeholder)
            $validate_placeholder = $this->clean_out(@$validate[$column_name][2]); // placeholders for text 
        elseif($validate_error == '')
			$validate_placeholder_alternative = "<span class='lm_validate_tip'>" . $this->clean_out($validate[$column_name][2]) . "</span>";
    
		$max_length = '';
		if(intval(@$this->text_input_max_length[$column_name]) > 0)
			$max_length = "maxlength='" . $this->text_input_max_length[$column_name] . "'";
		elseif($this->text_input_max_length_default > 0)
			$max_length = "maxlength='" . $this->text_input_max_length_default . "'";

        if($cmd == 'text')
            return "<input type='text' name='$column_name' class='$class' value='" . $this->clean_out($value) . "' size='$size' $max_length placeholder='$validate_placeholder'>$validate_error $validate_placeholder_alternative";
        elseif($cmd == 'password')
            return "<input type='password' name='$column_name' class='$class' value='" . $this->clean_out($value) . "' size='$size' $max_length placeholder='$validate_placeholder'>$validate_error $validate_placeholder_alternative";
        elseif($cmd == 'number')
            return "<input type='text' name='$column_name' class='$class' value='" . $this->clean_out($value) . "' size='18' $max_length placeholder='$validate_placeholder'>$validate_error $validate_placeholder_alternative";
        elseif($cmd == 'date')
            return "<input type='text' name='$column_name' class='$class' value='" . $this->date_out($value) . "' size='18' $max_length placeholder='$validate_placeholder'>$validate_error $validate_placeholder_alternative";
        elseif($cmd == 'datetime')
            return "<input type='text' name='$column_name' class='$class' value='" . $this->date_out($value, true) . "' size='18' $max_length placeholder='$validate_placeholder'>$validate_error $validate_placeholder_alternative";
        elseif($cmd == 'textarea')
            return "<textarea name='$column_name' class='$class' cols='60' rows='6' placeholder='$validate_placeholder'>" . $this->clean_out($value) . "</textarea>$validate_error $validate_placeholder_alternative";
        elseif($cmd == 'readonly_datetime')
            return $this->date_out($value, true);
        elseif($cmd == 'readonly_date')
            return $this->date_out($value);
        elseif($cmd == 'readonly')
            return $this->clean_out($value);
        elseif($cmd == 'image')
            return $this->html_image_input($column_name, $value) . $validate_tip . $validate_error;
        elseif($cmd == 'document')
            return $this->html_document_input($column_name, $value) . $validate_tip . $validate_error;
        elseif($cmd == 'select')
            return $this->html_select($column_name, $value, $sql, array(), '', $this->select_first_option_blank, 0) . $validate_tip . $validate_error;
        elseif($cmd == 'selectmultiple')
            return $this->html_select($column_name, $value, $sql, array(), '', $this->select_first_option_blank, 6) . $validate_tip . $validate_error;
        elseif($cmd == 'radio')
            return $this->html_radio($column_name, $value, $sql, array()) . $validate_tip . $validate_error;
        elseif($cmd == 'checkbox')
            return $this->html_checkbox($column_name, $value, $sql, array()) . $validate_tip . $validate_error;
		elseif(is_callable($cmd))
            return call_user_func($cmd, $column_name, $value, $command, $called_from, $validate_placeholder) . $validate_tip . $validate_error;
        else
            $this->display_error("Input command or user function not found: $cmd. Be sure to prefix control type with 2 dashes --", 'get_input_control()');

    }


    function get_output_control($column_name, $value, $command, $called_from){

        // purpose: render html output based "command", if command is then try to call a user function
        // returns: html 

        // get command only, no '--'
        $cmd = trim(mb_substr($command, mb_strrpos($command, '--') + 2));

        // default
        if(mb_strlen($cmd) == 0)
            $cmd = 'text';

        if($cmd == 'text')
            return $this->clean_out($value, $this->grid_ellipse_at); 
        elseif($cmd == 'date')
            return $this->date_out($value); 
        elseif($cmd == 'datetime')
            return $this->date_out($value, true); 
        elseif($cmd == 'email')
            return "<a href='mailto:$value'>$value</a>";
        elseif($cmd == 'document')
            return $this->html_document_output($value);
        elseif($cmd == 'image')
            return $this->html_image_output($value);
        elseif($cmd == 'html')
            return $this->html_html_output($value);
		elseif(is_callable($cmd))
            return call_user_func($cmd, $column_name, $value, $command, $called_from);
        else
            $this->display_error("Output command or user function not found: $cmd. Be sure to prefix control type with 2 dashes --", 'get_output_control()');

    }

    
    function get_columns($context = ''){

        // purpose: make array of column names from table name or custom sql 
        // populates: grid_output_control or form_input_control
        // context options: form, grid, or blank/none
        // returns: number indexed array of column names

        $table = $this->table;
        $sql = '';
        $sql_param = array();

        if($context == 'grid'){
            $sql = $this->grid_sql;
            $sql_param = $this->grid_sql_param;
            if($sql == '')
                $sql = "select *, `$this->identity_name` from `$table`";
        }
        elseif($context == 'form'){
            $sql = $this->form_sql;
            $sql_param = $this->form_sql_param;
        }

        if($sql == '')
            $sql = "select * from `$table`";

        // simplify query for faster execution
        $sql = rtrim($sql, "\r\n\t; ");                         // remove last semicolon
        $sql = preg_replace('/order\s+by\s+.+$/i', '', $sql);   // remove order
        $sql .= ' limit 0 ';                                    // add limit

        $sth = $this->dbh->prepare($sql);
        if(!$sth->execute($sql_param)){
            $arr = $sth->errorInfo();
            $error = $arr[2];
            $this->display_error("$error\nsql: $sql\narr_sql_param: " . print_r($sql_param, true), 'get_columns');
            return $columns;
        }

        $i = 0;
        $columns = array();
        while($column = $sth->getColumnMeta($i++)){
            if($context == 'form' && array_key_exists($column['name'], $this->exclude_field))
                continue;

            array_push($columns, $column['name']);
        }

        // quit now if there's nothing else to do
        if(!$this->auto_populate_controls)
            return $columns;

        // populate form_input_control
        $i = 0;
        while($column = $sth->getColumnMeta($i++)){
            
            $type = mb_strtolower(@$column['native_type']);
            $column_name = $column['name'];
            if(array_key_exists($column_name, $this->form_input_control) || $column_name == $this->identity_name)
                continue;

            if($type == 'date')
                $this->form_input_control[$column_name] = '--date';
            elseif($type == 'datetime' || $type == 'timestamp')
                $this->form_input_control[$column_name] = '--datetime';
            elseif($type == 'blob')
                $this->form_input_control[$column_name] = '--textarea';
            elseif(mb_strstr($type, 'short') || mb_strstr($type, 'int') || mb_strstr($type, 'long') || mb_strstr($type, 'float') || mb_strstr($type, 'double') || mb_strstr($type, 'decimal'))
                $this->form_input_control[$column_name] = '--number';

        }

        // populate grid_output_control with --date, --datetime
        $i = 0;
        while($context == 'grid' && $column = $sth->getColumnMeta($i++)){
            
            $type = mb_strtolower(@$column['native_type']);
            $column_name = $column['name'];
            if(array_key_exists($column_name, $this->grid_output_control) || $column_name == $this->identity_name)
                continue;

            if($type == 'date')
                $this->grid_output_control[$column_name] = '--date';
            elseif($type == 'datetime' || $type == 'timestamp')
                $this->grid_output_control[$column_name] = '--datetime';

        }

        // populate default values
        $sql = "select column_name, column_default from information_schema.columns where column_default is not null and table_name = :table and table_schema = database()";
        $sql_param = array(':table' => $table);
        $result = $this->query($sql, $sql_param, 'get_columns() - populate form_default_value');
        foreach($result as $row){
            
            if($context == 'form')
                if(!array_key_exists($row['column_name'], $this->form_default_value))
                    $this->form_default_value[$row['column_name']] = $row['column_default'];

        }

        return $columns;

    }

    
    function get_pagination($count, $limit, $_offset, $_pagination_off){

        // purpose: pagination for grid

        static $id = 0;    // for unique active page input id
        $get = $this->get_qs('_order_by,_desc,_search');
        $active_page = floor($_offset / $limit) + 1; 
        $total_page = ceil($count / $limit);
        $uri_path = $this->get_uri_path();

        if($count <= 0)
            return;

        $use_paging_link = '';
        if($_pagination_off == 1)
            $use_paging_link = "<a href='{$uri_path}_pagination_off=0&$get' rel='nofollow'>$this->pagination_text_use_paging</a>";

        if($_pagination_off == 1 || $count <= $limit) 
            return number_format($count) . " $this->pagination_text_records $use_paging_link";

        // simple text input for page number on giant datasets. use drop-down for smaller datasets.
        if($count > 100000){
            $input = "<input type='text' size='7' id='active_page_$id' value='$active_page' ><input type='button' value='$this->pagination_text_go' onclick='window.location.href=\"{$uri_path}_offset=\" + ((document.getElementById(\"active_page_$id\").value * $limit) - $limit) + \"&$get\"'>";
        }
        else
        {
            $input = "<select onchange='window.location.href=\"{$uri_path}_offset=\" + this.options[this.selectedIndex].value + \"&$get\"'>";
            for($i = 0, $p = 1; $i < $count; $i += $limit, $p++){
                $sel = '';
                if($p == $active_page)
                    $sel .= "selected='selected'";

                $input .= "<option value='$i' $sel>$p</option>";
            }
            $input .= "</select>";
        }        

        $pagination = "$this->pagination_text_page: $input $this->pagination_text_of $total_page &nbsp; ";
        
        if($_offset == 0)
            $pagination .= " $this->pagination_text_back ";
        else
            $pagination .= " <a href='{$uri_path}_offset=" . ($_offset - $limit) . "&$get'>$this->pagination_text_back</a> ";

        if($active_page >= $total_page)
            $pagination  .= " $this->pagination_text_next ";
        else
            $pagination  .= " <a href='{$uri_path}_offset=" . ($_offset + $limit) . "&$get'>$this->pagination_text_next</a> ";

        $pagination .= " &nbsp; " . number_format($count) . " $this->pagination_text_records <a href='{$uri_path}_pagination_off=1&$get' rel='nofollow'>$this->pagination_text_show_all</a> ";

        $id++;
        return $pagination;

    }

    
    function get_qs($query_string_list = '_order_by,_desc,_offset,_search,_pagination_off'){

        // purpose: render querysting. user selections for order, search, and page are carry from page to page. 
        // this maintains search state while paging, updating, etc...

        // append users additions
        if(mb_strlen($this->query_string_list) > 0)
            $query_string_list .= ',' . $this->query_string_list;

        $get = '';
        $arr = explode(',', trim($query_string_list, ','));
        foreach($arr as $var)
            if(mb_strlen(@$_REQUEST[$var]) > 0)
                $get .= "&$var=" . urlencode($_REQUEST[$var]);

        return ltrim($get, '&');

    }

    
    function get_upload($columns, $table_name, $identity_name, $identity_id, $context = 'form', $field_index = ''){

        // purpose: used in insert and update to handle files
        // returns: true on success, false on error

        $upload_width = $this->upload_width;
        $upload_height = $this->upload_height;
        $upload_crop = $this->upload_crop;
        $thumb_width = $this->thumb_width;
        $thumb_height = $this->thumb_height;
        $thumb_crop = $this->thumb_crop;
        $notice = '';

        if($context == 'grid')
            $input_control = $this->grid_input_control;
        else
            $input_control = $this->form_input_control;

        foreach($columns as $column_name){

            $control = @$input_control[$column_name];

            // uploads only
            if(!$this->is_upload($input_control, $column_name))
                continue;

            // inputs are named differently on grids
            $input_name = $column_name;
            if($context != 'form')
                if(mb_strlen($field_index) > 0)
                    $input_name = "$column_name-0"; // inserting
                else
                    $input_name = "$column_name-$identity_id"; // updating 

            if(!file_exists($this->upload_path) && mb_strlen($this->upload_path) > 0){
                mkdir($this->upload_path, 0755);
                usleep(500);
            }

            if(!file_exists($this->thumb_path) && mb_strlen($this->thumb_path) > 0){
                mkdir($this->thumb_path, 0755);
                usleep(500);
            }

            // process file deletion requested by checkbox with field_name + "-delete"
            if(@$_POST[$input_name . '-delete'] == 1)
                $this->upload_delete($table_name, $identity_name, $identity_id, $column_name, $input_control);

            // see if a new file was uploaded
            $file_name = $this->upload_file($input_name, $notice, $field_index);

            // reloop - no new file uploaded
            if(mb_strlen($file_name) == 0)
                continue;    
                
            // delete previous existing file
            $this->upload_delete($table_name, $identity_name, $identity_id, $column_name, $input_control);

            // copy upload to thumbnail path
            if(mb_strlen($this->thumb_path) > 0 && $control == '--image')
                if(!copy("$this->upload_path/$file_name", "$this->thumb_path/$file_name")){
                    $this->display_error("Error: Unable to copy uploaded to thumb_path. Make sure path: $this->thumb_path exists and is writeable. Try chmod 0755 (or 0777 if you must) on the destination path.", 'get_upload()');
                    return false;
                }

            // resize or crop main image
            if($control == '--image')
                if($upload_crop)
                    $this->image_crop("$this->upload_path/$file_name", $upload_width, $upload_height);
                else
                    $this->image_resize("$this->upload_path/$file_name", $upload_width, $upload_height);

            // thumbs - resize or crop 
            if($control == '--image' && mb_strlen($this->thumb_path) > 0)
                if($thumb_crop)
                    $this->image_crop("$this->thumb_path/$file_name", $thumb_width, $thumb_height);
                else
                    $this->image_resize("$this->thumb_path/$file_name", $thumb_width, $thumb_height);

            // update file name in table 
            $sql_param = array();
            $sql = "update `$table_name` set `$column_name` = :file_name where `$identity_name` = :identity_id";
            $sql_param[':file_name'] = $file_name;
            $sql_param[':identity_id'] = $identity_id;
            if($this->query($sql, $sql_param, 'get_upload()') === false)
                return false;

        }

        if(mb_strlen($notice) > 0){
            $this->display_error($notice, 'get_upload()');
            return false;
        }

        return true;

    }


    function upload_file($input_name, &$notice, $field_index = ''){

        // purpose: upload file and return file name as a string
        // returns: file name on success, errors sent back by reference to $notice

         // make regex pattern for extension validation from allow list. it should end up looking like this: /(.\.mp3)|(.\.pdf)$/i
        $pattern = '';
        $arr = preg_split('/\s+/', $this->upload_allow_list);
        foreach($arr as $val)
            $pattern .= '(.' . preg_quote($val) . ')|';

        $pattern = '/' . rtrim($pattern, '|') . '$/i'; 

        // get file info
        if(mb_strlen($field_index) > 0){
            $size = intval($_FILES[$input_name]['size'][$field_index]);
            $tmp_name = $_FILES[$input_name]['tmp_name'][$field_index];
            $file_name = $this->clean_file_name($_FILES[$input_name]['name'][$field_index]);
        }
        else{
            $size = intval($_FILES[$input_name]['size']);
            $tmp_name = $_FILES[$input_name]['tmp_name'];
            $file_name = $this->clean_file_name($_FILES[$input_name]['name']);
        }

        // nothing to do
        if($size <= 0 || mb_strlen($file_name) == 0)
            return;
        
        if(mb_strlen($file_name) > 500){
            $notice .= "File name is too long.\n";
            return;
        }

        if(!preg_match($pattern, $file_name)){
            $notice .= "Invalid file type. Only the following documents and media types are allowed: $this->upload_allow_list\n";
            return;
        }

        $file_name = $this->upload_rename_if_exists($this->upload_path, $file_name);

        if(!move_uploaded_file($tmp_name, "$this->upload_path/$file_name")){
            $notice .= "Error: Unable to move uploaded file. Make sure path: $this->upload_path exists and is writeable. Try chmod 0755 (or 0777 is you must) on the destination path.\n";
            return;
        }

        return $file_name;

    }

    
    function upload_delete($table_name, $identity_name, $identity_id, $field_name = '*', $input_control = array()){

        // purpose: delete uploaded files, called from get_upload()
        // returns: true on success or false on error

        $identity_id = $this->cast_id($identity_id);

        if($field_name != '*')
            $field_name = "`$field_name`";


        // get 1 row of data
        $sql_param = array(':identity_id' => $identity_id);
        $sql = "select $field_name from `$table_name` where `$identity_name` = :identity_id";
        $result = $this->query($sql, $sql_param, 'upload_delete()');

        if(!is_array($result))
            $result = array();

        if(count($result) == 0){
            $this->display_error('Unable to locate record.', 'upload_delete()');
            return false;
        }

        // loop thru fields
        $row = $result[0];
        foreach($row as $column_name => $val){

            if(mb_strlen($val) == 0)
                continue;

            // uploads only
            if(!$this->is_upload($input_control, $column_name))
                continue;

            // delete files
            if(mb_strlen($this->upload_path) > 0)
                @unlink("$this->upload_path/$val");

            if(mb_strlen($this->thumb_path) > 0)
                @unlink("$this->thumb_path/$val");
                    
            // empty field now that file is deleted
            $sql = "update `$table_name` set `$column_name` = null where `$identity_name` = :identity_id;";
            $result = $this->query($sql, $sql_param, 'upload_delete()');                
            if($result === false)
                return false;
                
        }
    
        return true;
    
    }


    function upload_rename_if_exists($path, $file_name){

        // purpose: return a new file name if file exists; foo.pdf returns foo_2.pdf then foo_3.pdf, etc...
        
        while(file_exists("$path/$file_name")){

            $number = 2;

            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $prefix = mb_substr($file_name, 0, mb_strlen($file_name) - mb_strlen($ext) - 1);

            // extract and increment number at the end of the prefix
            preg_match('/_([0-9]+)$/', $prefix, $matches);
            if(count($matches) == 2){
                $prefix = mb_substr($prefix, 0, mb_strlen($prefix) - mb_strlen($matches[0]));
                $number = $matches[1];
                $number++;
            }

            $file_name = "{$prefix}_{$number}.{$ext}";

        }    

        return $file_name;

    }
    

    function image_resize($file_name, $max_width, $max_height, $output_to_browser = false){

        // purpose: resize image but keep orignal aspect ratio.  if output_to_browser = false, then file is altered and saved. 
        // returns: nothing 

        $ext = mb_strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if(!($ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'png'))
            return;

        list($orig_width, $orig_height) = getimagesize($file_name);

        // invalid image or nothing to do
        if($orig_width == 0 || $orig_height == 0 || $max_width == 0 || $max_height == 0)
            return;            

        // image is already smaller than maximum size
        if($orig_width <= $max_width && $orig_height <= $max_height)
            return;            

        $width = $orig_width;
        $height = $orig_height;

        // taller
        if($height > $max_height){
            $width = ($max_height / $height) * $width;
            $height = $max_height;
        }

        // wider
        if($width > $max_width){
            $height = ($max_width / $width) * $height;
            $width = $max_width;
        }

        $image_p = @imagecreatetruecolor($width, $height);

        if($ext == 'gif')
            $image = @imagecreatefromgif($file_name);
        elseif($ext == 'png')
            $image = @imagecreatefrompng($file_name);
        else
            $image = @imagecreatefromjpeg($file_name);

        @imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $orig_width, $orig_height);

        if($output_to_browser){

            if($ext == 'gif'){
                header('Content-type: image/gif');
                @imagegif($image_p);
            }
            elseif($ext == 'png'){
                header('Content-type: image/png');
                @imagepng($image_p);
            }
            else{
                header('Content-type: image/jpeg');
                @imagejpeg($image_p, '', $this->image_quality); 
            }
        
        }
        else{

            if($ext == 'gif')
                @imagegif($image_p, $file_name);
            elseif($ext == 'png')
                @imagepng($image_p, $file_name);
            else
                @imagejpeg($image_p, $file_name, $this->image_quality); 

        }

    }


    function image_crop($file_name, $desired_width, $desired_height, $output_to_browser = false){

        // purpose: crop image changes aspect ratio to match the requested dimensions. if output_to_browser = false, then file is altered and saved. 
        // returns: nothing

        $ext = mb_strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if(!($ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'png'))
            return;

        // get new dimensions
        list($width, $height) = getimagesize($file_name);

        // nothing to do
        if($height == 0 || $width == 0 || $desired_height == 0 || $desired_width == 0)
            return;

        // nothing to do
        if($height == $desired_height && $width == $desired_width && $output_to_browser == false)
            return;

        if($desired_width / $desired_height > $width / $height){
            $new_width = $desired_width;
            $new_height = $height * ($desired_width / $width);
        }
        else{
            $new_width = $width * ($desired_height / $height);
            $new_height = $desired_height;
        }

        // resize
        $image_p = @imagecreatetruecolor($new_width, $new_height);
        $image_f = @imagecreatetruecolor($desired_width, $desired_height);

        if($ext == 'png')
            $image = @imagecreatefrompng($file_name);    
        elseif($ext == 'gif')
            $image = @imagecreatefromgif($file_name);    
        else
            $image = @imagecreatefromjpeg($file_name);

        @imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        // top center cropping
        $x = ($new_width - $desired_width) / 2;
        $y = ($new_height - $desired_height) / 5;

        @imagecopyresampled($image_f, $image_p, 0, 0, $x, $y, $desired_width, $desired_height, $desired_width,  $desired_height);

        // save or output
        if($output_to_browser){

            if($ext == 'gif'){
                header('Content-type: image/gif');
                @imagegif($image_f);
            }
            elseif($ext == 'png'){
                header('Content-type: image/png');
                @imagepng($image_f);
            }
            else{
                header('Content-type: image/jpeg');
                @imagejpeg($image_f, '', $this->image_quality); 
            }
        
        }
        else{

            if($ext == 'gif')
                @imagegif($image_f, $file_name);
            elseif($ext == 'png')
                @imagepng($image_f, $file_name);
            else
                imagejpeg($image_f, $file_name, $this->image_quality); 

        }

    }

    
    function display_error($error, $source_function){
        
        // purpose: display errors to user.

        $msg = nl2br($this->clean_out("Error: $error\nSent From: $source_function"));
        echo "<div class='lm_error'>$msg</div>" ;

    }


    function query($sql, $sql_param = array(), $source_function = '', $display_error = true){

        // purpose: wrapper for pdo db call
        // returns: returns array of results, an empty array for no results, or false on error

        if(!$this->set_names){
            $sth = $this->dbh->prepare("set names $this->charset_mysql");
            $sth->execute();
            $this->set_names = true;
        }

        $sth = $this->dbh->prepare($sql);

        if(!$sth->execute($sql_param)){
            $arr = $sth->errorInfo();
            $error = $arr[2];
            if($display_error)
                $this->display_error("$error\nsql: $sql\narr_sql_param: " . print_r($sql_param, true), $source_function);

            return false;
        }

        if(preg_match('/^insert/i', ltrim($sql)))
            return $this->cast_id($this->dbh->lastInsertId());

        if($sth->columnCount() == 0)
            return array();    
        else    
            return $sth->fetchAll(PDO::FETCH_ASSOC);

    }


    function safe_np($named_parameter){

        // purpose: remove illegal characters from pdo named parameter (w/o colon).
        // returns: string

        return preg_replace('/[^a-zA-Z0-9_]/', '', $named_parameter);
            
    }
    

    function redirect($url, $automatic = true){

        // purpose: redirect user to url
        // returns: html redirect
        // if $automatic is false user has to click "continue" to proceed. 

        if($automatic === false){
            echo("<center><a href='$url'>Continue</a></center>");    
            return;
        }
        
        // this feature is only used used with WordPress plugins - use a simple js redirect for WP
        // or if $this->redirect_using_js is true
        if(mb_strlen($this->uri_path) > 0 ||
            $this->redirect_using_js ){
            echo "<script>window.location.href='$url';</script>";
            return;
        }
       

        $port = '';    
        $host = preg_replace('/:[0-9]+$/', '', $_SERVER['HTTP_HOST']); // host without port number
        $protocol = 'http://';
        if(@$_SERVER['HTTPS'] != '' && @$_SERVER['HTTPS'] != 'off')
            $protocol = 'https://';
        if(!($_SERVER['SERVER_PORT'] == '80' || $_SERVER['SERVER_PORT'] == '443'))
            $port = ':' . $_SERVER['SERVER_PORT'];
        if(!isset($_SESSION))
            session_write_close();
        
        header("Location: $protocol$host$port$url");
        die;
    
    }


    function get_uri_path(){

        // purpose: get request uri without the querystring but with query delimiter. user can also specify a URI.
        // returns: uri path string

        static $uri_path = false;
        
        // user defined uri
        if(mb_strlen($this->uri_path) > 0){
                
            if(mb_strstr($this->uri_path, '?'))    
                $uri_path = $this->uri_path . '&'; // if user specifies URI, it may already have a ?
            else
                $uri_path = $this->uri_path . '?';
        }

        if($uri_path)
            return $uri_path;

        $arr = parse_url($_SERVER['REQUEST_URI']);
        $uri_path = $arr['path'];

        if($uri_path == '')
            $uri_path = '/';

        $uri_path = $uri_path . '?';

        return $uri_path;

    }


    function get_class_name($input_name){

        // purpose: generate class name from form input name; remove '-id' or '[]' suffix 
        // returns: string    

        return 'lm_' . preg_replace('/(-[0-9]+)|(\[\])$/', '', $input_name);

    }


    function is_upload(&$input_control, &$column_name){

        // purpose: see if column is an upload type
        // returns: boolean

        if(@$input_control[$column_name] == '--image' || @$input_control[$column_name] == '--document')
            return true;

        return false;

    }

    
    function export(&$result, $columns){

        // purpose: send database result in CSV format to browser. 

        if(mb_strlen($this->export_csv_file_name) > 0)
            $file_name = $this->export_csv_file_name;
        elseif(mb_strlen($this->table) > 0)
            $file_name = $this->clean_file_name($this->table . '.csv');
        else
            $file_name = 'download.csv';

        // output buffering required
        $level = 0;
        $arr = ob_get_status(true);
        if($arr)
            $level = count($arr);

        if($level <= 0){
            $error = "ob_start() or ob_start('ob_gzhandler') must be called at the beginning of the script to use CSV Export.";
            $this->display_error($error, 'export()');
            return;
        }

        // erase any existing buffers
        while($level >= 1 ){
            ob_end_clean();
            $level--;
        }

        if(!ob_start('ob_gzhandler'))
            ob_start();

        header("Cache-Control: maxage=1");
        header("Pragma: public");
        header("Content-Type: application/csv");
        header("Content-Disposition: attachment; filename=$file_name");

        // remove last column if last column is the identity that holds the [edit] and [delete] links
        if(end($columns) == $this->identity_name)
             array_pop($columns);
           
        // header row    
        $column_index = 0;
        foreach($columns as $key => $val)
            echo $this->export_escape($val, $column_index++);

        echo "\n";

        // loop thru data
        foreach($result as $row){

            $column_index = 0;
            foreach($columns as $val)
                echo $this->export_escape($row[$val], $column_index++);

            echo "\n";
            
        }

        ob_end_flush();
        die();

    }

    
    function export_escape($str, $column_index){

        // purpose: escape for export()
        // returns: separated and escaped string

        $str = str_replace($this->export_delim, $this->export_delim_escape . $this->export_delim, $str);

        if($column_index == 0)
            return $this->export_delim . $str . $this->export_delim; 
        else
            return $this->export_separator . $this->export_delim . $str . $this->export_delim; 

    }


    function validate(&$validate){

        // purpose: run validation
        // return false if any input fails validation
        // alters the $validate array adding bool flag corresponding to column name

        // $validate is an array of arrays
        // [0] string  $regexp_or_user_function
        // [1] string  $error_message
        // [2] string  $tip_placeholder
        // [3] boolean $optional_input
        // [4] boolean - holds result from validation process - false means input failed validation 

        $columns = $this->get_columns('form');
        $all_valid = true;

        foreach($columns as $column_name){
            
            $regexp_or_user_func = @$validate[$column_name][0];
            
            if($regexp_or_user_func == '')
                continue;

            $val = @$_POST[$column_name];
            if(is_array($val))
                $val = implode($this->delim, $val);
            $val = trim($val);

            // don't validate empty optional parameters
            if(@$validate[$column_name][3] === true && $val == '')
                continue;

            if($regexp_or_user_func == 'email')
                $is_valid = filter_var($val, FILTER_VALIDATE_EMAIL);
            elseif(mb_substr($regexp_or_user_func, 0, 1) != '/')
                $is_valid = call_user_func($regexp_or_user_func);
            else
                $is_valid = preg_match($regexp_or_user_func, $val);

            $validate[$column_name][4] = (bool)$is_valid;
            
            // add error msg if missing for some reason
            if(@$validate[$column_name][1] == '')
                $validate[$column_name][1] == 'Missing or Invalid Input';

            if(!$is_valid)
                $all_valid = false;
        }

        return $all_valid;

    }

}
