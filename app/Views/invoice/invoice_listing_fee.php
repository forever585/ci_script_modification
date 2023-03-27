<!DOCTYPE html>
<html lang="<?= $activeLang->short_form; ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <title><?= esc($title); ?> - <?= esc($baseSettings->site_title); ?></title>
    <meta name="description" content="<?= esc($description); ?>"/>
    <meta name="keywords" content="<?= esc($keywords); ?>"/>
    <meta name="author" content="<?= esc($generalSettings->application_name); ?>"/>
    <link rel="shortcut icon" type="image/png" href="<?= getFavicon(); ?>"/>
    <meta property="og:locale" content="en-US"/>
    <meta property="og:site_name" content="<?= esc($generalSettings->application_name); ?>"/>
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>"/>
</head>
<body>
<div class="container" style="width: 898px; max-width: 898px;min-width: 898px;">
    <div class="row">
        <div class="col-12">
            <div class="container-invoice">
                <div id="content" class="card">
                    <div class="card-body invoice p-0">
                        <div class="row">
                            <div class="col-12">
                                <h1 style="text-align: center; font-size: 36px;font-weight: 400;margin-top: 20px;"><?= trans("invoice"); ?></h1>
                            </div>
                        </div>
                        <div class="row" style="padding: 45px 30px;">
                            <div class="col-6">
                                <div class="logo">
                                    <img src="<?= getLogo(); ?>" alt="logo">
                                </div>
                                <div>
                                    <p style="margin-bottom: 5px;"><?= esc($baseSettings->contact_address); ?></p>
                                    <p style="margin-bottom: 5px;"><?= esc($baseSettings->contact_email); ?></p>
                                    <p style="margin-bottom: 5px;"><?= esc($baseSettings->contact_phone); ?></p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <p class="font-weight-bold mb-1"><span style="display: inline-block;width: 100px;"><?= trans("invoice"); ?>:</span>#INVP<?= $transaction->id; ?></p>
                                    <p class="font-weight-bold"><span style="display: inline-block;width: 100px;"><?= trans("date"); ?>:</span><?= formatDate($transaction->created_at); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php $currency = getCurrencyByCode($currency); ?>
                        <div class="row" style="padding: 45px 30px;">
                            <div class="col-6">
                                <p class="font-weight-bold mb-3"><?= "Seller Information"; ?></p>
                                <p class="mb-1"><?= esc($user->first_name); ?>&nbsp;<?= esc($user->last_name); ?>&nbsp;(<?= getUsername($user); ?>)</p>
                                <?php if (!empty($user->address)): ?>
                                    <p class="mb-1"><?= esc($user->address); ?></p>
                                <?php endif;
                                $country = !empty($user->country_id) ? getCountry($user->country_id) : '';
                                $state = !empty($user->state_id) ? getState($user->state_id) : '';
                                $city = !empty($user->city_id) ? getCity($user->city_id) : '';
                                if (!empty($state)): ?>
                                    <p class="mb-1"><?= !empty($city) ? $city->name . ", " : '' ?><?= $state->name; ?></p>
                                <?php endif;
                                if (!empty($country)): ?>
                                    <p class="mb-1"><?= !empty($country) ? $country->name : '' ?></p>
                                <?php endif;
                                if (!empty($user->phone_number)): ?>
                                    <p class="mb-1"><?= esc($user->phone_number); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <p class="font-weight-bold mb-3"><?= trans("payment_details"); ?></p>
                                    <p class="mb-1"><span style="display: inline-block;min-width: 158px;"><?= trans("payment_status"); ?>:</span><?= $transaction->is_paid ? "Paid" : "Not Paid"; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row p-4">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th><?= "No"; ?></th>
                                            <th><?= "Category"; ?></th>
                                            <th><?= "Product Title"; ?></th>
                                            <th><?= "Status"; ?></th>
                                            <th><?= "Is Relisting Fee"; ?></th>
                                            <th><?= "Price($)"; ?></th>
                                            <th><?= "Assigned Date"; ?></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><?= 1;?></td>
                                            <td><?= "Listing Fee";?></td>
                                            <td><?= $transaction->title?></td>
                                            <td><?= $transaction->is_paid ? "Paid" : "Assigned";?></td>
                                            <td><?= $transaction->is_relisting ? "Yes" : "No";?></td>
                                            <td><?= $listing_fee;?></td>
                                            <td><?= $transaction->created_at?></td>
                                        </tr>
                                        <tr>
                                            <td><?= 2;?></td>
                                            <td><?= "Transaction Fee";?></td>
                                            <td><?= $transaction->title?></td>
                                            <td><?= $transaction->is_paid ? "Paid" : "Assigned";?></td>
                                            <td><?= $transaction->is_relisting ? "Yes" : "No";?></td>
                                            <td><?= $transaction_fee;?></td>
                                            <td><?= $transaction->created_at?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                            <div class="order-total float-left">
                                <div class="row mb-2">
                                    <div class="col-6 col-left">
                                        <?= "Payment Address"; ?>
                                    </div>
                                    <div class="col-6 col-right">
                                        <a href="admin@admin.com" class="font-600"><?= "admin@admin.com" ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="col-6">
                                <div class="order-total float-right">
                                    <div class="row mb-2">
                                        <div class="col-6 col-left">
                                            <?= "Total"; ?>
                                        </div>
                                        <div class="col-6 col-right">
                                            <strong class="font-600"><?= $listing_fee + $transaction_fee; ?><?= "$"; ?></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        body {
                            font-size: 16px !important;
                        }

                        .logo img {
                            width: 160px;
                            height: auto;
                        }

                        .container-invoice {
                            max-width: 900px;
                            margin: 0 auto;
                        }

                        table {
                            border-bottom: 1px solid #dee2e6;
                        }

                        table th {
                            font-size: 14px;
                            white-space: nowrap;
                        }

                        .order-total {
                            width: 400px;
                            max-width: 100%;
                            float: right;
                            padding: 20px;
                        }

                        .order-total .col-left {
                            font-weight: 600;
                        }

                        .order-total .col-right {
                            text-align: right;
                        }

                        #btn_print {
                            min-width: 180px;
                        }

                        @media print {
                            .hidden-print {
                                display: none !important;
                            }
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-bottom: 100px;">
    <div class="row">
        <div class="col-12 text-center mt-3">
            <button id="btn_print" class="btn btn-secondary btn-md hidden-print">
                <svg id="i-print" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="16" height="16" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" style="margin-top: -4px;">
                    <path d="M7 25 L2 25 2 9 30 9 30 25 25 25 M7 19 L7 30 25 30 25 19 Z M25 9 L25 2 7 2 7 9 M22 14 L25 14"/>
                </svg>
                &nbsp;&nbsp;<?= trans("print"); ?></button>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script>
    $(document).on('click', '#btn_print', function () {
        window.print();
    });
</script>
</body>
</html>