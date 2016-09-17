
$(function() {

    var pidProductNew = 0;
    var popenpoup = true;
    var paddcart = true;
    ajaxCart.overrideButtonsInThePage = function() {
        //for every 'add' buttons...
        $(".content_prices .exclusive_cart").click(function() {
            $(this).parent().addClass('ploading');
        })
        $('.ajax_add_to_cart_button').unbind('click').click(function() {
            var idProduct = $(this).attr('rel').replace('nofollow', '').replace('ajax_id_product_', '');
            pidProductNew = $(this).attr('rel').replace('nofollow', '').replace('ajax_id_product_', '');

            if ($(this).attr('disabled') != 'disabled') {
                $(this).parent().addClass('ploading');
                ajaxCart.add(idProduct, null, false, this);
            }
            return false;
        });
        //for product page 'add' button...
        $('#add_to_cart input').unbind('click').click(function() {

            pidProductNew = $('#product_page_product_id').val();
            if ($(this).attr('disabled') != 'disabled') {
                $(this).parent().addClass('ploading');
                ajaxCart.add($('#product_page_product_id').val(), $('#idCombination').val(), true, null, $('#quantity_wanted').val(), null);
            }
            return false;
        });
        //for 'delete' buttons in the cart block...
        $('#cart_block_list .ajax_cart_block_remove_link').unbind('click').click(function() {
            // Customized product management
            var customizationId = 0;
            var productId = 0;
            var productAttributeId = 0;
            var customizableProductDiv = $($(this).parent().parent()).find("div[id^=deleteCustomizableProduct_]");
            if (customizableProductDiv && $(customizableProductDiv).length)
            {
                $(customizableProductDiv).each(function() {
                    var ids = $(this).attr('id').split('_');
                    if (typeof (ids[1]) != 'undefined')
                    {
                        customizationId = parseInt(ids[1]);
                        productId = parseInt(ids[2]);
                        if (typeof (ids[3]) != 'undefined')
                            productAttributeId = parseInt(ids[3]);
                        return false;
                    }
                });
            }

            // Common product management
            if (!customizationId)
            {
                //retrieve idProduct and idCombination from the displayed product in the block cart
                var firstCut = $(this).parent().parent().attr('id').replace('cart_block_product_', '');
                firstCut = firstCut.replace('deleteCustomizableProduct_', '');
                ids = firstCut.split('_');
                productId = parseInt(ids[0]);
                if (typeof (ids[1]) != 'undefined')
                    productAttributeId = parseInt(ids[1]);
            }

            var idAddressDelivery = $(this).parent().parent().attr('id').match(/.*_\d+_\d+_(\d+)/)[1];
            // Removing product from the cart
            ajaxCart.remove(productId, productAttributeId, customizationId, idAddressDelivery);
            return false;
        });
    };
    ajaxCart.updateCart = function(jsonData) {
        paddcart = false;
        $('body').find(".ploading .exclusive,.ploading .exclusive_disabled").attr('disabled', true);
        //user errors display
        if (jsonData.hasError) {
            var errors = '';
            for (error in jsonData.errors)
                //IE6 bug fix
                if (error != 'indexOf')
                    errors += $('<div />').html(jsonData.errors[error]).text() + "\n";
            alert(errors);
            popenpoup = false;
            paddcart = true;
            $('body').find('.ploading').removeClass('ploading');
            $('body').find(".ploading .exclusive,.ploading .exclusive_disabled").removeAttr('disabled');
        } else {
            ajaxCart.updateCartEverywhere(jsonData);
            ajaxCart.hideOldProducts(jsonData);
            ajaxCart.displayNewProducts(jsonData);
            ajaxCart.refreshVouchers(jsonData);
            //update 'first' and 'last' item classes
            $('#cart_block .products dt').removeClass('first_item').removeClass('last_item').removeClass('item');
            $('#cart_block .products dt:first').addClass('first_item');
            $('#cart_block .products dt:not(:first,:last)').addClass('item');
            $('#cart_block .products dt:last').addClass('last_item');
            //reset the onlick events in relation to the cart block (it allow to bind the onclick event to the new 'delete' buttons added)
            ajaxCart.overrideButtonsInThePage();
            if (popenpoup && pidProductNew > 0) {

                $.ajax({
                    url: MC_AJAX_CALL,
                    dataType: 'html',
                    data: {
                        id: pidProductNew,
                        id_product: pidProductNew,
                        id_lang: ID_LANG,
                        rand: new Date().getTime(),
                        type: 'process_popup'
                    },
                    success: function(data) {
                        $('body').find('.ploading').removeClass('ploading');
                        $('body').find(".ploading .exclusive,.ploading .exclusive_disabled").removeAttr('disabled');
                        $('body').append(data);
                        $('.popup-addcart').fancybox().click();
                        $('.popup-addcart').removeClass();
                        $('#pcontinueshop,exclusive').click(function() {
                            $.fancybox.close();
                        });
                        setTimeout(function() {

                            $('.modal-crossselling').find(".pcol").each(function(i) {
                                if ($(this).find('.attribute_fieldset').html() != null) {
                                    pfindCombination($(this));
                                    pgetProductAttribute();
                                }
                            });
                        }, 500);
                        paddcart = true;
                    }, error: function(XMLHttpRequest, textStatus, errorThrown) {
                        popenpoup = true;
                        paddcart = true;
                        $('body').find('.ploading').removeClass('ploading');
                        $('body').find(".ploading .exclusive,.ploading .exclusive_disabled").removeAttr('disabled');
                    }
                });
            }
            popenpoup = true;
        }
    };
    var timeinterval = '';
    ajaxCart.updateCartInformation = function(jsonData, addedFromProductPage)
    {
        ajaxCart.updateCart(jsonData);

        //reactive the button when adding has finished
        timeinterval = setInterval(function() {
            if (paddcart) {
                if (addedFromProductPage)
                    $('#add_to_cart input').removeAttr('disabled').addClass('exclusive').removeClass('exclusive_disabled');
                else
                    $('.ajax_add_to_cart_button').removeAttr('disabled');
                clearInterval(timeinterval);
            }
            //console.log(paddcart)
        }, 100)
    };
    ajaxCart.add = function(idProduct, idCombination, addedFromProductPage, callerElement, quantity, whishlist) {
        paddcart = false;
        if (addedFromProductPage && !checkCustomizations())
        {
            alert(fieldRequired);
            return;
        }
        emptyCustomizations();
        //disabled the button when adding to not double add if user double click
        if (addedFromProductPage)
        {
            $('#add_to_cart input').attr('disabled', true).removeClass('exclusive').addClass('exclusive_disabled');
            $('.filled').removeClass('filled');
        }
        else
            $(callerElement).attr('disabled', true);
        if ($('#cart_block_list').hasClass('collapsed'))
            this.expand();
        //send the ajax request to the server
        $.ajax({
            type: 'POST',
            headers: {"cache-control": "no-cache"},
            url: baseUri + '?rand=' + new Date().getTime(),
            async: true,
            cache: false,
            dataType: "json",
            data: 'controller=cart&add=1&ajax=true&qty=' + ((quantity && quantity != null) ? quantity : '1') + '&id_product=' + idProduct + '&token=' + static_token + ((parseInt(idCombination) && idCombination != null) ? '&ipa=' + parseInt(idCombination) : ''),
            success: function(jsonData, textStatus, jqXHR)
            {
                // add appliance to whishlist module
                if (whishlist && !jsonData.errors)
                    WishlistAddProductCart(whishlist[0], idProduct, idCombination, whishlist[1]);
                // add the picture to the cart
                var $element = $(callerElement).parent().parent().find('a.product_image img,a.product_img_link img');
                if (!$element.length)
                    $element = $('#bigpic');
                var $picture = $element.clone();
                var pictureOffsetOriginal = $element.offset();
                if ($picture.size())
                    $picture.css({'position': 'absolute', 'top': pictureOffsetOriginal.top, 'left': pictureOffsetOriginal.left});
                var pictureOffset = $picture.offset();
                if ($('#cart_block')[0] && $('#cart_block').offset().top && $('#cart_block').offset().left)
                    var cartBlockOffset = $('#cart_block').offset();
                else
                    var cartBlockOffset = $('#shopping_cart').offset();
                // Check if the block cart is activated for the animation
                if (cartBlockOffset != undefined && $picture.size())
                {
                    $picture.appendTo('body');
                    $picture.css({'position': 'absolute', 'top': $picture.css('top'), 'left': $picture.css('left'), 'z-index': 4242})
                            .animate({'width': $element.attr('width') * 0.66, 'height': $element.attr('height') * 0.66, 'opacity': 0.2, 'top': cartBlockOffset.top + 30, 'left': cartBlockOffset.left + 15}, 1000)
                            .fadeOut(100, function() {
                                ajaxCart.updateCartInformation(jsonData, addedFromProductPage);
                                $(this).remove();
                            });
                }
                else
                    ajaxCart.updateCartInformation(jsonData, addedFromProductPage);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert("Impossible to add the product to the cart.\n\ntextStatus: '" + textStatus + "'\nerrorThrown: '" + errorThrown + "'\nresponseText:\n" + XMLHttpRequest.responseText);
                //reactive the button when adding has finished
                if (addedFromProductPage)
                    $('#add_to_cart input').removeAttr('disabled').addClass('exclusive').removeClass('exclusive_disabled');
                else
                    $(callerElement).removeAttr('disabled');
            }
        });
    }
    ajaxCart.remove = function(idProduct, idCombination, customizationId, idAddressDelivery) {
//send the ajax request to the server
        $.ajax({
            type: 'POST',
            headers: {"cache-control": "no-cache"},
            url: baseUri + '?rand=' + new Date().getTime(),
            async: true,
            cache: false,
            dataType: "json",
            data: 'controller=cart&delete=1&id_product=' + idProduct + '&ipa=' + ((idCombination != null && parseInt(idCombination)) ? idCombination : '') + ((customizationId && customizationId != null) ? '&id_customization=' + customizationId : '') + '&id_address_delivery=' + idAddressDelivery + '&token=' + static_token + '&ajax=true',
            success: function(jsonData) {
                popenpoup = false;
                paddcart = true;
                ajaxCart.updateCart(jsonData);
                if ($('body').attr('id') == 'order' || $('body').attr('id') == 'order-opc')
                    deleteProductFromSummary(idProduct + '_' + idCombination + '_' + customizationId + '_' + idAddressDelivery);
            },
            error: function() {
                alert('ERROR: unable to delete the product');
                paddcart = true;
            }
        });
    }
    ajaxCart.overrideButtonsInThePage();
});