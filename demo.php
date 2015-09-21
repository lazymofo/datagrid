<?php
/*
-- sample sql script to populate database for demo

create table if not exists country
( country_id int unsigned not null auto_increment primary key
, country_name varchar(255)
) character set utf8 collate utf8_general_ci;

insert into country(country_name) values ('Canada'), ('United States'), ('Mexico');

create table if not exists market
( market_id int unsigned not null auto_increment primary key
, market_name varchar(255)
, photo varchar(255)
, contact_email varchar(255)
, country_id int unsigned
, is_active tinyint(1)
, create_date date
, notes text
) character set utf8 collate utf8_general_ci;

insert into market(market_name, contact_email, country_id, is_active, create_date, notes) values 
('Great North', 'jane@superco.com', 1, 1, curdate(), 'nothing new'),
('The Middle', 'sue@superco.com', 2, null, '2001-01-01', 'these are notes'),
('Latin Market', 'john@superco.com', 1, 1, '1999-10-31', 'expanding soon');

*/

error_reporting(E_ALL);

// speed things up with gzip plus ob_start() is required for csv export
if(!ob_start('ob_gzhandler'))
	ob_start();

header('Content-Type: text/html; charset=utf-8');

include('lazy_mofo.php');

echo "
<!DOCTYPE html>
<html>
<head>
	<meta charset='UTF-8'>
	<link rel='stylesheet' type='text/css' href='style.css'>
</head>
<body>
"; 


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


echo "</body></html>";