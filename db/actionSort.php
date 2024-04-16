<?php
include 'actionFile.php';
class Sort extends File
{
    public $namesort;
    public $pricesort;
    public $locsort;
    public $sort1 = 1;
    public $sort2 = 1;
    public function sort($data, $offset, $num, $type, $searchq = null, $shopID = null)
    {
        $sorting = explode('-', $type);
        $key = $sorting[0];
        $val = $sorting[1];
        if ($type == 'name-asc') {
            $this->namesort = 1;
            $this->sort1 = 0;
        } else if ($type == 'name-desc') {
            $this->namesort = 1;
            $this->sort1 = 1;
        } else if ($type == 'price-asc') {
            $this->pricesort = 1;
            $this->sort2 = 0;
        } else if ($type == 'price-desc') {
            $this->pricesort = 1;
            $this->sort2 = 1;
        } else if ($type == 'location-asc') {
            $this->locsort = 1;
            $this->sort2 = 0;
        } else if ($type == 'location-desc') {
            $this->locsort = 1;
            $this->sort2 = 1;
        }
        if ($data == 'products') {
            if (!isset($searchq))
                $result = $this->showRecords('shopproducts', "ORDER BY product_$key $val LIMIT $offset, $num");
            else
                $result = $this->showRecords('shopproducts', "WHERE product_Name LIKE '%$searchq%' OR product_ID LIKE '%$searchq%' ORDER BY product_$key $val LIMIT $offset, $num");
        } else if ($data == 'shops') {
            if (!isset($searchq))
                $result = $this->showRecords('shopdata', "ORDER BY shop_$key $val LIMIT $offset, $num");
            else
                $result = $this->showRecords('shopdata', "WHERE shop_Name LIKE '%$searchq%' OR shop_Location LIKE '%$searchq%' ORDER BY shop_$key $val LIMIT $offset, $num");
        } else if ($data == 'shopPage') {
            if (!isset($searchq))
                $result = $this->showRecords('shopproducts', "WHERE shop_ID = $shopID ORDER BY product_$key $val LIMIT $offset, $num");
            else
                $result = $this->showRecords('shopproducts', "WHERE shop_ID = $shopID AND product_Name LIKE '%$searchq%' OR product_ID LIKE '%$searchq%' ORDER BY product_$key $val LIMIT $offset, $num");
        }
        return $result;
    }
}