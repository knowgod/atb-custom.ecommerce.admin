<div class="mdl-grid">
    <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        <div class="grid-pop-header mdl-color--blue-500 ">
            <div class="mdl-layout-title">
                <h4>Invite User</h4>
            </div>
            <button ng-click="onClose()" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored">
                <i class="material-icons">close</i>
            </button>
        </div>
        <form action="/" method="POST" class="form-horizontal" ng-controller="GridFormController" ng-init="formUrl='{{ url("/invite/store") }}';">

            <input type="hidden" name="_token" ng-model="formData._token" id="csrf-token" value="{{ csrf_token() }}" />

            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" ng-class="{'is-invalid': formDataErrors.email }">
                <input class="mdl-textfield__input" name="email" ng-model="formData.email" type="text" id="email" value="" >
                <label class="mdl-textfield__label" for="email">E-Mail Address</label>
                <span class="mdl-textfield__error"><% formDataErrors.email[0] %></span>
            </div>

            <div class="buttons">
                <button ng-click="dataSubmit()" type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                    Invite User
                </button>
            </div>
        </form>
    </div>
</div>


