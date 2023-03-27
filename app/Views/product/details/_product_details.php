<div class="row">
    <div class="col-12">
        <?php if ($product->product_type == 'digital'):
            if ($product->is_free_product == 1):
                if (authCheck()):?>
                    <div class="row-custom m-t-10">
                        <form action="<?= base_url('download-free-digital-file-post'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?= $product->id; ?>">
                            <button class="btn btn-instant-download"><i class="icon-download-solid"></i><?= trans("download") ?></button>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="row-custom m-t-10">
                        <button class="btn btn-instant-download" data-toggle="modal" data-target="#loginModal"><i class="icon-download-solid"></i><?= trans("download") ?></button>
                    </div>
                <?php endif;
            else:
                if (!empty($digitalSale)): ?>
                    <div class="row-custom m-t-10">
                        <form action="<?= base_url('download-purchased-digital-file-post'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="sale_id" value="<?= $digitalSale->id; ?>">
                            <button class="btn btn-instant-download"><i class="icon-download-solid"></i><?= trans("download") ?></button>
                        </form>
                    </div>
                <?php else: ?>
                    <label class="label-instant-download"><i class="icon-download-solid"></i><?= trans("instant_download"); ?></label>
                <?php endif;
            endif;
        endif; ?>
        <h1 class="product-title"><?= esc($title); ?></h1>
        <?php if ($product->status == 0): ?>
            <label class="badge badge-warning badge-product-status"><?= trans("pending"); ?></label>
        <?php elseif ($product->visibility == 0): ?>
            <label class="badge badge-danger badge-product-status"><?= trans("hidden"); ?></label>
        <?php endif; ?>
        <div class="row-custom meta">
            <div class="product-details-user">
                <?= trans("by"); ?>&nbsp;<a href="<?= generateProfileUrl($product->user_slug); ?>"><?= characterLimiter(esc($product->user_username), 30, '..'); ?></a>
            </div>
            <?php if ($generalSettings->product_comments == 1): ?>
                <span><i class="icon-comment"></i><?= esc($commentCount); ?></span>
            <?php endif;
            if ($generalSettings->reviews == 1): ?>
                <div class="product-details-review">
                    <?= view('partials/_review_stars', ['rating' => $product->rating]); ?>
                    <span>(<?= esc($reviewCount); ?>)</span>
                </div>
            <?php endif; ?>
            <span><i class="icon-heart"></i><?= esc($wishlistCount); ?></span>
            <span><i class="icon-eye"></i><?= esc($product->pageviews); ?></span>
        </div>
        <div class="row-custom price">
            <div id="product_details_price_container" class="d-inline-block">
                <?= view('product/details/_price', ['product' => $product, 'price' => $product->price, 'discountRate' => $product->discount_rate]); ?>
                <?php if ($product->is_sold == 1): ?>
                    <strong class="lbl-sold"><?= trans("sold"); ?></strong>
                <?php endif; ?>
            </div>
            <?php $showAsk = true;
            if ($product->listing_type == 'ordinary_listing' && empty($product->external_link)):
                $showAsk = false;
            endif;
            if ($showAsk == true):?>
                <?php if (authCheck()): ?>
                    <button class="btn btn-contact-seller" data-toggle="modal" data-target="#messageModal"><i class="icon-envelope"></i> <?= trans("ask_question") ?></button>
                <?php else: ?>
                    <button class="btn btn-contact-seller" data-toggle="modal" data-target="#loginModal"><i class="icon-envelope"></i> <?= trans("ask_question") ?></button>
                <?php endif;
            endif; ?>
        </div>
        <div class="row-custom details">
            <?php if ($product->listing_type != 'ordinary_listing' && $product->product_type != 'digital'): ?>
                <div class="item-details">
                    <div class="left">
                        <label><?= trans("status"); ?></label>
                    </div>
                    <div id="text_product_stock_status" class="right">
                        <?php if (checkProductStock($product)): ?>
                            <span class="status-in-stock text-success"><?= trans("in_stock") ?></span>
                        <?php else: ?>
                            <span class="status-in-stock text-danger"><?= trans("out_of_stock") ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif;
            if ($productSettings->marketplace_sku == 1 && !empty($product->sku)): ?>
                <div class="item-details">
                    <div class="left">
                        <label><?= trans("sku"); ?></label>
                    </div>
                    <div class="right">
                        <span><?= esc($product->sku); ?></span>
                    </div>
                </div>
            <?php endif;
            if ($product->product_type == 'digital' && !empty($product->files_included)): ?>
                <div class="item-details">
                    <div class="left">
                        <label><?= trans("files_included"); ?></label>
                    </div>
                    <div class="right">
                        <span><?= esc($product->files_included); ?></span>
                    </div>
                </div>
            <?php endif;
            if ($product->listing_type == 'ordinary_listing'): ?>
                <div class="item-details">
                    <div class="left">
                        <label><?= trans("uploaded"); ?></label>
                    </div>
                    <div class="right">
                        <span><?= timeAgo($product->created_at); ?></span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if ($product->listing_type == 'sell_on_site' || $product->listing_type == 'license_key'): ?>
