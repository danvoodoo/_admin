-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-06-2017 a las 15:50:45
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `_admin`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `backups`
--

CREATE TABLE `backups` (
  `back_id` int(11) NOT NULL,
  `back_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `backups`
--

INSERT INTO `backups` (`back_id`, `back_date`) VALUES
(1, '2017-01-03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` text NOT NULL,
  `cat_url` text NOT NULL,
  `cat_type` varchar(15) NOT NULL,
  `cat_description` text NOT NULL,
  `cat_parent` int(11) NOT NULL,
  `cat_order` int(11) NOT NULL,
  `cat_image` text NOT NULL,
  `cat_state` int(11) NOT NULL,
  `cat_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_url`, `cat_type`, `cat_description`, `cat_parent`, `cat_order`, `cat_image`, `cat_state`, `cat_date`) VALUES
(1, 'Sample Category', 'sample-category', 'category', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 0, 0, '', 1, '2017-01-03 15:23:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `co_id` int(11) NOT NULL,
  `co_comment` text NOT NULL,
  `co_post` int(11) NOT NULL,
  `co_name` text NOT NULL,
  `co_email` text NOT NULL,
  `co_website` text NOT NULL,
  `co_state` int(11) NOT NULL,
  `co_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `downloads`
--

CREATE TABLE `downloads` (
  `dl_id` int(11) NOT NULL,
  `dl_title` text NOT NULL,
  `dl_parent` int(11) NOT NULL,
  `dl_file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medialibrary`
--

CREATE TABLE `medialibrary` (
  `media_id` int(11) NOT NULL,
  `media_url` text NOT NULL,
  `media_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `medialibrary`
--

INSERT INTO `medialibrary` (`media_id`, `media_url`, `media_date`) VALUES
(1, '1483454335-1479306560-01.png', '2017-01-03 14:38:55'),
(2, '1483460079-1479305742-service.png', '2017-01-03 16:14:39'),
(3, '1483460118-1479305742-service.png', '2017-01-03 16:15:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menus`
--

CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL,
  `menu_items` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menus`
--

INSERT INTO `menus` (`menu_id`, `menu_items`) VALUES
(1, '{"sample-page-2":{"title":"Sample page","url":"sample-page","id":"2","childs":{}}}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `meta`
--

CREATE TABLE `meta` (
  `meta_id` int(11) NOT NULL,
  `meta_posttype` varchar(20) NOT NULL,
  `meta_key` varchar(50) NOT NULL,
  `meta_value` text NOT NULL,
  `meta_postid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `meta`
--

INSERT INTO `meta` (`meta_id`, `meta_posttype`, `meta_key`, `meta_value`, `meta_postid`) VALUES
(1, 'page', 'meta_name', 'Some content', 2),
(2, 'page', 'meta_name', '', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `or_id` int(11) NOT NULL AUTO_INCREMENT,
  `or_user` int(11) NOT NULL,
  `or_cart` text NOT NULL,
  `or_date` datetime NOT NULL,
  `or_cp` text NOT NULL,
  `or_bill_cp` text NOT NULL,
  `or_address` text NOT NULL,
  `or_bill_address` text NOT NULL,
  `or_city` text NOT NULL,
  `or_bill_city` text NOT NULL,
  `or_county` text NOT NULL,
  `or_bill_county` text NOT NULL,
  `or_country` text NOT NULL,
  `or_bill_country` text NOT NULL,
  `or_notes` text NOT NULL,
  `or_addnotes` text NOT NULL,
  `or_phone` text NOT NULL,
  `or_bill_phone` text NOT NULL,
  `or_confirm` tinyint(4) NOT NULL,
  `or_total` decimal(10,2) NOT NULL,
  `or_grosstotal` decimal(10,2) NOT NULL,
  `or_name` text NOT NULL,
  `or_bill_name` text NOT NULL,
  `or_lastname` text NOT NULL,
  `or_bill_lastname` text NOT NULL,
  `or_email` text NOT NULL,
  `or_bill_email` text NOT NULL,
  `or_shipping` text NOT NULL,
  `or_shippingtotal` decimal(10,2) NOT NULL,
  `or_shipped` tinyint(4) NOT NULL,
  `or_gift` text NOT NULL,
  `or_checkoutcode1` text NOT NULL,
  `or_checkoutcode2` text NOT NULL,
  `or_checkoutcode3` text NOT NULL,
  `or_code` text NOT NULL,
  `or_status` text NOT NULL,
  `or_laststatus` text NOT NULL,
  `or_response` text NOT NULL,
  `or_coupon` text NOT NULL,
  PRIMARY KEY (`or_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `post_title` text NOT NULL,
  `post_content` text NOT NULL,
  `post_photo` text NOT NULL,
  `post_date` datetime NOT NULL,
  `post_dateupdate` datetime NOT NULL,
  `post_state` varchar(1) NOT NULL,
  `post_type` varchar(11) NOT NULL,
  `post_excerpt` text NOT NULL,
  `post_url` text NOT NULL,
  `post_order` int(11) NOT NULL,
  `post_parent` int(11) NOT NULL,
  `post_user` int(11) NOT NULL,
  `post_category` text NOT NULL,
  `post_tags` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`post_id`, `post_title`, `post_content`, `post_photo`, `post_date`, `post_state`, `post_type`, `post_excerpt`, `post_url`, `post_order`, `post_parent`, `post_user`, `post_category`) VALUES
(1, 'Sample post', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse nunc nulla, aliquet a consequat in, viverra eget tortor. Morbi blandit et felis quis consequat. Aenean lacinia viverra tortor, nec auctor urna vestibulum in. Suspendisse sed tortor pretium, vestibulum nulla finibus, mollis leo. Fusce ac lobortis magna. Maecenas et purus at magna fringilla efficitur id ut urna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam non risus vitae turpis auctor iaculis. Donec a tellus erat.</p>', '1483454335-1479306560-01.png', '2017-01-03 16:04:00', '1', 'post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse nunc null.', 'sample-post', 1, 0, 0, ''),
(2, 'Sample page', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse nunc nulla, aliquet a consequat in, viverra eget tortor. Morbi blandit et felis quis consequat. Aenean lacinia viverra tortor, nec auctor urna vestibulum in. Suspendisse sed tortor pretium, vestibulum nulla finibus, mollis leo. Fusce ac lobortis magna. Maecenas et purus at magna fringilla efficitur id ut urna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam non risus vitae turpis auctor iaculis. Donec a tellus erat.</p>', '1483460118-1479305742-service.png', '2017-01-03 16:15:00', '1', 'page', '', 'sample-page', 0, 0, 0, ''),
(3, 'Child Page', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse nunc nulla, aliquet a consequat in, viverra eget tortor. Morbi blandit et felis quis consequat. Aenean lacinia viverra tortor, nec auctor urna vestibulum in. Suspendisse sed tortor pretium, vestibulum nulla finibus, mollis leo. Fusce ac lobortis magna. Maecenas et purus at magna fringilla efficitur id ut urna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam non risus vitae turpis auctor iaculis. Donec a tellus erat.</p>', '', '2017-01-03 16:10:00', '1', 'page', '', 'child-page', 0, 2, 0, ''),
(4, 'Email', 'cms@voodoochilli.com', '', '2017-01-03 16:13:00', '1', 'option', '', 'email', 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `prod_id` int(11) NOT NULL,
  `prod_title` text NOT NULL,
  `prod_url` text NOT NULL,
  `prod_excerpt` text NOT NULL,
  `prod_content` text NOT NULL,
  `prod_photo` text NOT NULL,
  `prod_category` text NOT NULL,
  `prod_date` datetime NOT NULL,
  `prod_order` int(11) NOT NULL,
  `prod_state` int(11) NOT NULL,
  `prod_price` decimal(11,2) NOT NULL,
  `prod_parent` int(11) NOT NULL,
  `prod_price_sale` decimal(11,2) NOT NULL,
  `prod_code` char(18) NOT NULL,
  `prod_type` char(18) NOT NULL,
  `prod_gallery` text NOT NULL,
  `prod_stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `site_users`
--

CREATE TABLE `site_users` (
  `us_id` int(11) NOT NULL,
  `us_name` text NOT NULL,
  `us_lastname` text NOT NULL,
  `us_email` text NOT NULL,
  `us_address` text NOT NULL,
  `us_city` tinytext NOT NULL,
  `us_county` tinytext NOT NULL,
  `us_country` tinytext NOT NULL,
  `us_password` text NOT NULL,
  `us_phone` text NOT NULL,
  `us_profiletype` text NOT NULL,
  `us_state` int(11) NOT NULL,
  `us_laststate` int(11) NOT NULL,
  `us_date` datetime NOT NULL,
  `us_url` text NOT NULL,
  `us_image` text NOT NULL,
  `us_postcode` tinytext NOT NULL,
  `us_level` int(11) NOT NULL,
  `us_hash` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_user` text NOT NULL,
  `u_pass` text NOT NULL,
  `u_email` text,
  `u_name` text,
  `u_level` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`u_id`, `u_user`, `u_pass`, `u_email`, `u_name`, `u_level`) VALUES
(8, 'voodoo', '37a128ab19c61dcad5e5066c581ceedbbb15f9be', '', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitors_online`
--

CREATE TABLE `visitors_online` (
  `visitor_` int(10) UNSIGNED NOT NULL,
  `visitor_ip` varchar(45) NOT NULL,
  `visitor_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `backups`
--
ALTER TABLE `backups`
  ADD PRIMARY KEY (`back_id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`co_id`);

--
-- Indices de la tabla `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`dl_id`);

--
-- Indices de la tabla `medialibrary`
--
ALTER TABLE `medialibrary`
  ADD PRIMARY KEY (`media_id`);

--
-- Indices de la tabla `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indices de la tabla `meta`
--
ALTER TABLE `meta`
  ADD PRIMARY KEY (`meta_id`);

--
-- Indices de la tabla `orders`


--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indices de la tabla `site_users`
--
ALTER TABLE `site_users`
  ADD PRIMARY KEY (`us_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Indices de la tabla `visitors_online`
--
ALTER TABLE `visitors_online`
  ADD PRIMARY KEY (`visitor_`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `backups`
--
ALTER TABLE `backups`
  MODIFY `back_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `comments`
--
ALTER TABLE `comments`
  MODIFY `co_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `downloads`
--
ALTER TABLE `downloads`
  MODIFY `dl_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `medialibrary`
--
ALTER TABLE `medialibrary`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `meta`
--
ALTER TABLE `meta`
  MODIFY `meta_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `orders`
--

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `site_users`
--
ALTER TABLE `site_users`
  MODIFY `us_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `visitors_online`
--
ALTER TABLE `visitors_online`
  MODIFY `visitor_` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `ipnresponse` (
  `res_id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `res_post` text NOT NULL,
  `res_get` text NOT NULL,
  `res_date` datetime NOT NULL
);