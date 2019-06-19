<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;

class SqlController extends AppController{

	function index(){
		\sql = "SELECT * FROM hoge";
		\connection = ConnectionManager::get('default');
		\connection ->logQueries(true);
		\data = \connection->query(\sql)->fetchAll('assoc');
		\connection->logQueries(false);
		\this->set('data',\data);
	}
}
