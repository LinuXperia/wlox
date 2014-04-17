<?php
class object {
}

$CFG = new object ( );

$CFG->baseurl = "http://www.1btcxe.com/";
$CFG->sslurl = "";
$CFG->dbhost = "localhost";
$CFG->dbname = "1btcxe";
$CFG->dbuser = "1btcxedb";
$CFG->dbpass = "KfRnwWsS8uTuXDHp";

$CFG->dirroot = "/var/www/htdocs/";
$CFG->libdir = "../lib";
$CFG->self = basename($_SERVER['SCRIPT_FILENAME']);
$CFG->fck_baseurl = $CFG->baseurl;

/* debugging */
$DB_DEBUG = true;
$DB_DIE_ON_FAIL = true;

/* Load up standard libraries */
require_once ("../shared2/autoload.php");

/* Connect to the database */
db_connect($CFG->dbhost,$CFG->dbname,$CFG->dbuser,$CFG->dbpass);

/* Create new object of class */
$ses_class = new Session();

/* Change the save_handler to use the class functions */
session_set_save_handler(array(&$ses_class, '_open' ), array (&$ses_class, '_close' ), array (&$ses_class, '_read' ), array (&$ses_class, '_write' ), array (&$ses_class, '_destroy' ), array (&$ses_class, '_gc' ) );
session_start ();
Session::deleteExpired();
//ini_set('session.cookie_httponly',true);

/* Load settings and timezone */
Settings::assign ($CFG);
date_default_timezone_set($CFG->default_timezone);
$dtz = new DateTimeZone($CFG->default_timezone);
$dtz1 = new DateTime('now', $dtz);
$CFG->timezone_offset = $dtz->getOffset($dtz1);
$CFG->pass_regex = '/[\p{L}!@#$%&*?+-_.=| ]{8,}/';

/* Language */
$lang = ereg_replace("[^a-z]", "",$_REQUEST['lang']);
if ($lang)  {
	$_SESSION['language'] = $lang;
}
$CFG->language = ($lang) ? $lang : ereg_replace("[^a-z]", "",$_SESSION['language']);
$CFG->language = (empty($CFG->language)) ? 'en' : $CFG->language;
$CFG->lang_table = Lang::getTable();

/* Currencies */
$CFG->currencies = Currencies::get();

/* Constants */
$CFG->btc_currency_id = 28;
$CFG->order_type_bid = 1;
$CFG->order_type_ask = 2;
$CFG->transactions_buy_id = 1;
$CFG->transactions_sell_id = 2;
$CFG->request_widthdrawal_id = 1;
$CFG->request_pending_id = 1;
$CFG->request_deposit_id = 2;
$CFG->request_awaiting_id = 4;
$CFG->request_withdrawal_id = 1;
$CFG->request_pending_id = 1;
$CFG->request_completed_id = 2;
$CFG->request_cancelled_id = 3;
$CFG->deposit_bitcoin_desc = 4;
$CFG->withdraw_fiat_desc = 1;
$CFG->withdraw_btc_desc = 2;
$CFG->default_fee_schedule_id = 1;
$CFG->req_img = '<em>*</em>';

/* Bitcoin */
$CFG->bitcoin_username = '1btcxe';
$CFG->bitcoin_accountname = '1btcxe';
$CFG->bitcoin_passphrase = 'refjwygQ9EkF7a52fzfStqLA';
$CFG->bitcoin_host = 'localhost';
$CFG->bitcoin_port = 8332;
$CFG->bitcoin_protocol = 'http';
$CFG->bitcoin_reserve_ratio = 0.1;
$CFG->bitcoin_reserve_min = 1;
$CFG->bitcoin_directory = '/home/bitcoin/bin/64/';
$CFG->bitcoin_sending_fee = 0.0001;
$CFG->bitcoin_warm_wallet_address = 'mgBPeyC22D8ppFnNY6zCHar7okGMj74JD6';

/* API Keys */
$CFG->quandl_api_key = 'ia3sRpJxZwssqVTEFA1y';
$CFG->authy_api_key = 'b218b2b72cb5ca05e90126b3643e44b8';
$CFG->freshdesk_key = 'e4d6a2827176ca3852f3a77c767d3c36';

/* Log In/Out */
User::logIn($_REQUEST['login']['user'],$_REQUEST['login']['pass'],'site','1btcxe_user');
User::logOut($_REQUEST['log_out']);

?>