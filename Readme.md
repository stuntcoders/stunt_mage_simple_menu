# Simple menu

Simple menu is Magento extension that simplifies creating menus.

Menus can contain: 

* **Custom urls**
* **Category page urls**
* **Cms page urls**
* **Special page urls** (cart, checkout, login, etc.)


## Usage

* Create menu - This can be done from admin panel (CMS -> Simple Menu)
* Fetch menu on frontend - `Mage::helper('stuntcoders_simplemenu')->getMenu('<menu code>');`

Example for frontend output:
```php
<ul>
<?php
	$mainMenu = Mage::helper('stuntcoders_simplemenu')->getMenu('main_menu');

	foreach($mainMenu['value'] as $menuItem) {
		echo "<li><a href='{$menuItem['url']}'>{$menuItem['label']}</a></li>";
	}
?>
</ul>
```

## Bugs to be resolved:
* Output is generally sloppy. Letters are small where they should be large, English is incorrect, as well as the name of the module.