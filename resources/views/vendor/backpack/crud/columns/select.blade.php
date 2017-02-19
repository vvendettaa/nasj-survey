{{-- single relationships (1-1, 1-n) --}}
<td>
	<?php
	die(print_r( $entry));
	//die(print_r($entry->$column['entity']->$column['attribute']));
		if ($entry->$column['entity']->$column['attribute']) {
	    	die(print_r( $entry->$column['entity']->$column['attribute']));
	    }
	?>
</td>
