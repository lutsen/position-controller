<?php

namespace Lagan\Property;

/**
 * Controller for the Lagan position property.
 * Makes room for the newly positioned Redbean bean by updating the positions of other beans,
 * and returns the new position of the bean.
 *
 * A property type controller can contain a set, read, delete and options method. All methods are optional.
 * To be used with Lagan: https://github.com/lutsen/lagan
 */

class Position {

	/**
	 * The set method is executed each time a property with this type is set.
	 *
	 * @param bean		$bean		The Redbean bean object with the property.
	 * @param array		$property	Lagan model property arrray.
	 * @param integer	$new_value	The input position of the object with this property.
	 *
	 * @return integer	The new position of the object with this property.
	 */
	public function set($bean, $property, $new_value) {

		if ( !empty($new_value) || $new_value === 0 || $new_value === '0' ) {
			$new_value = intval( $new_value ); // Convert to integer
		}

		$all = \R::findAll( $bean->getMeta('type') );
		$count_all = \R::count( $bean->getMeta('type') );
		$curr_value = $bean->{ $property['name'] };
		
		// New bean
		if ( empty($curr_value) && $curr_value !== 0 && $curr_value !== '0' ) {
		
			// Position at the bottom
			$curr_value = $count_all;
		
		}
		
		// No new input
		if ( ( empty($new_value) && $new_value !== 0 ) || $new_value == $curr_value ) {
		
			return $curr_value;
		
		} else {
		
			if ( $new_value < 0 ) $new_value = 0;
			if ( $new_value > $count_all - 1 ) $new_value = $count_all - 1;
			if ( $new_value < $curr_value ) {
				foreach ( $all as $b ) {
					if ($b->{ $property['name'] } >= $new_value AND $b->{ $property['name'] } < $curr_value) {
						$b->{ $property['name'] } = $b->{ $property['name'] } + 1;
						$b->modified = \R::isoDateTime();
						\R::store($b);
					}
				}
			} else if ( $new_value > $curr_value ) {
				foreach ( $all as $b ) {
					if ( $b->{ $property['name'] } <= $new_value AND $b->{ $property['name'] } > $curr_value ) {
						$b->{ $property['name'] } = $b->{ $property['name'] } - 1;
						$b->modified = \R::isoDateTime();
						\R::store($b);
					}
				}
			}
		
			return $new_value;
		
		}

	}

	/**
	 * The delete method is executed each time a an object with a property with this type is deleted.
	 *
	 * @param bean		$bean		The Redbean bean object with the property.
	 * @param array		$property	Lagan model property arrray.
	 */
	public function delete($bean, $property) {

		$count_all = \R::count( $bean->getMeta('type') );
		$bottom = $count_all - 1;
		$this->set($bean, $property, $bottom ); // No need to store new position of this bean

	}

}

?>