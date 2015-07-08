<?php

const BTN_ADD_TO_CART_LABEL = "Add to Cart";
const BTN_ADD_TO_CART_TITLE = "Add selected item to your shopping basket";
const CATEGORIES_LABEL = "Categories";

const IMAGE_GALLERY_ITEM_TEMPLATE = 
'<li><a href="#"><img src="$$THUMBNAIL$$" data-large="$$LARGE_IMAGE$$" alt="$$ALT_TEXT$$" data-description="$$DESCRIPTION$$" /></a></li>';


const PRODUCT_PRICES_TEMPLATE = ' $$IF|ProductInSale$$ $$IF|SalePrice$$$$IF|BasicPrice$$<span class="old-price">$$PRICE$$</span>$$ENDIF|BasicPrice$$$$SALE_PRICE$$ $$ENDIF|SalePrice$$
 	$$IF|NotSalePrice$$ $$IF|BasicPrice$$$$PRICE$$$$ENDIF|BasicPrice$$ $$ENDIF|NotSalePrice$$
 	$$ENDIF|ProductInSale$$  $$IF|ProductNotInSale$$
	$$PRICE$$$$ENDIF|ProductNotInSale$$';

// const ITEM_TO_CART_TEMPLATE = 
// ' $$IF|DisplayCartButton$$<div class="item-to-cart">
// <form action="$$ADDTOCART_ACTION$$" method="post" id="eshopprod$$POSTID_UNIQ$$">
// 	<label for="qty$$SKU_UNIQ$$" class="qty">
// 		<abbr title="Quantity">Qty</abbr>:</label>
// 	<input type="text" value="1" id="qty$$SKU_UNIQ$$" maxlength="3" size="3" name="qty" class="iqty quantity" />
// 	<input class="btn-addtocart" value="'.BTN_ADD_TO_CART_LABEL.'" title="'.BTN_ADD_TO_CART_TITLE.'" type="submit" />
// 	$$HIDDEN_FIELDS$$
// </form>
// </div>$$ENDIF|DisplayCartButton$$';
const ITEM_TO_CART_TEMPLATE = 
' $$IF|DisplayCartButton$$<div class="item-to-cart">
	<label for="qty$$SKU_UNIQ$$" class="qty">
		<abbr title="Quantity">Qty</abbr>:</label>
	<input type="text" value="1" id="qty$$SKU_UNIQ$$" maxlength="3" size="3" name="qty" class="iqty quantity" />
	<input class="btn-addtocart" value="'.BTN_ADD_TO_CART_LABEL.'" title="'.BTN_ADD_TO_CART_TITLE.'" type="submit" />
	$$HIDDEN_FIELDS$$
</div>$$ENDIF|DisplayCartButton$$';

define(PRODUCT_INFO_TEMPLATE, 
	'<li class="item crsl-item">
		<a href="$$PRODUCT_LINK$$">$$THUMBNAIL$$</a>
		<p class="item-title"><a href="$$PRODUCT_LINK$$">$$PRODUCT_TITLE$$</a></p>
		<p class="price">' . 
		PRODUCT_PRICES_TEMPLATE .
		'</p>
		<a class="btn-addtocart$$IF|DisplayCartButton$$ display$$ENDIF|DisplayCartButton$$">'.BTN_ADD_TO_CART_LABEL.'</a>
	</li>'
	)


?>