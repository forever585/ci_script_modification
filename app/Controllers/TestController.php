<?php

namespace App\Controllers;

use App\Models\AuthModel;
use App\Models\BadgeModel;
use App\Models\CartModel;
use App\Models\CommonModel;
use App\Models\EarningsModel;
use App\Models\FeeModel;
use App\Models\MembershipModel;
use App\Models\MessageModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\SupportModel;

class TestController extends BaseController
{
    protected $supportModel;
    protected $orderModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->supportModel = new SupportModel();
        $this->orderModel = new OrderModel();
    }

    public function test(){
        $testModel = new CartModel();
        echo json_encode($testModel->getSessCartItems());
//        echo json_encode(getUser(3)->balance);
    }

}

