# Magento Simple Menu #

Unlike WordPress, Magento was always difficult when it comes to managing menus. In past years it was almost exclusively done in CMS blocks, and Magento administrators had to learn a bit of HTML in order to be able to manage navigation by themselves.

With Magento Simple Menu module, users can now manage Magento menus the same way as they did in WordPress. Easy and intuitively.

Here is the overview of functionalities provided by Simple Magento Menus extension:
* easy order of menu items
* simple menu items nesting
* rename of items without influencing original name
* access to all categories
* possibility to include subcategories by stating depth
* access to all CMS pages
* access to special pages (such as: My Account, Login, Cart, Checkout, etc.)
* option to add custom defined links that may take website visitors on custom defined URL

Magento Simple Menu can easily be integrated through view in .phtml files or via CMS. It doesn't come with default CSS, as we didn't want to interfere in order to keep it simple ;-)

Front end of Magento Simple Menu module is primarily designed for developers, to give them flexibility in implementation, while back-end is designed for easy use and customers (non-developers).


## Usage ##

With WordPress-like look and feel, it shouldn't be too hard to teach users how to manage menus in Magento. We even made a video tutorial that you can share it with them: youtube-video-link

For those that don't like videos, there is an ASCII version here:
* to manage menus go to **admin panel CMS -> Simple Menu**
* to create menu - click on top right button "Add Simple Menu"
* to delete menu — select checkbox of menus you want to delete in the list, choose "Delete" in *Action* dropdown menu, and hit "Submit" button next to it
* to edit menu — click on menu from the list and edit it


## Implementation ##

Lets assume we have created menu with id "main_menu" as in video tutorial. To show it on front page, we can use php code in view file (presumably header.phtml) or CMS block.

### Custom (programming) implementation ###
Example of .phtml implementation of menu views:

To fetch menu on front-end you can use following code: `Mage::getModel("stuntcoders_simplemenu/simplemenu")->getMenu('main_menu');`

Example for frontend output:
```php
<ul>
<?php
	$mainMenu = Mage::getModel("stuntcoders_simplemenu/simplemenu")->getMenu('main_menu');

	foreach ($mainMenu as $menuItem) {
		echo "<li><a href='{$menuItem['url']}'>{$menuItem['label']}</a></li>";
	}
?>
</ul>
```

Example for automatic front-end multi level menu output:
```php
<?php echo Mage::getModel("stuntcoders_simplemenu/simplemenu")->getMenu('main_menu');
```

To add your own classes and identifiers and output menu on front-end, you can use the following code:
```php
<?php 
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

$mainMenu = Mage::getModel("stuntcoders_simplemenu/simplemenu")->getMenu('main_menu');;
outputMenu($mainMenu['value']);

echo "</ul>";
```

### Magento CMS output of menu items ###
Example of outputting menu via CMS block view:
{{block type="stuntcoders_simplemenu/simplemenu" menu="main_menu"}}