<div class="mdl-layout__drawer" ng-controller="GridLeftController">
    <nav class="mdl-navigation">

        <a class="mdl-navigation__link" href="/"><i class="material-icons target">equalizer</i>Reports</a>

        <span class="mdl-navigation__separator"></span>

        <a class="mdl-navigation__link" href="/"><i class="material-icons target">view_column</i>Grid Columns</a>
        <a class="mdl-navigation__link" href="/"><i class="material-icons target">filter_list</i>Manage Filters</a>

        <span class="mdl-navigation__separator"></span>

        <a class="mdl-navigation__link" href="" ng-click="invokeHtmlAction('{{ url("/invite/create")}}')"><i class="material-icons target">add</i>Create</a>
        <a class="mdl-navigation__link" href=""><i class="material-icons target">call_made</i>Import</a>
        <a class="mdl-navigation__link" href=""><i class="material-icons target">call_received</i>Export</a>

        <div class="mdl-layout-spacer"></div>

        <span class="mdl-navigation__separator"></span>
        <a class="mdl-navigation__link" href=""><i class="material-icons self-background target" role="presentation">info</i>Help</a>
    </nav>
</div>
