<?php
/**
 * Created by PhpStorm.
 * User: PKR
 * Date: 3/13/2023
 * Time: 6:39 PM
 */
$name = getUsernameByUserId(clrNum($id));
?>
<form action="<?= base_url('leave-message-to-seller'); ?>" method="post" class="m-t-10">
    <?= csrf_field(); ?>
    <label class="font-600"><?php echo "Leave Message To <strong style='color: blue'>" . $name."</strong>"; ?></label>
    <input type="hidden" name="buyer_id" value="<?php echo user()->id; ?>"/>
    <input type="hidden" name="seller_id" value="<?php echo $id; ?>"/>
    <input type="hidden" name="back_url" value="<?= generateUrl('cart') ?>">
    <textarea type="text" name="message" class="form-control form-input">
        <?php if(isExistMessageFromBuyerToSeller(user()->id,$id)) :
            echo getMessageFromBuyerToSeller(user()->id,$id)->message;
        ?>
        <?php endif;?>
    </textarea>
    <button type="submit" class="btn btn-custom leave-message-for-seller-btn"><?= "Submit" ?></button>
</form>
