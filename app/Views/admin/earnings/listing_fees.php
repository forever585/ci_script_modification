<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $title; ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" role="grid">
                        <div class="row table-filter-container">
                            <div class="col-sm-12">
                                <form action="<?= adminUrl('listing-fees'); ?>" method="get">
                                    <div class="item-table-filter" style="width: 80px; min-width: 80px;">
                                        <label><?= trans("show"); ?></label>
                                        <select name="show" class="form-control">
                                            <option value="15" <?= inputGet('show', true) == '15' ? 'selected' : ''; ?>>15</option>
                                            <option value="30" <?= inputGet('show', true) == '30' ? 'selected' : ''; ?>>30</option>
                                            <option value="60" <?= inputGet('show', true) == '60' ? 'selected' : ''; ?>>60</option>
                                            <option value="100" <?= inputGet('show', true) == '100' ? 'selected' : ''; ?>>100</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <thead>
                        <tr role="row">
                            <th><?= trans('id'); ?></th>
                            <th><?= "Seller Name"; ?></th>
                            <th><?= "Product Title"; ?></th>
                            <th><?= "Status"; ?></th>
                            <th><?= "Invoice"; ?></th>
                            <th><?= "Is Relisting Fee"; ?></th>
                            <th><?= "Assigned Date"; ?></th>
                            <th><?= "Paid Date"; ?></th>
                            <th><?= "Action"; ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($listing_fees)):
                            foreach ($listing_fees as $item): ?>
                            <tr>
                                <td><?= $item->id?></td>
                                <td><?= $item->username?></td>
                                <td><?= $item->title?></td>
                                <td><?= $item->is_paid ? "Paid" : "Assigned";?></td>
                                <td>
                                    <?php if($item->is_invoice_set):?>
                                        <a href="<?= base_url('invoice-listing-fee/' . $item->id ); ?>" class="btn btn-sm btn-default" target="_blank">
                                            <i class="fa fa-file-text"></i>&nbsp;&nbsp;<?= trans("view_invoice"); ?>
                                        </a>
                                    <?php else:?>
                                        <span>Not Set</span>
                                    <?php endif;?>
                                </td>
                                <td><?= $item->is_relisting ? "Yes" : "No";?></td>
                                <td><?= $item->created_at?></td>
                                <td><?= $item->is_paid ? $item->updated_at : "Not Paid"; ?></td>
                                <td>
                                    <form action="<?= adminUrl('set-listing-fee-paid/'.$item->id); ?>" method="get" class="form-inline inline-flex align-items-center">
                                        <?= csrf_field(); ?>
                                        <input name="seller_id" type="hidden" value="<?= $item->seller_id; ?>"/>
                                        <input type="hidden" name="back_url" value="<?= adminUrl('/listing-fees'); ?>">
                                        <?php if (!$item->is_paid): ?>
                                            <p class="margin-0">
                                                <button type="submit" class="btn btn-sm btn-primary margin-bottom-0 margin-left-10 btn-vacation"><i class="fa fa-check"></i><?= "  Set Paid"; ?></button>
                                            </p>
                                        <?php else: ?>
                                            <p class="margin-0">
                                                <button type="submit" disabled class="btn btn-sm btn-pricing-table-disabled margin-bottom-0 margin-left-10 btn-vacation"><i class="fa fa-ban"></i><?= "  Already Paid" ?></button>
                                            </p>
                                        <?php endif; ?>
                                    </form>
                                </td>
                            </tr>

                            <?php endforeach;
                        endif; ?>
                        </tbody>
                    </table>
                    <?php if (empty($listing_fees)): ?>
                        <p class="text-center">
                            <?= trans("no_records_found"); ?>
                        </p>
                    <?php endif; ?>
                    <div class="col-sm-12 table-ft">
                        <div class="row">
                            <div class="pull-right">
                                <?= view('partials/_pagination'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>