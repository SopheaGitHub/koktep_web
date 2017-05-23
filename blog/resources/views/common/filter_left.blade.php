<?php
    $route_name = \Route::getCurrentRoute()->getPath();
?>
<div class="" style="padding: 10px; background: #fff;">

    <div class="table-responsive">
        <table class="table">
        <thead>
            <tr>
                <th style="margin:0px; padding:0px 0px 10px 0px;"><h4><i class="fa fa-btn fa-search"></i>Search ...</h4></th>
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
            <td>BROWSE</td>
            <td>
                <select class="form-control">
                    <option>Feature</option>
                    <option>Most Viewed</option>
                    <option>Most Discussed</option>
                    <option>Most Like</option>
                    <option>Most Unlike</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>TIME</td>
            <td>
                <select class="form-control">
                    <option>Recent</option>
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
                <?php
                    $array_alpha = [
                        'A',
                        'B',
                        'C',
                        'D',
                        'E',
                        'F',
                        'G',
                        'H',
                        'I',
                        'J',
                        'K',
                        'L',
                        'M',
                        'N',
                        'O',
                        'P',
                        'Q',
                        'R',
                        'S',
                        'T',
                        'U',
                        'V',
                        'W',
                        'X',
                        'Y',
                        'Z'
                    ];
                ?>
                <select class="form-control">
                    <option>All Alpha</option>
                    <?php
                        foreach ($array_alpha as $alpha) {
                            echo '<option>'.$alpha.'</option>';
                        }
                    ?>
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