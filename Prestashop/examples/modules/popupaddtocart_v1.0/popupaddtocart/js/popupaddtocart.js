$(function() {

    ajaxCart.refresh();

    var ajaxCartUpdateCartOrig = ajaxCart.updateCart;

    var lastCart = false;

    $('.cart_quantity_down, .cart_quantity_up').click(function() {
        lastCart = false;
    });

    ajaxCart.updateCart = function(jsonData) {
        ajaxCartUpdateCartOrig(jsonData);

        if (lastCart !== false) {
            var product = false;
            var quantity = false;
            if (lastCart.productTotal > 0) {
                var total = jsonData.productTotal - lastCart.productTotal;
            } else {
                var total = jsonData.productTotal;
            }
            if (lastCart.products.length < jsonData.products.length) {
                console.log('Product add to cart - 01');
                if (lastCart.products.length == 0) {
                    $.each(jsonData.products, function(j, newProducts) {
                        product = newProducts;
                        quantity = newProducts.quantity;
                        return;
                    });
                } else {
                    $.each(lastCart.products, function(i, oldProducts) {
                        $.each(jsonData.products, function(j, newProducts) {
                            if (newProducts.id != oldProducts.id
                                    || newProducts.id == oldProducts.id && newProducts.idAddressDelivery != oldProducts.idAddressDelivery
                                    || newProducts.id == oldProducts.id && newProducts.idCombination != oldProducts.idCombination
                                    || newProducts.id == oldProducts.id && newProducts.idAddressDelivery == oldProducts.idAddressDelivery && newProducts.customizedDatas.toString() != oldProducts.customizedDatas.toString()
                                    || newProducts.id == oldProducts.id && newProducts.idCombination == oldProducts.idCombination && newProducts.customizedDatas.toString() != oldProducts.customizedDatas.toString()
                                    ) {
                                product = newProducts;
                                quantity = newProducts.quantity;
                                return;
                            }
                        });
                        if (product !== false) {
                            return;
                        }
                    });
                }
            } else if (parseInt(lastCart.nbTotalProducts) < parseInt(jsonData.nbTotalProducts) && MC_DISPLAY_WHEN_PRODUCTS_EXISTS) {
                console.log('Product add to cart - 02');
                $.each(lastCart.products, function(i, oldProducts) {
                    $.each(jsonData.products, function(j, newProducts) {
                        if (newProducts.id == oldProducts.id && newProducts.idAddressDelivery == oldProducts.idAddressDelivery && newProducts.idCombination == oldProducts.idCombination && newProducts.customizedDatas.toString() == oldProducts.customizedDatas.toString() && newProducts.quantity > oldProducts.quantity
                                ) {
                            product = newProducts;
                            quantity = newProducts.quantity - oldProducts.quantity;
                            return;
                        }
                    });
                    if (product !== false) {
                        return;
                    }
                });
            }

            if (product !== false) {
                var imgmain = '';
                $.ajax({
                    url: MC_AJAX_CALL,
                    dataType: 'html',
                    data: {
                        id_product: product.id,
                        id_lang: ID_LANG,
                        type: 'check_accessories'
                    },
                    success: function(data) {
                        if (parseInt($.trim(data)) == 1)
                            $.ajax({
                                url: MC_AJAX_CALL,
                                dataType: 'html',
                                data: {
                                    id: product.id,
                                    id_product: product.id,
                                    idCombination: product.idCombination,
                                    customizedDatas: product.customizedDatas,
                                    quantity: quantity,
                                    total: total,
                                    id_lang: ID_LANG,
                                    type: 'process_popup'
                                },
                                success: function(data) {
                                    $("#product_list li").each(function() {
                                        var ahref = $(this).find('a.product_img_link, a.product_image').attr('href');
                                        if (ahref.indexOf('id_product=' + product.id) != -1) {
                                            imgmain = $(this).find('a.product_img_link > img, a.product_image > img').attr('src');
                                            console.log(imgmain)
                                        }
                                    })
                                    //console.log('success', data);
                                    //console.log('here')
                                    $('.modal-crossselling').remove();
                                    $('body').append(data);
                                    $('body').addClass('js-no-scroll');
                                    $('html,body').animate({
                                        scrollTop: 100 + 'px'
                                    }, 700);
                                    $(".modal-crossselling").show();
                                    setTimeout(function() {
                                        $('.modal-crossselling').find(".pcol").each(function(i) {
                                            if ($(this).find('.attribute_fieldset').html() != null) {
                                                pfindCombination($(this));
                                                pgetProductAttribute();
                                            }
                                        });
                                        if (imgmain == '') {
                                            imgmain = $("#bigpic").attr('src');
                                        }
                                        imgmain = imgmain.replace("-large_default.jpg", "-small_default.jpg");
                                        imgmain = imgmain.replace("-large.jpg", "-small_default.jpg");
                                        $(".pimgproduct").attr('src', imgmain);

                                        var quantity_wanted = $("#buy_block #quantity_wanted").val();
                                        quantity_wanted = typeof quantity_wanted != 'undefined' ? quantity_wanted : 1;

                                        $(".des-main-poup").html();
                                        $(".des-main-poup").html(quantity_wanted + ' x ' + $("#current_product_name").val())

                                    }, 500);
                                }
                            });
                    }
                })
            }
        }

        console.log(jsonData);
        lastCart = jsonData
    };
});