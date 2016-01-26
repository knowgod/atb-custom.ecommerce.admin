    <div class="mdl-grid">
        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
            <div class="grid-pop-header mdl-color--blue-500 ">
                <div class="mdl-layout-title">
                    <h4>Create Role</h4>
                </div>
                <button ng-click="onClose()" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored">
                    <i class="material-icons">close</i>
                </button>
            </div>

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/role/create') }}" ng-controller="GridFormController" ng-init="formUrl='{{ url("/role/create") }}';">

                <input type="hidden" name="_token" ng-model="formData._token" id="csrf-token" value="{{ csrf_token() }}" />

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" ng-class="{'is-invalid': formDataErrors.name}">
                    <input class="mdl-textfield__input" name="name" ng-model="formData.name" type="text" id="name" value="{{ old('name') }}" >
                    <label class="mdl-textfield__label" for="name">Role Name</label>
                    <span class="mdl-textfield__error"><% formDataErrors.name[0] %></span>
                </div>
                @foreach($permissions as $policy=>$policyPermissions)
                    <h6>{{$policy}}</h6>
                    @foreach($policyPermissions as $perm)
                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="{{$policy}}.{{$perm}}">
                          <input type="checkbox" id="{{$policy}}.{{$perm}}" name="{{$policy}}.{{$perm}}" class="mdl-checkbox__input">
                          <span class="mdl-checkbox__label">{{$perm}}</span>
                        </label>
                    @endforeach
                @endforeach

                <div class="buttons">
                    <button ng-click="dataSubmit()" type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                        Create Role
                    </button>
                </div>
            </form>
        </div>
    </div>