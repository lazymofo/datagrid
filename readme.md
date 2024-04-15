
**[Full HTML Documentation](https://htmlpreview.github.io/?https://github.com/lazymofo/datagrid/blob/master/index.html)**
 | 
**[Live Demo](http://lazymofo.pcmad.ro)**
 | 
**[A related simlar project - PHP Bootstrap Table Edit](https://github.com/PHPBootstrapTableEdit/PHPBootstrapTableEdit)**

![logo](https://i.imgur.com/CGDTkQL.png)

Lazy Mofo (LM) PHP Datagrid - MIT License
=========================================

LM is a single PHP class for performing CRUD (create, read, update and delete) operations on a MySQL database table.

**No new features will be added, this project is in maintenance mode.**

- Define grids and forms by SQL statements or table name
- Populate select, radio, and checkbox inputs with data from SQL statements
- Upload documents, resize or crop images
- Grid features include pagination, sorting, and inline editing. Searching can be added.
- Grid uses SQL_CALC_FOUND_ROWS, limit + offset for efficiency and low memory usage on large datasets
- Built-in validation, error reported next to input
- i18n/internationalization enabled. See i18n/template.php to submit your language-county file.
- Lightweight; a single class

![grid](https://i.imgur.com/wHUpMan.png)
![form](https://i.imgur.com/ig6ci5R.png)


Requirements
============
- PHP 7+ and MySQL/MariaDB
- PHP Modules: mysql, mbstring, gd
- Database table must have an auto increment primary key identity


Example - Advanced Usage
==========================
```
// enter your database host, name, username, and password
$db_host = 'localhost';
$db_name = 'test';
$db_user = 'root';
$db_pass = '';


// connect with pdo 
try {
	$dbh = new PDO("mysql:host=$db_host;dbname=$db_name;", $db_user, $db_pass);
}
catch(PDOException $e) {
	die('pdo connection error: ' . $e->getMessage());
}


// create LM object, pass in PDO connection, see i18n folder for country + language options 
$lm = new lazy_mofo($dbh, 'en-us');


// table name for updates, inserts and deletes
$lm->table = 'market';


// identity / primary key for table
$lm->identity_name = 'market_id';


// optional, make friendly names for fields
$lm->rename['country_id'] = 'Country';


// optional, define input controls on the form
$lm->form_input_control['photo'] = array('type' => 'image');
$lm->form_input_control['is_active'] = array('type' => 'radio', 'sql' => "select 1, 'Yes' union select 0, 'No'");
$lm->form_input_control['country_id'] = array('type' => 'select', 'sql' => 'select country_id, country_name from country');


// optional, define editable input controls on the grid
$lm->grid_input_control['is_active'] = array('type' => 'checkbox');


// optional, define output control on the grid 
$lm->grid_output_control['contact_email'] = array('type' => 'email'); // make email clickable
$lm->grid_output_control['photo'] = array('type' => 'image');         // make image clickable  


// show search box, but _search parameter still needs to be passed to query below 
$lm->grid_show_search_box = true;


// query to define grid view
// IMPORTANT - last column must be the identity/key for [edit] and [delete] links to appear
// include an 'order by' to prevent potential parsing issues
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
where coalesce(m.market_name, '')   like :_search 
or    coalesce(m.contact_email, '') like :_search 
or    coalesce(c.country_name, '')  like :_search 
order by m.market_id desc
";


// bind parameter for grid query
$lm->grid_sql_param[':_search'] = '%' . trim($_REQUEST['_search'] ?? '') . '%';


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


// bind parameter for form query
$lm->form_sql_param[':market_id'] = intval($_REQUEST['market_id'] ?? 0); 


// optional, validation - regexp, 'email' or a user defined function, all other parameters optional 
$lm->on_insert_validate['market_name']   = array('regexp' => '/.+/',  'error_msg' => 'Missing Market Name', 'placeholder' => 'this is required', 'optional' => false); 
$lm->on_insert_validate['contact_email'] = array('regexp' => 'email', 'error_msg' => 'Invalid Email',       'placeholder' => 'this is optional', 'optional' => true);


// copy validation rules, same rules when updating
$lm->on_update_validate = $lm->on_insert_validate;  


// run the controller
$lm->run();

```    
**[Full HTML Documentation](https://rawgit.com/lazymofo/datagrid/master/index.html)**

**[Live Demo](http://lazymofo.pcmad.ro)**
