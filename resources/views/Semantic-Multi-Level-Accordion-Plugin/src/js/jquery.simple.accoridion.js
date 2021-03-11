/*
 *  jquery.simple.accordion - v0.1.0
 *  
 *  https://github.com/uuutee/
 *
 *  Made by uuutee
 *  Under MIT License
 */
;(function($, window, document, undefined) {
    "use strict";

    // Create the defaults once
    var pluginName = "simpleAccordion",
        defaults = {
            useLinks: false,
            button: '<span class="ac-btn"></span>'
        };

    // The actual plugin constructor
    function simpleAccordion (element, options) {
        this.element = element;
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    // Avoid simpleAccordion.prototype conflicts
    $.extend(simpleAccordion.prototype, {
        init: function() {
            this.setProps();
            this.addLister();

            if (!this.settings.useLinks) {
                this.removeLinks();
            }
        },
        setProps: function() {
            var _this = this;

            $(_this.element).find('li').each(function (i) {
                var id = i + 1;

                $(this).addClass('ac-list-item').attr('data-ac-group', id);
                $(this).children('a').addClass('ac-anchor').attr('data-ac-group', id);
                $(this).children('ul').addClass('ac-list').attr('data-ac-group', id);

                // has child?
                if ($(this).has('ul').length > 0) {
                    $(this).addClass('ac-has-child');
                    $(this).append($(_this.settings.button).attr('data-ac-group', id));
                } else {
                    $(this).addClass('ac-no-child');
                }
            });
        },
        addLister: function() {
            var _this = this,
                targets;

            if (_this.settings.useLinks) {
                targets = '.ac-btn';
            } else {
                targets = '.ac-btn, .ac-anchor';
            }

            $(_this.element).find(targets).on('click', function(e) {
                var id = $(this).data('ac-group');
                _this.toggle(id);
            });
        },
        toggle: function(id) {
            var _this = this,
                $listItem = $(_this.element).find('li[data-ac-group=' + id + ']');

            if ($listItem.hasClass('is-open')) {
                $listItem.removeClass('is-open');
            } else {
                $listItem.addClass('is-open');
            }
        },
        removeLinks: function() {
            $(this.element).find('.ac-has-child').children('a').removeAttr('href');
        }
    });

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function(options) {
        return this.each(function() {
            if (!$.data(this, "plugin_" + pluginName)) {
                $.data(this, "plugin_" +
                    pluginName, new simpleAccordion(this, options));
            }
        });
    };

})(jQuery, window, document);
