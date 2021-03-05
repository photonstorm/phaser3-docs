<div class="aside w-100 pt-4 ps-3 scrollspy_aside">
    <div class="content ms-5">
        <h5>Filter</h5>
        <div class="mb-3 form-group">
            <div class="me-3">
                <label class="align-middle" for="hide_inherited">Hide inherited members:</label>
                <input type="checkbox" id="hide_inherited" autofill="off" autocomplete="off"/>
            </div>
            <div class="me-3">
                <label class="align-middle" for="show_private_members">show private members:</label>
                <input type="checkbox" id="show_private_members" autofill="off" autocomplete="off"/>
            </div>
        </div>

        <div id="react-aside-search-list" data-list="{{ json_encode($aside_collection) }}"></div>
    </div>
</div>
