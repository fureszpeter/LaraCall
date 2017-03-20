@extends('god.layouts.default')
{{-- Content --}}
@section('main')
    <div class="page-header" id="app">
        <div id="app" class="ui vertical stripe segment">
            <div class="ui container">
                <div id="content" class="ui basic segment">
                    <h3 class="ui header">List of Users</h3>
                    <vuetable
                            api-url="http://example.app:8000/api/users"
                            table-wrapper="#content"
                            :fields="columns"
                            :item-actions="itemActions"
                    ></vuetable>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        new Vue({
            el: '#app',
            data: {
                columns: [
                    'name',
                    'nickname',
                    'email',
                    'birthdate',
                    'gender',
                    '__actions'
                ],
                itemActions: [
                    {name: 'view-item', label: '', icon: 'zoom icon', class: 'ui teal button'},
                    {name: 'edit-item', label: '', icon: 'edit icon', class: 'ui orange button'},
                    {name: 'delete-item', label: '', icon: 'delete icon', class: 'ui red button'}
                ]
            },
            methods: {
                viewProfile: function (id) {
                    console.log('view profile with id:', id)
                }
            },
            events: {
                'vuetable:action': function (action, data) {
                    console.log('vuetable:action', action, data)
                    if (action == 'view-item') {
                        this.viewProfile(data.id)
                    }
                },
                'vuetable:load-error': function (response) {
                    console.log('Load Error: ', response)
                }
            }
        })
    </script>
@endsection
