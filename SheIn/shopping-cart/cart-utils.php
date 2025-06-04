<?php
/**
 * Checks whether the quantity specified in the "add to cart" request is valid.
 * This means that the quantity of copies of a product specified in the cart 
 * must not exceed the total available quantity of the product.
 * @param int $available_quantity the available quantity of the product
 * @param int $cart_quantity the quantity of copies of the product to be added to the cart
 * @return bool True if the $added_cart_quantity is valid, false otherwise
 */
function isQuantityValid($available_quantity, $cart_quantity) {
    return $cart_quantity <= $available_quantity && $cart_quantity > 0;
}

/**
 * Checks whether the quantity specified for a product in the cart can be decreased.
 * In particular, checks if the new quantity is lower than the old one, and checks if the
 * new quantity is non-negative.
 * @param int $new_quantity the new quantity to associate to the product
 * @param int $old_quantity the previous quantity associated to the product
 * @return bool True if the quantity can be modified, false otherwise
 */
function canDecreaseQuantity($new_quantity, $old_quantity) {
    return $new_quantity < $old_quantity && $new_quantity > 0;
}
?>