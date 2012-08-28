<?php 
/* SVN FILE: $Id$ */
/* Ticket Fixture generated on: 2009-09-23 12:09:15 : 1253719455*/

class TicketFixture extends CakeTestFixture {
	var $name = 'Ticket';
	var $table = 'tickets';
	
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
			'instit_id' => array('type'=>'integer', 'null' => false),
			'user_id' => array('type'=>'integer', 'null' => false),
			'observacion' => array('type'=>'text', 'null' => false, 'length' => 1073741824),
			'estado' => array('type'=>'integer', 'null' => false, 'default' => 0),
			'created' => array('type'=>'datetime', 'null' => true),
			'modified' => array('type'=>'datetime', 'null' => true)/*,
			'indexes' => array('0' => array())*/
			);
			
	var $records = array(array(
			'id'  => 1,
			'instit_id'  => 1,
			'user_id'  => 1,
			'observacion'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,
									phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,
									vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,
									feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.
									Orci aliquet, in lorem et velit maecenas luctus, wisi nulla at, mauris nam ut a, lorem et et elit eu.
									Sed dui facilisi, adipiscing mollis lacus congue integer, faucibus consectetuer eros amet sit sit,
									magna dolor posuere. Placeat et, ac occaecat rutrum ante ut fusce. Sit velit sit porttitor non enim purus,
									id semper consectetuer justo enim, nulla etiam quis justo condimentum vel, malesuada ligula arcu. Nisl neque,
									ligula cras suscipit nunc eget, et tellus in varius urna odio est. Fuga urna dis metus euismod laoreet orci,
									litora luctus suspendisse sed id luctus ut. Pede volutpat quam vitae, ut ornare wisi. Velit dis tincidunt,
									pede vel eleifend nec curabitur dui pellentesque, volutpat taciti aliquet vivamus viverra, eget tellus ut
									feugiat lacinia mauris sed, lacinia et felis.',
			'estado'  => 0,
			'created'  => '2009-09-23 12:24:15',
			'modified'  => '2009-09-23 12:24:15'
			));
}
?>