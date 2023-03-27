<?php

namespace App\Controllers;

use App\Models\BadgeModel;

class BadgeController extends BaseAdminController
{
    protected $badgeModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->badgeModel = new BadgeModel();
    }

    public function awardBadgePost(){
        $isAward = inputPost('is_award');
        if(!$isAward){
            if ($this->badgeModel->awardBadgePost()) {
                setSuccessMessage('Successfully Awarded');
                resetCacheDataOnChange();
            } else {
                setErrorMessage(trans("msg_error"));
            }
        }else{
            if ($this->badgeModel->removeBadgePost()) {
                setSuccessMessage('Successfully Removed');
                resetCacheDataOnChange();
            } else {
                setErrorMessage(trans("msg_error"));
            }
        }
        redirectToBackUrl();
    }
}