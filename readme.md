
Lazy Mofo Data Grid
===================

project home, demo and documentation: [http://lazymofo.wdschools.com/](http://lazymofo.wdschools.com/)
MIT License

What is Lazy Mofo (LM) PHP Datagrid?
====================================

LM is a single PHP5 class for performing CRUD (create, read, update and delete) operations on a MySQL database table.
What can LM do?

-   Define grids and forms by SQL statements or table name
-   Populate select, radio, and checkbox inputs with data from SQL statements
-   Upload documents, resize or crop images
-   Grid features include pagination, sorting, and inline editing. Searching can be added.
-   Grid uses SQL_CALC_FOUND_ROWS, limit + offset for efficiency and low memory usage on large datasets
-   LM can be used for reporting since grids can be generated from SQL statements
-   Built-in validation, error reported next to input
-   Lightweight; a single class

What's New
==========
-   Added cast_user_function to define function to cast a specified column.
-   Added MySQL BigInt support for identity columns.
-   Removed child grid features. Sorry, I found the UI for the child records awkward. Back to simplicity.
-   Removed automatic searching. Search queries must now be defined manually.
-   Added validation using regular expressions. Error messages are displayed next to the input.
-   Removed Picnic CSS

Requirements
============

-   PHP 5+ and MySQL 5
-   Magic Quotes should be turned off
-   PDO MySQL module installed for PHP
-   Database table must have a primary key identity
-   Multibyte Support / mbstring must be enabled


Example 1 - Basic Usage
=======================

    include('lazy_mofo.php');

    // required for csv export
    ob_start();

    // connect to database with pdo
    $dbh = new PDO("mysql:host=localhost;dbname=test;", 'user', 'password');

    // create LM object, pass in PDO connection
    $lm = new lazy_mofo($dbh); 

    // table name for updates, inserts and deletes
    $lm->table = 'market';

    // identity / primary key column name
    $lm->identity_name = 'market_id';

    // use the lm controller 
    $lm->run();


Example 2 - Advanced Usage
==========================

    include('lazy_mofo.php');


    // required for csv export
    ob_start();


    // connect with pdo 
    $dbh = new PDO("mysql:host=localhost;dbname=testdb;", "username", "password");


    // create LM object, pass in PDO connection
    $lm = new lazy_mofo($dbh); 


    // table name for updates, inserts and deletes
    $lm->table = 'market';


    // identity / primary key for table
    $lm->identity_name = 'market_id';


    // optional, make friendly names for fields
    $lm->rename['country_id'] = 'Country';


    // optional, define input controls on the form
    $lm->form_input_control['photo'] = '--image';
    $lm->form_input_control['is_active'] = "select 1, 'Yes' union select 0, 'No' union select 2, 'Maybe'; --radio";
    $lm->form_input_control['country_id'] = 'select country_id, country_name from country; --select';


    // optional, define editable input controls on the grid
    $lm->grid_input_control['is_active'] = '--checkbox';


    // optional, define output control on the grid 
    $lm->grid_output_control['contact_email'] = '--email'; // make email clickable
    $lm->grid_output_control['photo'] = '--image'; // image clickable  


    // new in version >= 2015-02-27 all searches have to be done manually
    $lm->grid_show_search_box = true;


    // optional, query for grid(). LAST COLUMN MUST BE THE IDENTITY for [edit] and [delete] links to appear
    $lm->grid_sql = "
    select 
      m.market_id
    , m.market_name
    , m.photo
    , m.contact_email
    , c.country_name
    , m.is_active
    , m.create_date
    , m.market_id 
    from  market m 
    left  
    join  country c 
    on    m.country_id = c.country_id 
    where coalesce(m.market_name, '') like :_search 
    or    coalesce(m.contact_email, '') like :_search 
    or    coalesce(c.country_name, '') like :_search 
    order by m.market_id desc
    ";
    $lm->grid_sql_param[':_search'] = '%' . trim(@$_REQUEST['_search']) . '%';


    // optional, define what is displayed on edit form. identity id must be passed in also.  
    $lm->form_sql = "
    select 
      market_id
    , market_name
    , country_id
    , photo
    , contact_email
    , is_active
    , create_date
    , notes 
    from  market 
    where market_id = :market_id
    ";

    $lm->form_sql_param[":$lm->identity_name"] = @$_REQUEST[$lm->identity_name]; 


    // optional, validation. input:  regular expression (with slashes), error message, tip/placeholder
    // first element can also be a user function or 'email'
    $lm->on_insert_validate['market_name'] = array('/.+/', 'Missing Market Name', 'this is required'); 
    $lm->on_insert_validate['contact_email'] = array('email', 'Invalid Email', 'this is optional', true); 


    // copy validation rules to update - same rules
    $lm->on_update_validate = $lm->on_insert_validate;  


    // use the lm controller
    $lm->run();
  
    
project home and documentation: [http://lazymofo.wdschools.com/](http://lazymofo.wdschools.com/)
   