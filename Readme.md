# Simple menu

Simple menu is Magento extension that simplifies creating menus.

Menus can contain: 

* **Custom urls**
* **Category page urls**
* **Cms page urls**
* **Special page urls** (cart, checkout, login, etc.)


## Usage

* Create menu - This can be done from admin panel (CMS -> Simple Menu)
* Fetch menu on frontend - `Mage::helper('stuntcoders_simplemenu')->getMenu('menu_code');`

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

Example for automatic frontend multi level menu output:
```php
echo Mage::helper('stuntcoders_simplemenu')->getMenuOutput('main_menu');
```

To add your own classes and identifiers and output menu on frontend, you can use the following code:
```php
function outputMenu($menu)
{
    foreach ($menu as $menuItem) {
        echo "<li><a href='{$menuItem['url']}'>{$menuItem['label']}</a>";
        if (!empty($menuItem['children'])) {
            echo "<ul>";
            outputMenu($menuItem['children']);
            echo "</ul>";
        }
        echo "</li>";
    }
}

echo "<ul id='menu-main-menu' class='menu'>";

$mainMenu = Mage::helper('stuntcoders_simplemenu')->getMenu('main_menu');
outputMenu($mainMenu['value']);

echo "</ul>";
```

## Bugs to be resolved:
* Output is generally sloppy. Letters are small where they should be large, English is incorrect, as well as the name of the module.