    <div class="mdl-grid">
        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
            <div class="grid-pop-header mdl-color--blue-500 ">
                <div class="mdl-layout-title">
                    <h4>Create User</h4>
                </div>
                <button ng-click="onClose()" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored">
                    <i class="material-icons">close</i>
                </button>
            </div>

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/user/create') }}" ng-controller="GridFormController" ng-init="formUrl='{{ url("/user/create") }}';" onsubmit="return false;">

                <input type="hidden" name="_token" ng-model="formData._token" id="csrf-token" value="{{ csrf_token() }}" />

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" ng-class="{'is-invalid': formDataErrors.firstname}">
                    <input class="mdl-textfield__input" name="firstname" ng-model="formData.firstname" type="text" id="firstname" value="{{ old('firstname') }}" >
                    <label class="mdl-textfield__label" for="firstname">First Name</label>
                    <span class="mdl-textfield__error"><% formDataErrors.firstname[0] %></span>
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" ng-class="{'is-invalid': formDataErrors.lastname}">
                    <input class="mdl-textfield__input" name="lastname" ng-model="formData.lastname" type="text" id="lastname" value="{{ old('lastname') }}" >
                    <label class="mdl-textfield__label" for="lastname">Last Name</label>
                    <span class="mdl-textfield__error"><% formDataErrors.lastname[0] %></span>
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" ng-class="{'is-invalid': formDataErrors.email }">
                    <input class="mdl-textfield__input" name="email" ng-model="formData.email" type="text" id="email" value="" >
                    <label class="mdl-textfield__label" for="email">E-Mail Address</label>
                    <span class="mdl-textfield__error"><% formDataErrors.email[0] %></span>
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" ng-class="{'is-invalid': formDataErrors.password}">
                    <input class="mdl-textfield__input" name="password" ng-model="formData.password" type="password" id="password" value="" >
                    <label class="mdl-textfield__label" for="password">Password</label>
                    <span class="mdl-textfield__error"><% formDataErrors.password[0] %></span>
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" ng-class="{'is-invalid': formDataErrors.password_confirmation}">
                    <input class="mdl-textfield__input" name="password_confirmation" ng-model="formData.password_confirmation" type="password" id="password_confirmation" value="" >
                    <label class="mdl-textfield__label" for="password_confirmation">Confirm Password</label>
                    <span class="mdl-textfield__error"><% formDataErrors.password_confirmation[0] %></span>
                </div>

                <div class="mdl-select mdl-js-select mdl-select--floating-label">
                    <div class="mdl-select__container">
                        <input class="mdl-select__input" name="user_role_text" type="text"  value="" >
                    </div>
                    <span class="mdl-select__error"></span>
                    <label class="mdl-select__label" for="user_role">User Role
                        <select class="mdl-select__select" id="user_role" ng-model="formData.user_role" name="user_role">
                            <option value="">Please Select</option>
                            @foreach($roles_list as $role)
                                <option value="{{$role->getId()}}">{{$role->getName()}}</option>
                            @endforeach
                        </select>
                    </label>
                    <div class="mdl-select__menu mdl-shadow--2dp bottom"></div>
                </div>

                <div class="buttons">
                    <button ng-click="dataSubmit()" type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>