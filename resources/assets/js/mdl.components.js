(function() {
    'use strict';

    var MaterialSelect = function MaterialSelect(element) {
        this.element_ = element;
        this.init();
    };
    window['MaterialSelect'] = MaterialSelect;

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

    MaterialSelect.prototype.updateClasses_ = function() {
        this.checkDisabled();
        this.checkValidity();
        this.checkDirty();
    };

    MaterialSelect.prototype.checkDisabled = function() {
        if (this.input_.disabled) {
            this.element_.classList.add(this.CssClasses_.IS_DISABLED);
        } else {
            this.element_.classList.remove(this.CssClasses_.IS_DISABLED);
        }
    };
    MaterialSelect.prototype['checkDisabled'] = MaterialSelect.prototype.checkDisabled;

    MaterialSelect.prototype.checkValidity = function() {
        if (this.input_.validity) {
            if (this.input_.validity.valid) {
                this.element_.classList.remove(this.CssClasses_.IS_INVALID);
            } else {
                this.element_.classList.add(this.CssClasses_.IS_INVALID);
            }
        }
    };
    MaterialSelect.prototype['checkValidity'] = MaterialSelect.prototype.checkValidity;


    MaterialSelect.prototype.checkDirty = function() {
        if (this.input_.value && this.input_.value.length > 0) {
            this.element_.classList.add(this.CssClasses_.IS_DIRTY);
            this.input_.value = this.inputSelect.options[this.inputSelect.selectedIndex].innerText;
        } else {
            this.element_.classList.remove(this.CssClasses_.IS_DIRTY);
            this.input_.value = this.inputSelect.options[0].innerText;
        }
    };
    MaterialSelect.prototype['checkDirty'] = MaterialSelect.prototype.checkDirty;

    MaterialSelect.prototype.disable = function() {
        this.input_.disabled = true;
        this.updateClasses_();
    };
    MaterialSelect.prototype['disable'] = MaterialSelect.prototype.disable;

    /**
     * Enable text field.
     *
     * @public
     */
    MaterialSelect.prototype.enable = function() {
        this.input_.disabled = false;
        this.updateClasses_();
    };
    MaterialSelect.prototype['enable'] = MaterialSelect.prototype.enable;


    MaterialSelect.prototype.change = function(value) {

        this.input_.value = value || '';
        this.updateClasses_();
    };
    MaterialSelect.prototype['change'] = MaterialSelect.prototype.change;

    MaterialSelect.prototype.onChange_ = function(event) {
        this.updateClasses_();
    };

    MaterialSelect.prototype.onFocus_ = function(event) {
        this.element_.classList.add(this.CssClasses_.IS_FOCUSED);
        event.preventDefault();
        this.openList();
    };

    MaterialSelect.prototype.onClick_ = function(event) {
        event.preventDefault();
        this.element_.classList.add(this.CssClasses_.IS_FOCUSED);
        this.openList();
    };

    MaterialSelect.prototype.onBlur_ = function(event) {
        this.element_.classList.remove(this.CssClasses_.IS_FOCUSED);
        setTimeout(this.closeList.bind(this), 100);
    };

    MaterialSelect.prototype.updateItems = function() {
        var tmpElement, options = this.inputSelect.querySelectorAll('option');
        this.inputMenu.innerHTML = '';

        for(var i=0; i<options.length; i++){
            tmpElement = document.createElement('div');
            tmpElement.classList.add('mdl-js-ripple-effect');
            tmpElement.classList.add('mdl-menu__item');
            tmpElement.innerHTML = options[i].text;
            tmpElement.innerHTML += '<span class="mdl-menu__item-ripple-container"><span class="mdl-ripple"></span></span>';
            tmpElement.setAttribute('data-option-text', options[i].text);
            tmpElement.setAttribute('data-option-value', options[i].value);

            tmpElement.addEventListener('click', function(event){
                this.setItem(event.target.getAttribute('data-option-value'), event.target.getAttribute('data-option-text'));
            }.bind(this)) ;

            this.inputMenu.appendChild(tmpElement);
        }
    };

    MaterialSelect.prototype.setItem = function(value, text) {
        this.input_.value = text;
        this.inputSelect.value = value;
        this.closeList();
        this.updateClasses_();
        this.initChangeEvent();
    };

    MaterialSelect.prototype.initChangeEvent = function() {
        if ('fireEvent' in this.inputSelect)
            this.inputSelect.fireEvent("onchange");
        else {
            var evt = document.createEvent("HTMLEvents");
            evt.initEvent("change", false, true);
            this.inputSelect.dispatchEvent(evt);
        }
    };

    MaterialSelect.prototype.openList = function() {
        this.updateItems();
        this.inputMenu.classList.add('is-visible');
    };

    MaterialSelect.prototype.closeList = function() {
        this.inputMenu.classList.remove('is-visible');
    };

    MaterialSelect.prototype.init = function() {
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
            if(selectedOption){
                this.setItem(selectedOption.value, selectedOption.text);
            }

            this.updateClasses_();
            this.element_.classList.add(this.CssClasses_.IS_UPGRADED);
            this.inputSelect.addEventListener('change', function(event){
                console.log(this.value)
            });
        }
    };

    //END OF: MaterialSelect

    componentHandler.register({
        constructor: MaterialSelect,
        classAsString: 'MaterialSelect',
        cssClass: 'mdl-js-select',
        widget: true
    });

})();