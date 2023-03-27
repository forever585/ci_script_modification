<?php if (authCheck()) :?>
    <div id="wrapper">
        <div class="container">
            <div class="row">
                <!--<div class="col-12">
                <div class="profile-tab-content">
                    <div class="row row-follower">
                        <?php /*if (!empty($favourite_shops)):
                            foreach ($favourite_shops as $item): */?>

                            <?php /*endforeach;
                        else:*/?>
                            <div class="col-12">
                                <p class="text-center text-muted"><?php /*echo trans("no_records_found"); */?></p>
                            </div>
                        <?php /*endif; */?>
                    </div>
                    <div class="row-custom">
                        <?php /*$this->load->view("partials/_ad_spaces", ["ad_space" => "profile", "class" => "m-t-30"]); */?>
                    </div>
                </div>
            </div>-->
                <div class="col-xl-12">
                    <!--begin::Tables Widget 9-->
                    <div class="card card-xxl-stretch mb-5 mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <?php if (clrNum($favouriteShopsCount) != 0): ?>
                                <h3 class="align-items-start flex-column float-left">
                                    <span class="card-label fw-bolder fs-3 mb-1">Favorite Shops: <?= $favouriteShopsCount ?></span>
                                </h3>
                            <?php endif; ?>
                            <?php
                                if((clrNum($favouriteShopsCount) == 0)){
                                    redirectToUrl(generateUrl('shops'));
                                }
                            ?>
                            <div class="card-toolbar float-right" title="Click to add favorite shops">
                                <?php if (!empty($menuLinks)):
                                    foreach ($menuLinks as $menuLink):
                                        if ($menuLink->location == 'quick_links'):
                                            $itemLink = generateMenuItemUrl($menuLink);
                                            if (!empty($menuLink->page_default_name)):
                                                $itemLink = generateUrl($menuLink->page_default_name);
                                            endif; ?>
                                            <?php if ($menuLink->page_default_name == 'shops'):?>
                                            <a href="<?= $itemLink; ?>" class="btn btn-sm btn-light btn-active-primary" data-bs-toggle="modal">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->Go To Shops</a>
                                        <?php endif?>
                                        <?php endif;
                                    endforeach;
                                endif; ?>

                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="">
                            <!--begin::Table container-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <!--begin::Table head-->
                                    <thead>
                                    <tr class="fw-bolder text-muted">
                                        <th class="min-w-150px padding-left-10">Name</th>
                                        <th class="min-w-250px">Shop's Site</th>
                                        <th class="min-w-100px text-center">Product Count</th>
                                        <th class="min-w-100px text-end padding-right-100">Actions</th>
                                    </tr>
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody>
                                    <?php if (!empty($favouriteShops)):
                                        foreach ($favouriteShops as $item): ?>
                                            <tr class="vertical-align-middle">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="symbol symbol-45px me-5">
                                                            <img src="<?php echo getUserAvatar($item); ?>" alt="<?= esc(getUsername($item)); ?>" class="img-fluid img-profile lazyload"/>
                                                        </div>
                                                        <div class="d-flex justify-content-start flex-column margin-left-10">
                                                            <a href="<?php echo generateProfileUrl($item->slug); ?>" class="text-dark fw-bolder text-hover-primary fs-6"><?php echo esc(getUsername($item));?></a>
                                                            <!--<span class="text-muted fw-bold text-muted d-block fs-7">HTML, JS, ReactJS</span>-->
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="vertical-align-middle">
                                                    <?php if(!empty($item->personal_website_url)) :?>
                                                        <a href="<?=  $item->personal_website_url; ?>" class="text-dark fw-bolder text-hover-primary d-block fs-6"><?= $item->personal_website_url; ?></a>
                                                    <?php else :?>
                                                        <a href="<?=  generateProfileUrl($item->slug); ?>" class="text-dark fw-bolder text-hover-primary d-block fs-6"><?= "Shop's site is unavailable." ?></a>
                                                    <?php endif;?>
                                                </td>
                                                <td class="text-center">
                                                    <?= getUserTotalProductsCount($item->id);?>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-end flex-shrink-0">
                                                        <?php if(!empty($item->personal_website_url)) :?>
                                                            <a href="<?=  $item->personal_website_url; ?>" class="btn btn-md custom-btn btn-light margin-right-10" title="Visit Your Favorite Shop">Visit Shop</a>
                                                        <?php else :?>
                                                            <a href="<?=  generateProfileUrl($item->slug); ?>" class="btn btn-md custom-btn btn-light margin-right-10" title="Visit Your Favorite Shop">Visit Shop</a>
                                                        <?php endif;?>
                                                        <form action="<?= base_url('add-remove-favourite-user-post'); ?>" method="post" class="form-inline">
                                                            <?= csrf_field(); ?>
                                                            <input type="hidden" name="shop_owner_id" value="<?= $item->id; ?>">
                                                            <input type="hidden" name="favourite_user_id" value="<?= user()->id; ?>">
                                                            <input type="hidden" name="back_url" value="<?= generateUrl('favourite_shops'). "/" . user()->slug  ?>">
                                                            <button class="btn btn-md custom-btn btn-light" title="Delete from Favorite Shops">Remove Shop</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach;
                                    else:?>
                                        <div class="col-12">
                                            <p class="text-center text-muted"><?php /*echo trans("no_records_found"); */?></p>
                                        </div>
                                    <?php endif; ?>


                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table container-->
                        </div>
                        <!--begin::Body-->
                    </div>
                    <!--end::Tables Widget 9-->
                </div>
            </div>
        </div>
    </div>
<?php else:
    redirect(base_url());
    ?>
<?php endif; ?>
<!-- include send message modal -->
<?= view('partials/_modal_send_message', ['subject' => null]); ?>

