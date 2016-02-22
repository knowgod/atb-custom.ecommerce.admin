/*jslint browser: true, multivar: true, this: true */
/*global window, componentHandler, datepickr */
/*property
 ACTIVE_CLASS, BUTTON, CssClasses_, ERROR, ICON, INPUT, IS_DIRTY,
 IS_DISABLED, IS_FOCUSED, IS_INVALID, IS_UPGRADED, LABEL,
 MDL_JS_RIPPLE_EFFECT, MDL_JS_RIPPLE_EFFECT_IGNORE_EVENTS, MDL_RIPPLE,
 MDL_RIPPLE_CONTAINER, MENU, MaterialAccordion, MaterialDatePicker,
 MaterialSelect, PANEL_CLASS, SELECT, TAB_CLASS, UPGRADED_CLASS, add,
 addEventListener, altInput, appendChild, bind, boundInputOnBlur,
 boundInputOnChange, boundInputOnClick, boundInputOnFocus,
 boundUpdateClassesHandler, boundUpdateHandler, change, checkDirty,
 checkDisabled, checkValidity, classAsString, classList, closeList,
 constructor, contains, createElement, createEvent, cssClass, dateFormat,
 disable, disabled, dispatchEvent, element_, enable, error_, exec,
 fireEvent, forEach, getAttribute, getDate, getFullYear, getMonth,
 hasOwnProperty, href, init, initCalendar, initChangeEvent, initEvent,
 initTabs_, innerHTML, innerText, inputMenu, inputSelect, input_,
 isValidDate, keys, label_, length, onBlur_, onChange_, onClick_, onFocus_,
 onInput_, openList, options, panels_, preventDefault, prototype,
 querySelector, querySelectorAll, register, remove, resetPanelState_,
 resetTabState_, selectedIndex, setAttribute, setItem, setValid, split,
 tabs_, target, text, updateClasses_, updateItems, valid, validity, value,
 widget
 */


