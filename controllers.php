<?php
	class Controller {
		
		public $flash = array();
		private $attributes = array();
				
		public function insert() {
			$address = new Address($_POST['name'], $_POST['phone']);
			if (AddressBookService::insert($address)) {			
				$this->addNotice('notice', 'Successfully added new address.');
				$this->redirectTo('index');
			} else {
				$this->addNotice('notice', 'Failed to add new address.');
				$this->renderView('index');
			}						
		}
		
		public function edit() {
			$address = AddressBookService::find($_GET['id']);
			if ($address) {
				$this->set('ediable_address', $address);
				$this->renderView('index');
			} else {
				$this->addNotice('notice', 'Failed to edit your content');
				$this->redirectTo('index');
			}
		}
		
		public function remove() {
			if (AddressBookService::remove($_GET['id'])) {
				$this->addNotice('notice', 'Successfully removed!');
				$this->redirectTo('index');
			} else {
				$this->addNotice('notice', 'Failed to remove');
				$this->redirectTo('index');
			}
		}
		
		public function index() {
			$this->set('addresses', AddressBookService::findAll());
			$this->renderView('index');
		}
				
		protected function set($key, $value) {
			$this->attributes[$key] = $value;
			return $this;
		}
		
		protected function get($key) {
			return $this->attributes[$key];
		}
		
		protected function addNotice($key, $value) {
			$_SESSION['flash' . $key] = $value;
		}
		
		protected function getNotice($key) {
			if (in_array('flash' . $key, $_SESSION)) {
				$notice = $_SESSION['flash' . $key];
				if (!empty($notice)) {
					unset($_SESSION['flash' . $key]);
				}
				return $notice;
			} else {
				return false;
			}
		}
		
		private function renderView($viewFile) {
			include 'views/' . $viewFile . '.html.php';
		}
		
		private function redirectTo($pathOrAction) {
			if (method_exists($this, $pathOrAction)) {
				header('Location: ' . 'index.php?perform=' . $pathOrAction);
			} else {
				header('Location: ' . $pathOrAction);
			}
		}
		
		public function dispatch($action = NULL) {
			if ($action == NULL || empty($action)) {
				$this->index();
			} else if (!empty($action)) {
				$this->$action();
			}
		}
	}
?>