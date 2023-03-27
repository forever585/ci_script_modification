//enable or disable vacation mode
function enableDisableVacation(shopId, state){
        var data = {
            "shop_id": shopId,
            "state": state,
        };
        data[mds_config.csfr_token_name] = $.cookie(mds_config.csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: mds_config.base_url + 'ajax_controller/enable_disable_vacation',
            data: data,
            success: function (response) {
                var obj = JSON.parse(response);
                console.log(obj);
            }
        });
}
