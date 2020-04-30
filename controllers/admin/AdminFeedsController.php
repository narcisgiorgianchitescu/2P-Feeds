<?php

class AdminFeedsController extends ModuleAdminController
{

  public function __construct()
  {

    if(isset($_GET['action'])){

         switch ($_GET['action']) {
           case 'getCsv':
             $this->getCsv();
             break;
         }
       }

    parent::__construct();
    $this->productArray = array();
  }

  public function init()
  {
    parent::init();
    $this->boostrap = true;
  }

  public function initContent()
  {
    parent::initContent();

    $id_lang = Configuration::get('PS_LANG_DEFAULT');
    $this->productArray = Product::getProducts($id_lang, 0, NULL, 'id_product', 'ASC');


    $this->context->smarty->assign([
     'productArray' => $this->productArray
    ]);

    $this->context->smarty->assign("pickup", "index.php?controller=AdminFeeds&action=getCsv");
    $this->setTemplate('narcis.tpl');
  }

  public function getCsv()
  {
    $id_lang = Configuration::get('PS_LANG_DEFAULT');
    $productArray = Product::getProducts($id_lang, 0, NULL, 'id_product', 'ASC');


    $sql = 'SELECT * FROM `ps_product`';
    $producsQuery = '
      SELECT SQL_CALC_FOUND_ROWS
      pl.`name`  AS `name`,
      pl.`description` AS `description`,
      pl.`description_short` AS `short_description`,
      sa.`price`  AS `price`,
      cl.`name`  AS `category`,
      "" AS `subcategory`,
      "" AS `url`,
      ""  AS `image_url`,
      p.`id_product`  AS `id_product`,
      0 AS "generate_link_text",
      "" AS `brand`,
      sa.`active`  AS `active`,
      "" AS `other_data`
      FROM  `ps_product` p
      LEFT JOIN `ps_product_lang` pl ON (pl.`id_product` = p.`id_product` AND pl.`id_lang` = 1 AND pl.`id_shop` = 1)
      LEFT JOIN `ps_stock_available` sav ON (sav.`id_product` = p.`id_product` AND sav.`id_product_attribute` = 0 AND sav.id_shop = 1  AND sav.id_shop_group = 0 )
      JOIN `ps_product_shop` sa ON (p.`id_product` = sa.`id_product` AND sa.id_shop = 1)
      LEFT JOIN `ps_category_lang` cl ON (sa.`id_category_default` = cl.`id_category` AND cl.`id_lang` = 1 AND cl.id_shop = 1)
      LEFT JOIN `ps_category` c ON (c.`id_category` = cl.`id_category`)
      LEFT JOIN `ps_shop` shop ON (shop.id_shop = 1)
      LEFT JOIN `ps_image_shop` image_shop ON (image_shop.`id_product` = p.`id_product` AND image_shop.`cover` = 1 AND image_shop.id_shop = 1)
      LEFT JOIN `ps_image` i ON (i.`id_image` = image_shop.`id_image`)
      LEFT JOIN `ps_product_download` pd ON (pd.`id_product` = p.`id_product`)

      WHERE (1 AND state = 1)
      ORDER BY  `id_product` asc;
    ';

    $fp = fopen('products.csv', 'wb');

    if (  $results = Db::getInstance()->ExecuteS($producsQuery) ) {
      foreach ($results as $product) {

        $details = $product['name'].",". strip_tagS($product['description']).",".strip_tags($product['short_description']).",".$product['price']
                  .",".$product['category'].",".$product['subcategory'].",".$product['url'].",".$product['image_url']
                  .",".$product['id_product'].",".$product['generate_link_text'].",".$product['brand'].",".$product['active']
                  .",".$product['other_data'];

        $line = explode(",", $details);

        fputcsv($fp, $line);
      }
    }

    fclose($fp);
  }

  public function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }
}
