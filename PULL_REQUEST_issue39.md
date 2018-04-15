# Integrity constraint violation on deleting Product with images

## i have just inserted one Product into Database and, if i add some images in the product edit screen, the app goes in crash:

##I got this error message

##SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update a parent row: a foreign key constraint fails (scotchbox.product_images, CONSTRAINT product_images_product_id_foreign FOREIGN KEY (product_id) REFERENCES products (id)) (SQL: delete from products where id = 48)

##i tried to modify this column
##$table->foreign('product_id')->references('id')->on('products')

##to
##$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

##in product_images migration and now it should be works fine

## link: [ISSUE 39](https://github.com/Laracommerce/laracom/issues/39) 

##Regards
