<div class="row">
    <div class="col-sm-12">
        <form method="get" action="">
            <div class="form-group row">
                <div class="col-sm-11">
                    <input id="search"
                           type="text"
                           class="form-control"
                           name="search"
                           placeholder="Search"
                           value="@if(isset($search_term)){{ $search_term }}@endif">
                </div>

                <div class="col-sm-1">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>