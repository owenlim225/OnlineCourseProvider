<form action='../func/user/add-to-cart.php' method='POST'>
    <input type='hidden' name='course_id' value='<?= $row['course_id']; ?>'>
    <button type='submit' name='add_to_cart' class='btn btn-sm btn-outline-danger py-2 px-3'>
        Add to Cart
    </button>
</form>
