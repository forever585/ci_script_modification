<?php namespace App\Models;

use CodeIgniter\Model;
use Config\Globals;

class FeeModel extends BaseModel
{
    protected $builder;

    public function __construct()
    {
        parent::__construct();
        $this->builder = $this->db->table('listing_fees');
    }

    //add listing fee
    public function addListingFee($productId)
    {
        $productModel = new ProductModel();
        $sellerId = $productModel->getProduct($productId)->user_id;
        $data = [
            "seller_id" => $sellerId,
            "product_id" => $productId
        ];
        return $this->builder->insert($data);
    }

    //add relisting fee
    public function addRelistingFee($productId){
        $productModel = new ProductModel();
        $sellerId = $productModel->getProduct($productId)->user_id;
        $data = [
            "seller_id" => $sellerId,
            "product_id" => $productId,
            "is_relisting" => 1
        ];
        return $this->builder->insert($data);
    }

    //get listing fees count
    public function getListingFeesCount($sellerId)
    {
        return $this->builder->where("seller_id",$sellerId)->countAllResults();
    }

    //get listing fee
    public function getListingFee($id)
    {
        $this->builder->join("users", "listing_fees.seller_id = users.id");
        $this->builder->join("product_details", "listing_fees.product_id = product_details.product_id");
        return $this->builder->where("listing_fees.id",$id)->where("product_details.lang_id",selectedLangId())->select("listing_fees.*, users.username, product_details.title")->orderBy('listing_fees.created_at DESC')->get()->getRow();
    }

    //get listing fees
    public function getListingFeesPaginated($sellerId,$perPage, $offset)
    {
        $this->builder->join("users", "listing_fees.seller_id = users.id");
        $this->builder->join("product_details", "listing_fees.product_id = product_details.product_id");
        return $this->builder->where("seller_id",$sellerId)->where("product_details.lang_id",selectedLangId())->select("listing_fees.*, users.username, product_details.title")->orderBy('listing_fees.created_at DESC')->limit($perPage, $offset)->get()->getResult();
    }

    //is seller paid listing fee
    public function getUnchargedListingFees($sellerId){
        return $this->builder->where("seller_id",$sellerId)->where("is_paid",0)->get()->getResult();
    }


    //charge listing fee
    public function chargeListingFee($id){
        $data = [
            "is_paid" => 1,
            "is_invoice_set" => 0,
            "updated_at" => date('Y-m-d H:i:s')
        ];
        return $this->builder->where("id",$id)->update($data);
    }

    //make invoice
    public function makeInvoice($id){
        $data = [
            "is_invoice_set" => 1,
            "updated_at" => date('Y-m-d H:i:s')
        ];
        $this->builder->where("id",$id)->update($data);
    }

}