<form action="<?= getProductFormData($product)->addToCartUrl; ?>" method="post" id="form_add_cart">
    <?= csrf_field(); ?>

    <?php endif;
    if ($product->listing_type == 'bidding'): ?>
    <form action="<?= getProductFormData($product)->addToCartUrl; ?>" method="post" id="form_request_quote">
        <?= csrf_field(); ?>
        <?php endif; ?>
        <input type="hidden" name="product_id" value="<?= $product->id; ?>">

        <div class="row">
            <div class="col-12">
                <div class="row-custom product-variations">
                    <div class="row row-product-variation item-variation">
                        <?php if (!empty($fullWidthProductVariations)):
                            foreach ($fullWidthProductVariations as $variation):
                                echo view('product/details/_product_variations', ['variation' => $variation]);
                            endforeach;
                        endif;
                        if (!empty($halfWidthProductVariations)):
                            foreach ($halfWidthProductVariations as $variation):
                                echo view('product/details/_product_variations', ['variation' => $variation]);
                            endforeach;
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12"><?= view('product/details/_messages'); ?></div>
        </div>
        <div class="row">
            <div class="col-12 product-add-to-cart-container">
                <?php if ($product->is_sold != 1 && $product->listing_type != 'ordinary_listing' && $product->product_type != 'digital'): ?>
                    <div class="number-spinner">
                        <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-spinner-minus" data-dir="dwn">-</button>
                        </span>
                            <input type="text" class="form-control text-center" name="product_quantity" value="1">
                            <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-spinner-plus" data-dir="up">+</button>
                        </span>
                        </div>
                    </div>
                <?php endif;
                $buttton = getProductFormData($product)->button;
                $itemUniqueID = uniqid();
                $userName = $product->user_username;
                $user = getUserByUserName($userName);
                if ($product->is_sold != 1 && !empty($buttton)  && $user->is_vacation == 0):?>
                    <div class="button-container">
                        <?= $buttton; ?>
                    </div>
                <?php endif; ?>
                <div class="button-container button-container-wishlist">
                    <?php if ($isProductInWishlist == 1): ?>
                        <a href="javascript:void(0)" class="btn-wishlist btn-add-remove-wishlist" data-product-id="<?= $product->id; ?>" data-type="details"><i class="icon-heart"></i><span><?= trans("remove_from_wishlist"); ?></span></a>
                    <?php else: ?>
                        <a href="javascript:void(0)" class="btn-wishlist btn-add-remove-wishlist" data-product-id="<?= $product->id; ?>" data-type="details"><i class="icon-heart-o"></i><span><?= trans("add_to_wishlist"); ?></span></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (!empty($product->demo_url)): ?>
                <div class="col-12 product-add-to-cart-container">
                    <div class="button-container">
                        <a href="<?= $product->demo_url; ?>" target="_blank" class="btn btn-md btn-live-preview"><i class="icon-preview"></i><?= trans("live_preview") ?></a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php if($product->product_type != "digital" && $product->gift_wrapping_fee != 0):?>
            <div class="row" style="padding-left:25px;">
                <div class="col-12 float-right">
                    <input type="checkbox" class="custom-control-input" id="is_gift_wrapping_fee_set" onchange="onChangeCheckBox(<?= getPrice($product->gift_wrapping_fee,'decimal');?>)"/>
                    <input id="gift_fee_value" name="gift_fee_value" type="hidden" value="0"/>
                    <label for="is_gift_wrapping_fee_set" class="custom-control-label" title="If you check this you have to pay additional gift wrapping fee."><b><?= "Set As Gift.(Extra Pay Needed for Gift Wrapping : ".getPrice($product->gift_wrapping_fee,'decimal')."$)"; ?></b></label>
                </div>
            </div>
        <?php endif;?>
    </form>
    <?= view("product/details/_product_share"); ?>
    <div class="row-custom row-profile-username margin-bottom-30">
        <div class="profile-info-header-right margin-top-20" style="position: absolute; left: -10px;">
            <!-- 1 is id of Top Seller Badge -->
            <?php if (isBadgeAwarded($user->id, 1) == "awarded_by_admin" || isBadgeAwarded($user->id, 1) == "can_remove"): ?>
                <div class="custom-badge-container">
                    <img class="custom-badge" src="<?= getBadgePicture('topseller');?>"/>
                </div>
            <?php endif; ?>
            <!-- 2 is id of Rating Badge -->
            <?php if (isBadgeAwarded($user->id, 2) == "awarded_by_admin" || isBadgeAwarded($user->id, 2) == "can_remove"): ?>
                <div class="custom-badge-container">
                    <img class="custom-badge" src="<?= getBadgePicture('ratings');?>"/>
                </div>
            <?php endif; ?>
            <!-- 3 is id of Veryfied Badge -->
            <?php if (isBadgeAwarded($user->id, 3) == "awarded_by_admin" || isBadgeAwarded($user->id, 3) == "can_remove"): ?>
                <div class="custom-badge-container">
                    <img class="custom-badge" src="<?= getBadgePicture('verified');?>"/>
                </div>
            <?php endif; ?>
            <!-- 4 is id of Quick Reply Badge -->
            <?php if (isBadgeAwarded($user->id, 4) == "awarded_by_admin" || isBadgeAwarded($user->id, 4) == "can_remove"): ?>
                <div class="custom-badge-container">
                    <img class="custom-badge" src="<?= getBadgePicture('appreciation');?>"/>
                </div>
            <?php endif; ?>
            <!-- 5 is id of Quick Shipping Badge -->
            <?php if (isBadgeAwarded($user->id, 5) == "awarded_by_admin" || isBadgeAwarded($user->id, 5) == "can_remove"): ?>
                <div class="custom-badge-container">
                    <img class="custom-badge-shipping" src="<?= getBadgePicture('shipping');?>"/>
                </div>
            <?php endif; ?>
        </div>

    </div>
    <script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
    <script>
    function onChangeCheckBox(feeValue) {
        var chxGift = document.getElementById("is_gift_wrapping_fee_set");
        var giftFeeVal = document.getElementById("gift_fee_value");
        if(chxGift.checked == true) {
            giftFeeVal.value = feeValue;
        }
        else
        {
            giftFeeVal.value = 0;
        }
    }
</script>