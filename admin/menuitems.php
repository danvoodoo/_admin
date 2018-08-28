<?php

$menuitems = array(
	'post' => array(
		'title' => 'Posts',
		'items' => array(
			array(
				'url' => 'post.php',
				'name' => 'Posts',
				'new_item' => 1
				),
			array(
				'url' => 'category.php',
				'name' => 'Categories',
				'new_item' => 1
				),
			)
		),


	'pages' => array(
		'title' => 'Pages',
		'items' => array(
			array(
				'url' => 'pages.php',
				'name' => 'Pages',
				'new_item' => 1
				)
			)
		),


	'menu' => array(
		'title' => 'Menu',
		'items' => array(
			array(
				'url' => 'menu.php?id=1&posttype=page,post&par=1',
				'name' => 'Main Menu',
				'new_item' => 0,
				'customurl' => 1
				),
			array(
				'url' => 'menu.php?id=2',
				'name' => 'Footer Menu',
				'new_item' => 0,
				'customurl' => 1
				)
			)
		),

	'options' => array(
		'title' => 'Options',
		'items' => array(
			array(
				'url' => 'options.php',
				'name' => 'Options',
				'new_item' => 1
				),
            array(
                'url' => 'options-email.php',
                'name' => 'Email Options',
                'new_item' => 1
                )
			)
		),



	'shop' => array(
		'title' => 'Shop',
		'items' => array(
			array(
				'url' => 'shop-products.php',
				'name' => 'Products',
				'new_item' => 1
				),
			array(
				'url' => 'shop-category.php',
				'name' => 'Categories',
				'new_item' => 1
				),
			array(
				'url' => 'shop-status.php',
				'name' => 'Shop status',
				),
			/*
			array(
				'url' => 'shop-deliverydays.php',
				'name' => 'Shipping days',
				
				),
				*/

			array(
				'url' => 'shipping.php',
				'name' => 'Shipping',
				'new_item' => 1
				),


			array(
				'url' => 'shop-orderlist.php',
				'name' => 'Undelivered Orders',
				'new_item' => 0
				),

			array(
				'url' => 'shop-orders.php',
				'name' => 'All Orders',
				'new_item' => 0
				),
			)
		),


	'siteusers' => array(
		'title' => 'Site Users',
		'items' => array(
			array(
				'url' => 'site_users.php',
				'name' => 'Site Users',
				'new_item' => 1
				)
			)
		),


	'users' => array(
		'title' => 'Users',
		'items' => array(
			array(
				'url' => 'users.php',
				'name' => 'Users',
				'new_item' => 1
				)
			)
		),

	);
?>