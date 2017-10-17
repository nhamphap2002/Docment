<?php

/**
 * Description of List
 *
 * @author Ho Ngoc Hang<kemly.vn@gmail.com>
 */
class Fgc_Lead_Block_View extends Mage_Catalog_Block_Product_View
{
    public function getListParentCates(){
        /*
        CLOTHING (ID: 459)
        PENS (ID: 462)
        Umbrellas (ID: 748)
        CAPS & HATS (ID: 460)
        BAGS (ID: 461)
        Key Rings (ID: 475)
        */

        $arr_parent_cate_ids = array(459,462,748,460,461,475,655);
        return $arr_parent_cate_ids;
    }
    
    public function getListChildCates(){
        $arr_parent_cate_ids = $this->getListParentCates();
        $category_model = Mage::getModel('catalog/category');
        $arr_result = array();
        foreach($arr_parent_cate_ids as $categoryid){
            $_category = $category_model->load($categoryid); 
            $all_child_categories = $category_model->getResource()->getAllChildren($_category);
            $arr_result[$categoryid] = $all_child_categories;            
        }
        return $arr_result;
    }
    
    public function getLeadImageByCateId($cate_id){
        $arr_list_childs = $this->getListChildCates();
        $image = '';
        if(in_array($cate_id, $arr_list_childs['459'])){
            $image = 'clothing';
        }elseif(in_array($cate_id, $arr_list_childs['462'])){
            $image = 'pens';
        }elseif(in_array($cate_id, $arr_list_childs['748'])){
            $image = 'umbrellas';
        }elseif(in_array($cate_id, $arr_list_childs['460'])){
            $image = 'caps_hats';
        }elseif(in_array($cate_id, $arr_list_childs['461'])){
            $image = 'bags';
        }elseif(in_array($cate_id, $arr_list_childs['475'])){
            $image = 'keyrings_metakeyrings';
        }elseif(in_array($cate_id, $arr_list_childs['655'])){
            $image = 'watter_bottles';
        }else{
            $image = 'default';
        }
        $image .= '.png';
        return $image;
    }
}