(function () {

    'use strict';

    var MaterialSelect = function (element) {
        this.element_ = element;
        this.init();
    };
    window.MaterialSelect = MaterialSelect;

    MaterialSelect.prototype.CssClasses_ = {
        LABEL: 'mdl-select__label',
        INPUT: 'mdl-select__input',
        SELECT: 'mdl-select__select',
        MENU: 'mdl-select__menu',
        IS_DIRTY: 'is-dirty',
        IS_FOCUSED: 'is-focused',
        IS_DISABLED: 'is-disabled',
        IS_INVALID: 'is-invalid',
        IS_UPGRADED: 'is-upgraded'
    };

    MaterialSelect.prototype.updateClasses_ = function () {
        this.checkDisabled();
        this.checkValidity();
        this.checkDirty();
    };

    MaterialSelect.prototype.checkDisabled = function () {
        if (this.input_.disabled) {
            this.element_.classList.add(this.CssClasses_.IS_DISABLED);
        } else {
            this.element_.classList.remove(this.CssClasses_.IS_DISABLED);
        }
    };

    MaterialSelect.prototype.checkValidity = function () {
        if (this.input_.validity) {
            if (this.input_.validity.valid) {
                this.element_.classList.remove(this.CssClasses_.IS_INVALID);
            } else {
                this.element_.classList.add(this.CssClasses_.IS_INVALID);
            }
        }
    };

    MaterialSelect.prototype.checkDirty = function () {
        if (this.input_.value && this.input_.value.length > 0) {
            this.element_.classList.add(this.CssClasses_.IS_DIRTY);
            this.input_.value = this.inputSelect.options[this.inputSelect.selectedIndex].innerText;
        } else {
            this.element_.classList.remove(this.CssClasses_.IS_DIRTY);
            this.input_.value = this.inputSelect.options[0].innerText;
        }
    };

    MaterialSelect.prototype.disable = function () {
        this.input_.disabled = true;
        this.updateClasses_();
    };

    /**
     * Enable text field.
     *
     * @public
     */
    MaterialSelect.prototype.enable = function () {
        this.input_.disabled = false;
        this.updateClasses_();
    };


    MaterialSelect.prototype.change = function (value) {

        this.input_.value = value || '';
        this.updateClasses_();
    };

    MaterialSelect.prototype.onChange_ = function () {
        this.updateClasses_();
    };

    MaterialSelect.prototype.onFocus_ = function (event) {
        this.element_.classList.add(this.CssClasses_.IS_FOCUSED);
        event.preventDefault();
        this.openList();
    };

    MaterialSelect.prototype.onClick_ = function (event) {
        event.preventDefault();
        this.element_.classList.add(this.CssClasses_.IS_FOCUSED);
        this.openList();
    };

    MaterialSelect.prototype.onBlur_ = function () {
        this.element_.classList.remove(this.CssClasses_.IS_FOCUSED);
        setTimeout(this.closeList.bind(this), 100);
    };

    MaterialSelect.prototype.updateItems = function () {
        var tmpElement, options = this.inputSelect.querySelectorAll('option'), _self = this;
        this.inputMenu.innerHTML = '';
        Object.keys(options).forEach(function (key) {
            tmpElement = document.createElement('div');
            tmpElement.classList.add('mdl-js-ripple-effect');
            tmpElement.classList.add('mdl-menu__item');
            tmpElement.innerHTML = options[key].text;
            tmpElement.innerHTML += '<span class="mdl-menu__item-ripple-container"><span class="mdl-ripple"></span></span>';
            tmpElement.setAttribute('data-option-text', options[key].text);
            tmpElement.setAttribute('data-option-value', options[key].value);

            tmpElement.addEventListener('click', function (event) {
                _self.setItem(event.target.getAttribute('data-option-value'), event.target.getAttribute('data-option-text'));
            });

            _self.inputMenu.appendChild(tmpElement);

        });
    };

    MaterialSelect.prototype.setItem = function (value, text) {
        this.input_.value = text;
        this.inputSelect.value = value;
        this.closeList();
        this.updateClasses_();
        this.initChangeEvent();
    };

    MaterialSelect.prototype.initChangeEvent = function () {
        if (this.inputSelect.hasOwnProperty('fireEvent')) {
            this.inputSelect.fireEvent("onchange");
        } else {
            var evt = document.createEvent("HTMLEvents");
            evt.initEvent("change", false, true);
            this.inputSelect.dispatchEvent(evt);
        }
    };

    MaterialSelect.prototype.openList = function () {
        this.updateItems();
        this.inputMenu.classList.add('is-visible');
    };

    MaterialSelect.prototype.closeList = function () {
        this.inputMenu.classList.remove('is-visible');
    };

    MaterialSelect.prototype.init = function () {
        if (this.element_) {
            this.label_ = this.element_.querySelector('.' + this.CssClasses_.LABEL);
            this.input_ = this.element_.querySelector('.' + this.CssClasses_.INPUT);
            this.inputSelect = this.element_.querySelector('.' + this.CssClasses_.SELECT);
            this.inputMenu = this.element_.querySelector('.' + this.CssClasses_.MENU);

            this.input_.setAttribute('readonly', true);

            this.boundInputOnChange = this.onChange_.bind(this);
            this.boundInputOnFocus = this.onFocus_.bind(this);
            this.boundInputOnBlur = this.onBlur_.bind(this);
            this.boundInputOnClick = this.onClick_.bind(this);
            this.input_.addEventListener('change', this.boundInputOnChange);
            this.input_.addEventListener('focus', this.boundInputOnFocus);
            this.input_.addEventListener('blur', this.boundInputOnBlur);
            this.input_.addEventListener('click', this.boundInputOnClick);

            var selectedOption = this.inputSelect.querySelector('option[selected=selected]');
            if (selectedOption) {
                this.setItem(selectedOption.value, selectedOption.text);
            }

            this.updateClasses_();
            this.element_.classList.add(this.CssClasses_.IS_UPGRADED);
        }
    };

    //END OF: MaterialSelect

    var MaterialDatePicker = function (element) {
        this.element_ = element;
        this.init();
    };
    window.MaterialDatePicker = MaterialDatePicker;

    MaterialDatePicker.prototype.CssClasses_ = {
        LABEL: 'mdl-datepicker__label',
        INPUT: 'mdl-datepicker__input',
        ERROR: 'mdl-datepicker__error',
        ICON: 'mdl-datepicker__icon',
        BUTTON: 'mdl-datepicker__button',
        IS_DIRTY: 'is-dirty',
        IS_FOCUSED: 'is-focused',
        IS_DISABLED: 'is-disabled',
        IS_INVALID: 'is-invalid',
        IS_UPGRADED: 'is-upgraded'
    };

    MaterialDatePicker.prototype.updateClasses_ = function () {
        this.checkDisabled();
        this.checkValidity();
        this.checkDirty();
    };

    MaterialDatePicker.prototype.change = function (value) {
        this.input_.value = value || '';
        this.updateClasses_();
    };

    MaterialDatePicker.prototype.checkDisabled = function () {
        if (this.input_.disabled) {
            this.element_.classList.add(this.CssClasses_.IS_DISABLED);
        } else {
            this.element_.classList.remove(this.CssClasses_.IS_DISABLED);
        }
    };

    MaterialDatePicker.prototype.checkValidity = function () {
        if (this.input_.value && this.input_.value.length > 0) {
            if (this.isValidDate(this.input_.value)) {
                this.setValid();
            } else {
                this.element_.classList.add(this.CssClasses_.IS_INVALID);
                this.error_.innerHTML = 'Date is not valid';
            }
        } else {
            this.setValid();
        }
    };

    MaterialDatePicker.prototype.setValid = function () {
        this.element_.classList.remove(this.CssClasses_.IS_INVALID);
        this.error_.innerHTML = '';
    };

    MaterialDatePicker.prototype.checkDirty = function () {
        if (this.input_.value && this.input_.value.length > 0) {
            this.element_.classList.add(this.CssClasses_.IS_DIRTY);
        } else {
            this.element_.classList.remove(this.CssClasses_.IS_DIRTY);
        }
    };

    MaterialDatePicker.prototype.disable = function () {
        this.input_.disabled = true;
        this.updateClasses_();
    };

    MaterialDatePicker.prototype.enable = function () {
        this.input_.disabled = false;
        this.updateClasses_();
    };

    MaterialDatePicker.prototype.onFocus_ = function () {
        this.element_.classList.add(this.CssClasses_.IS_FOCUSED);
    };

    MaterialDatePicker.prototype.onClick_ = function () {
        this.element_.classList.add(this.CssClasses_.IS_FOCUSED);
    };

    MaterialDatePicker.prototype.onBlur_ = function () {
        this.element_.classList.remove(this.CssClasses_.IS_FOCUSED);
    };

    MaterialDatePicker.prototype.onInput_ = function () {
        this.updateClasses_();
    };

    MaterialDatePicker.prototype.isValidDate = function () {
        var matches = /^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/.exec(this.input_.value);
        if (matches === null) {
            return false;
        }
        var d = matches[2];
        var m = matches[1] - 1;
        var y = matches[3];
        var composedDate = new Date(y, m, d);

        return composedDate.getDate() === d && composedDate.getMonth() === m && composedDate.getFullYear() === y;
    };

    MaterialDatePicker.prototype.initCalendar = function () {

        datepickr('.' + this.CssClasses_.BUTTON, {
            altInput: this.input_,
            dateFormat: 'm/d/Y'
        });
        var prev = this.element_.querySelector('.datepickr-prev-month'),
            next = this.element_.querySelector('.datepickr-next-month');

        prev.innerHTML = 'keyboard_arrow_left';
        next.innerHTML = 'keyboard_arrow_right';

    };

    MaterialDatePicker.prototype.init = function () {
        if (this.element_) {
            this.label_ = this.element_.querySelector('.' + this.CssClasses_.LABEL);
            this.input_ = this.element_.querySelector('.' + this.CssClasses_.INPUT);
            this.error_ = this.element_.querySelector('.' + this.CssClasses_.ERROR);

            this.boundUpdateClassesHandler = this.updateClasses_.bind(this);
            this.boundUpdateHandler = this.onInput_.bind(this);
            this.boundInputOnFocus = this.onFocus_.bind(this);
            this.boundInputOnBlur = this.onBlur_.bind(this);
            this.boundInputOnClick = this.onClick_.bind(this);

            this.input_.addEventListener('change', this.boundUpdateClassesHandler);
            this.input_.addEventListener('input', this.boundUpdateHandler);
            this.input_.addEventListener('focus', this.boundInputOnFocus);
            this.input_.addEventListener('blur', this.boundInputOnBlur);
            this.input_.addEventListener('click', this.boundInputOnClick);

            this.initCalendar();
            this.updateClasses_();
            this.element_.classList.add(this.CssClasses_.IS_UPGRADED);
        }
    };

    //END OF: MaterialDatePicker

    function MaterialAccordionTab(tab, ctx) {
        if (tab) {
            var rippleContainer = document.createElement('span'),
                ripple = document.createElement('span');

            rippleContainer.classList.add(ctx.CssClasses_.MDL_RIPPLE_CONTAINER);
            rippleContainer.classList.add(ctx.CssClasses_.MDL_JS_RIPPLE_EFFECT);
            ripple.classList.add(ctx.CssClasses_.MDL_RIPPLE);
            rippleContainer.appendChild(ripple);
            tab.appendChild(rippleContainer);

            tab.addEventListener('click', function (e) {
                e.preventDefault();
                var href = tab.href.split('#')[1];
                var panel = ctx.element_.querySelector('#' + href);
                ctx.resetTabState_();
                ctx.resetPanelState_();
                tab.classList.add(ctx.CssClasses_.ACTIVE_CLASS);
                panel.classList.add(ctx.CssClasses_.ACTIVE_CLASS);
            });

        }
    }

    var MaterialAccordion = function (element) {
        this.element_ = element;

        this.init();
    };
    window.MaterialAccordion = MaterialAccordion;

    MaterialAccordion.prototype.CssClasses_ = {
        TAB_CLASS: 'mdl-accordion__tab',
        PANEL_CLASS: 'mdl-accordion__panel',
        ACTIVE_CLASS: 'is-active',
        UPGRADED_CLASS: 'is-upgraded',

        MDL_JS_RIPPLE_EFFECT: 'mdl-js-ripple-effect',
        MDL_RIPPLE_CONTAINER: 'mdl-accordion__ripple-container',
        MDL_RIPPLE: 'mdl-ripple',
        MDL_JS_RIPPLE_EFFECT_IGNORE_EVENTS: 'mdl-js-ripple-effect--ignore-events'
    };

    MaterialAccordion.prototype.initTabs_ = function () {
        var _self = this, materialAccordionTab;
        if (this.element_.classList.contains(this.CssClasses_.MDL_JS_RIPPLE_EFFECT)) {
            this.element_.classList.add(this.CssClasses_.MDL_JS_RIPPLE_EFFECT_IGNORE_EVENTS);
        }

        // Select element tabs, document panels
        this.tabs_ = this.element_.querySelectorAll('.' + this.CssClasses_.TAB_CLASS);
        this.panels_ = this.element_.querySelectorAll('.' + this.CssClasses_.PANEL_CLASS);

        // Create new tabs for each tab element
        Object.keys(this.tabs_).forEach(function (key) {
            materialAccordionTab = new MaterialAccordionTab(_self.tabs_[key], _self);
        });

        this.element_.classList.add(this.CssClasses_.UPGRADED_CLASS);

        return materialAccordionTab;
    };

    MaterialAccordion.prototype.resetTabState_ = function () {
        var _self = this;
        Object.keys(this.tabs_).forEach(function (key) {
            _self.tabs_[key].classList.remove(_self.CssClasses_.ACTIVE_CLASS);
        });
    };

    MaterialAccordion.prototype.resetPanelState_ = function () {
        var _self = this;
        Object.keys(this.panels_).forEach(function (key) {
            _self.panels_[key].classList.remove(_self.CssClasses_.ACTIVE_CLASS);
        });
    };

    MaterialAccordion.prototype.init = function () {
        if (this.element_) {
            this.initTabs_();
        }
    };

    //END OF: MaterialAccordion

    componentHandler.register({
        constructor: MaterialSelect,
        classAsString: 'MaterialSelect',
        cssClass: 'mdl-js-select',
        widget: true
    });

    componentHandler.register({
        constructor: MaterialDatePicker,
        classAsString: 'MaterialDatePicker',
        cssClass: 'mdl-js-datepicker',
        widget: true
    });

    componentHandler.register({
        constructor: MaterialAccordion,
        classAsString: 'MaterialAccordion',
        cssClass: 'mdl-js-accordion',
        widget: true
    });

}());