<?php
	class Address {
		private $name;
		private $phone;
		private $id;
		
		public function __construct($name, $phone) {
			$this->name = $name;
			$this->phone = $phone;
		}
		
		public function getName() { return $this->name; }
		public function getPhone() { return $this->phone; }
		
		public function setId($id) { $this->id = $id; }
		public function getId() { return $this->id; }
		
		public function toMap() {
			return array('name' => $this->name, 'phone' => $this->phone);
		}
		
		public function serialize() {
			return "array('name' => \"" . addslashes($this->name) . "\"," .
				   " 'phone' => \"" . addslashes($this->phone) . "\")";
		}
		
		public function toGUID() {
			return UUID::convert($this->id, UUID::FMT_BINARY, UUID::FMT_STRING);
		}
		
		static public function deserialize($serialized) {			
			$fields = array();
			eval('$fields = ' . $serialized . ";");
			$address = new Address($fields['name'], $fields['phone']);
			return $address;
		}
	}
?>