@extends('layouts.app')

@section('pageTitle', 'Create Post')

@section('content')
<div id="table-loading_init" style="height:60px;width:60px" class="mdl-spinner mdl-js-spinner is-active"></div>
        
        <div id="table-content" style="display:none;margin-top:20px;">

            <div style="display:flex;flex-direction:row;align-items:center;justify-content:space-between;width:100%;box-sizing:border-box">

            </div> 

            <form style="display:none;" id="table-delete" method="post" action="">

                
                <input type="hidden" name="type" value="">
                <table id="table" class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
                    <thead>
                        <tr>
                                <th>
                                    <label id ="checkall" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-0">
                                        <input type="checkbox" id="checkbox-0" class="mdl-checkbox__input">
                                    </label>
                            




                            <!-- Table Headers -->
                            <th>Username</th>
                            <th>Email</th>
                            <th>Guid</th>
                            <th>Bank</th>
                            <th>Cash</th>
                            <th>Joined</th>
                            <!-- Table Headers -->





                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                    <td>
                                        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect check" for="checkbox-">
                                            <input type="checkbox" name="checkbox[]" value="" id="checkbox-" class="mdl-checkbox__input">
                                        </label>
                                    </td>




                                <!-- Table Data -->
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <!-- Table Data -->




                                <td class="options">
                                    <a id="" class="mdl-button mdl-js-button mdl-button--icon">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                
                                    <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="">
                                            <li><a style="display:block;padding:5px 10px" class="mdl-navigation__link" href="?mode=edit&id="><i class="material-icons">edit</i> Edit</a></li>
                                    </ul>
                                    <div class="mdl-tooltip" for="">
                                        Options
                                    </div>
                                </td>
                            </tr>
                    </tbody>
                </table>

                <button id="table-delete_btn" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color-text--white">Delete Selected</button>

            </form>

        </div>
        <!-- For when table is loading -->
        <div id="table-loading" style="height:60px;width:60px;display:none" class="mdl-spinner mdl-js-spinner is-active"></div>

    <script>
        $(document).ready(function() {
            setTimeout(
                function() 
                {
                    $('#table-loading_init').hide();
                    $('#table-content').show();
                    $('#table-delete').show();
                }, 100);
        });
    </script>
    @endsection