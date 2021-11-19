$(function() {
    $('.js-popup-add').contentPopup({
        mode: 'click',
        btnOpen: '',
        popup: '.js-popup',
        hideOnClickLink: false,
        openClass: 'is-popup-open',
        btnClose: '.js-popup-close',
    });
})

// popup plugin
;(function($) {
    function ContentPopup(opt) {
        this.options = $.extend({
            holder: null,
            popup: '.popup',
            btnOpen: '.open',
            btnClose: '.close',
            openClass: 'popup-active',
            clickEvent: 'click',
            mode: 'click',
            hideOnClickLink: true,
            hideOnClickOutside: true,
            delay: 50,
            onShow: function () {}
        }, opt);
        if (this.options.holder) {
            this.holder = $(this.options.holder);
            this.init();
        }
    }
    ContentPopup.prototype = {
        init: function() {
            this.findElements();
            this.attachEvents();
        },
        findElements: function() {
            this.popup = this.holder.find(this.options.popup);
            this.btnClose = this.holder.find(this.options.btnClose);
            //this.btnOpen = this.holder.find(this.options.btnOpen);

            if(this.options.btnOpen.length === 0) {
                this.btnOpen = this.holder;
            } else {
                this.btnOpen = this.holder.find(this.options.btnOpen);
            }
        },
        attachEvents: function() {
            // handle popup openers
            var self = this;
            this.clickMode = isTouchDevice || (self.options.mode === self.options.clickEvent);

            if (this.clickMode) {
                // handle click mode
                this.btnOpen.bind(self.options.clickEvent + '.popup', function(e) {
                    if (self.holder.hasClass(self.options.openClass)) {
                        if (self.options.hideOnClickLink) {
                            self.hidePopup();
                        }
                    } else {
                        self.showPopup();
                    }
                    e.preventDefault();
                });

                // prepare outside click handler
                this.outsideClickHandler = this.bind(this.outsideClickHandler, this);
            } else {
                // handle hover mode
                var timer, delayedFunc = function(func) {
                    clearTimeout(timer);
                    timer = setTimeout(function() {
                        func.call(self);
                    }, self.options.delay);
                };
                this.btnOpen.on('mouseover.popup', function() {
                    delayedFunc(self.showPopup);
                }).on('mouseout.popup', function() {
                    delayedFunc(self.hidePopup);
                });
                this.popup.on('mouseover.popup', function() {
                    delayedFunc(self.showPopup);
                }).on('mouseout.popup', function() {
                    delayedFunc(self.hidePopup);
                });
            }

            // handle close buttons
            this.btnClose.on(self.options.clickEvent + '.popup', function(e) {
                self.hidePopup();
                e.preventDefault();
                e.stopPropagation();
            });
        },
        outsideClickHandler: function(e) {
            // hide popup if clicked outside
            var targetNode = $((e.changedTouches ? e.changedTouches[0] : e).target);
            if (!targetNode.closest(this.popup).length && !targetNode.closest(this.btnOpen).length) {
                this.hidePopup();
            }
        },
        showPopup: function() {
            // reveal popup
            let self = this;
            self.holder.addClass(self.options.openClass);
            self.popup.css({
                display: 'block'
            });

            // outside click handler
            if (self.clickMode && self.options.hideOnClickOutside && !self.outsideHandlerActive) {
                self.outsideHandlerActive = true;
                $(document).on('click touchstart', self.outsideClickHandler);
            }

            setTimeout(function () {
                if (self.options.onShow !== undefined) {
                    self.options.onShow();
                }
            }, 200);
        },
        hidePopup: function() {
            // hide popup
            let popupHolder = this.holder;

            popupHolder.parent().addClass('is-popup-closed');
            popupHolder.removeClass(this.options.openClass);
            this.popup.css({
                display: 'none'
            });

            setTimeout(function () {
                // Todo: need to be one parent

                popupHolder.parents('.team').removeClass(function (index, className) {
                    return (className.match (/(^|\s)popup-opened-\S+/g) || []).join(' ');
                });
            }, 100);

            // outside click handler
            if (this.clickMode && this.options.hideOnClickOutside && this.outsideHandlerActive) {
                this.outsideHandlerActive = false;
                $(document).off('click touchstart', this.outsideClickHandler);
            }
        },
        bind: function(f, scope, forceArgs) {
            return function() {
                return f.apply(scope, forceArgs ? [forceArgs] : arguments);
            };
        },
        destroy: function() {
            this.popup.removeAttr('style');
            this.holder.removeClass(this.options.openClass);
            this.btnOpen.add(this.btnClose).add(this.popup).off('.popup');
            $(document).off('click touchstart', this.outsideClickHandler);
        }
    };

    // detect touch devices
    var isTouchDevice = /Windows Phone/.test(navigator.userAgent) || ('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch;

    // jQuery plugin interface
    $.fn.contentPopup = function(opt) {
        var args = Array.prototype.slice.call(arguments);
        var method = args[0];

        return this.each(function() {
            var $holder = jQuery(this);
            var instance = $holder.data('ContentPopup');

            if (typeof opt === 'object' || typeof opt === 'undefined') {
                $holder.data('ContentPopup', new ContentPopup($.extend({
                    holder: this
                }, opt)));
            } else if (typeof method === 'string' && instance) {
                if (typeof instance[method] === 'function') {
                    args.shift();
                    instance[method].apply(instance, args);
                }
            }
        });
    };
}(jQuery));
