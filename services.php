<?php
	$GLOBALS['THRIFT_ROOT'] = dirname(__FILE__) . '/phpcassa/thrift/';
	require_once $GLOBALS['THRIFT_ROOT'].'/packages/cassandra/Cassandra.php';
	require_once $GLOBALS['THRIFT_ROOT'].'/transport/TSocket.php';
	require_once $GLOBALS['THRIFT_ROOT'].'/protocol/TBinaryProtocol.php';
	require_once $GLOBALS['THRIFT_ROOT'].'/transport/TFramedTransport.php';
	require_once $GLOBALS['THRIFT_ROOT'].'/transport/TBufferedTransport.php';
	
	include_once(dirname(__FILE__) . '/phpcassa/phpcassa.php');
	include_once(dirname(__FILE__) . '/phpcassa/uuid.php');	
	
	class AddressBookService {
				
		static private $cfAddress = null;
		static private $nodes = array();
		
		static protected function generateUUID() {
			return UUID::generate(UUID::UUID_TIME, UUID::FMT_BINARY);			
		}
		
		static public function addNode($host, $port) {
			self::$nodes[] = array('host' => $host, 'port' => $port);
		} 
		
		static public function connect() {
			foreach (self::$nodes as $node) {
				CassandraConn::add_node($node['host'], $node['port']);	
			}
			self::loadColumnFamilies();
		}	
				
		static public function loadColumnFamilies() {
			self::$cfAddress = new CassandraCF('AddressBook', 'Addresses');
		}				
		
		static public function insert(Address $address) {
			try {
				self::$cfAddress->insert('hasan', 
				array(self::generateUUID() => $address->serialize()));
				return true;
			} catch (Exception $e) {
				var_dump($e);
				return false;
			}			
		}
		
		static public function findAll() {
			try {
				$addresses = array();
				$items = self::$cfAddress->get('hasan');
				if (!empty($items)) {
					foreach ($items as $key => $item) {
						if (!empty($item)) {
							$address = Address::deserialize($item);
							$address->setId($key);
							$addresses[] = $address;
						}
					}
				}
				
				return $addresses;
			} catch (Exception $e) {
				var_dump($e);
				return array();
			}
		}
		
		static public function find($id) {
			try {
				self::$cfAddress->get('hasan', UUID::convert($id, UUID::FMT_STRING, UUID::FMT_BINARY));
			} catch (Exception $e) {
				var_dump($e);
				return false;
			}
		}
		
		static public function remove($id) {
			try {
				self::$cfAddress->remove('hasan', UUID::convert($id, UUID::FMT_STRING, UUID::FMT_BINARY));
				return true;
			} catch (Exception $e) {
				var_dump($e);
				return false;
			}
		}
	}
?>