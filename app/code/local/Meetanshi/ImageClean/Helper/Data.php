<?php

class Meetanshi_ImageClean_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function Productunusedimage()
    {
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        $select = $read->select()
            ->from('catalog_product_entity_media_gallery', '*')
            ->group(array('value_id'));
        $flushImages = $read->fetchAll($select);
        $array = array();
        foreach ($flushImages as $item) {
            $array[] = $item['value'];
        }

        $valueResult = $array;
        $imgpath = 'media' . DS . 'catalog' . DS . 'product';
        $unuseImgarray = $this->Productlistdir($imgpath);

        foreach ($unuseImgarray as $item) {
            try {
                $item = strtr($item, '\\', '/');
                if (!in_array($item, $valueResult)) {
                    $valdir[]['filename'] = $item;
                    $dbimgpath = 'catalog/product' . $item;
                    $model = Mage::getModel("imageclean/imageclean");
                    $imgcount = Mage::getModel("imageclean/imageclean")->getCollection()->addFieldToFilter("imagepath", $dbimgpath);
                    if (count($imgcount) == 0) {
                        $model->setImagepath($dbimgpath);
                        $model->save();
                    }
                }
            } catch (Zend_Db_Exception $e) {
            } catch (Exception $e) {
                Mage::log($e->getMessage(), null, 'ImageClean.log');
            }
        }
    }

    public function Productlistdir($imgpath)
    {
        if (is_dir($imgpath)) {
            if ($dir = opendir($imgpath)) {
                while (($entry = readdir($dir)) !== false) {
                    if (preg_match('/^\./', $entry) != 1) {
                        if (is_dir($imgpath . DS . $entry) && !in_array($entry, array('cache', 'watermark'))) {
                            $this->Productlistdir($imgpath . DS . $entry);
                        } elseif (!in_array($entry, array('cache', 'watermark')) && (strpos($entry, '.') !== 0)) {
                            $this->result[] = substr($imgpath . DS . $entry, 21);
                        }
                    }
                }

                closedir($dir);
            }
        }

        return $this->result;
    }


    public function Categoryunusedimage()
    {
        $categories = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('*');

        foreach ($categories as $categorie) {
            $array[] = Mage::getModel('catalog/category')->load($categorie->getId())->getImage();
        }

        $valueResult = $array;
        $imgpath = 'media' . DS . 'catalog' . DS . 'category';
        $unuseImgarray = $this->Categorylistdir($imgpath);

        foreach ($unuseImgarray as $item) {
            try {
                $item = strtr($item, '\\', '/');
                if (!in_array($item, $valueResult)) {
                    $valdir[]['filename'] = $item;
                    $dbimgpath = 'catalog/category/' . $item;
                    $model = Mage::getModel("imageclean/imageclean");
                    $imgcount = Mage::getModel("imageclean/imageclean")->getCollection()->addFieldToFilter("imagepath", $dbimgpath);
                    if (count($imgcount) == 0) {
                        $model->setImagepath($dbimgpath);
                        $model->setIsproduct('0');
                        $model->save();
                    }
                }
            } catch (Zend_Db_Exception $e) {
                Mage::log($e->getMessage(), null, 'ImageClean.log');
            } catch (Exception $e) {
                Mage::log($e->getMessage(), null, 'ImageClean.log');
            }
        }
    }

    public function Categorylistdir($imgpath)
    {
        if (is_dir($imgpath)) {
            if ($dir = opendir($imgpath)) {
                while (($entry = readdir($dir)) !== false) {
                    if (preg_match('/^\./', $entry) != 1) {
                        if (is_dir($imgpath . DS . $entry) && !in_array($entry, array('cache', 'watermark'))) {
                            $this->Categorylistdir($imgpath . DS . $entry);
                        } elseif (!in_array($entry, array('cache', 'watermark')) && (strpos($entry, '.') !== 0)) {
                            $this->result[] = substr($imgpath . DS . $entry, 23);
                        }
                    }
                }

                closedir($dir);
            }
        }

        return $this->result;
    }
}
