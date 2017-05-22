<?php
    $route_name = \Route::getCurrentRoute()->getPath();
?>
<div class="" style="padding: 10px; background: #fff;">

    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th style="margin:0px; padding:0px 0px 10px 0px;"><h4><i class="fa fa-btn fa-search"></i> Search ...</h4></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <input type="text" class="form-control" placeholder="Search ...">
                </td>
            </tr>
        </tbody>
        
    </table>
    </div>

    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th colspan="2" style="margin:0px; padding:0px 0px 10px 0px;"><h4><i class="fa fa-btn fa-search-plus"></i>Filter Options</h4></th>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td width="20%">VIEW</td>
            <td>
                <select class="form-control">
                    <option>Posted</option>
                    <option>People</option>
                    <option>Teams</option>
                    <option>Collection</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>POPULAR</td>
            <td>
                <select class="form-control">
                    <option>All Category</option>
                    <option>Art</option>
                    <option>Graphic Design</option>
                    <option>Architectural</option>
                    <option>Photography</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>BROWSE</td>
            <td>
                <select class="form-control">
                    <option>Featured</option>
                    <option>Most Viewed</option>
                    <option>Most Discussed</option>
                    <option>Most Recent</option>
                    <option>Most Like</option>
                    <option>Most Unlike</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>TIME</td>
            <td>
                <select class="form-control">
                    <option>All Time</option>
                    <option>Today</option>
                    <option>This Week</option>
                    <option>This Month</option>
                    <option>This Year</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>ALPHA</td>
            <td>
                <select class="form-control">
                    <option>All Alpha</option>
                    <option>A</option>
                    <option>B</option>
                    <option>C</option>
                    <option>D</option>
                    <option>E</option>
                    <option>F</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                LOCATION
                <select class="form-control">
                    <option>Country</option>
                </select>
                <select class="form-control">
                    <option>City</option>
                </select>
            </td>
        </tr>
        </tbody>
        
    </table>
    </div>
    
    
</div>