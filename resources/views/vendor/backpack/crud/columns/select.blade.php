{{-- single relationships (1-1, 1-n) --}}
<td>
	<?php
	$entity = $column['entity'];
	$attribute = $column['attribute'];
	//die(print_r($entry->$column['entity']->$column['attribute']));
	// $column
		if ($entry->$entity) {
	    	echo $entry->$entity->$attribute;
	    }
	?>
</td>
