DELETE FROM `wp_attribute` WHERE model_id = (SELECT id FROM wp_model WHERE `name`='shop_address' ORDER BY id DESC LIMIT 1);
DELETE FROM `wp_model` WHERE `name`='shop_address' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_shop_address`;

DELETE FROM `wp_attribute` WHERE model_id = (SELECT id FROM wp_model WHERE `name`='shop_banner' ORDER BY id DESC LIMIT 1);
DELETE FROM `wp_model` WHERE `name`='shop_banner' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_shop_banner`;

DELETE FROM `wp_attribute` WHERE model_id = (SELECT id FROM wp_model WHERE `name`='shop_categories' ORDER BY id DESC LIMIT 1);
DELETE FROM `wp_model` WHERE `name`='shop_categories' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_shop_categories`;

DELETE FROM `wp_attribute` WHERE model_id = (SELECT id FROM wp_model WHERE `name`='shop_footer' ORDER BY id DESC LIMIT 1);
DELETE FROM `wp_model` WHERE `name`='shop_footer' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_shop_footer`;

DELETE FROM `wp_attribute` WHERE model_id = (SELECT id FROM wp_model WHERE `name`='shop_orders' ORDER BY id DESC LIMIT 1);
DELETE FROM `wp_model` WHERE `name`='shop_orders' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_shop_orders`;

DELETE FROM `wp_attribute` WHERE model_id = (SELECT id FROM wp_model WHERE `name`='shop_order_detail' ORDER BY id DESC LIMIT 1);
DELETE FROM `wp_model` WHERE `name`='shop_order_detail' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_shop_order_detail`;

DELETE FROM `wp_attribute` WHERE model_id = (SELECT id FROM wp_model WHERE `name`='shop_products' ORDER BY id DESC LIMIT 1);
DELETE FROM `wp_model` WHERE `name`='shop_products' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_shop_products`;

DELETE FROM `wp_attribute` WHERE model_id = (SELECT id FROM wp_model WHERE `name`='shop_topic' ORDER BY id DESC LIMIT 1);
DELETE FROM `wp_model` WHERE `name`='shop_topic' ORDER BY id DESC LIMIT 1;
DROP TABLE IF EXISTS `wp_shop_topic`;