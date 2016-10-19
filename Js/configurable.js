/*
 * Override mot ham trong class
 */

Product.Config.prototype.getOptionLabel
        = Product.Config.prototype.getOptionLabel.wrap(function (parent, option, price) {// var price = parseFloat(price);
            var basePrice = parseFloat(this.config.basePrice);
            // 'price' as passed is the RELATIVE DIFFERENCE. We won't use it.
            //  The ABSOLUTE DIFFERENCE is in option.price (and option.oldPrice)
            var absoluteDifference = parseFloat(option.price);
            var absoluteFinalPrice = basePrice + absoluteDifference;
            // var price = parseFloat(price);
            var price = absoluteFinalPrice;
            if (this.taxConfig.includeTax) {
                var tax = price / (100 + this.taxConfig.defaultTax) * this.taxConfig.defaultTax;
                var excl = price - tax;
                var incl = excl * (1 + (this.taxConfig.currentTax / 100));
            } else {
                var tax = price * (this.taxConfig.currentTax / 100);
                var excl = price;
                var incl = excl + tax;
            }

            if (this.taxConfig.showIncludeTax || this.taxConfig.showBothPrices) {
                price = incl;
            } else {
                price = excl;
            }

            var str = option.label;
            //process show group price
            console.log( this.formatPrice(option.default_price, false))
            if (option.default_price > 0) {
                if (this.taxConfig.showBothPrices) {
                    str += ' ' + this.formatPrice(excl, true) + ' (' + this.formatPrice(option.default_price, true) + ' ' + this.taxConfig.inclTaxTitle + ')';
                } else {
                    str += ' ' + '<span class="default_price">' + this.formatPrice(option.default_price, true) + '</span>';
                }
                if (price) {
                    if (this.taxConfig.showBothPrices) {
                        str += ' ' + this.formatPrice(excl, false) + ' (' + this.formatPrice(price, false) + ' ' + this.taxConfig.inclTaxTitle + ')';
                    } else {
                        str += ' ' + '<span class="price">' + this.formatPrice(price, false) + '</span>';
                    }
                }
            } else {
                if (price) {
                    if (this.taxConfig.showBothPrices) {
                        str += ' ' + this.formatPrice(excl, true) + ' (' + this.formatPrice(price, true) + ' ' + this.taxConfig.inclTaxTitle + ')';
                    } else {
                        str += ' ' + '<span class="price">' + this.formatPrice(price, true) + '</span>';
                    }
                }
            }
            //end

            console.log(str);
            return str;

        });