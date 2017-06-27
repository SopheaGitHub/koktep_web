@extends('layouts.app')

@section('stylesheet')
<style type="text/css">
.tree, .tree ul {
    margin:0;
    padding:0;
    list-style:none
}
.tree ul {
    margin-left:1em;
    position:relative
}
.tree ul ul {
    margin-left:.5em
}
.tree ul:before {
    content:"";
    display:block;
    width:0;
    position:absolute;
    top:0;
    bottom:0;
    left:0;
    border-left:1px solid
}
.tree li {
    margin:0;
    padding:0 1em;
    line-height:2em;
    color:#27C3ED;
    /*font-weight:700;*/
    position:relative;
    cursor: pointer;
}
.tree ul li:before {
    content:"";
    display:block;
    width:10px;
    height:0;
    border-top:1px solid;
    margin-top:-1px;
    position:absolute;
    top:1em;
    left:0
}
.tree ul li:last-child:before {
    background:#fff;
    height:auto;
    top:1em;
    bottom:0
}
.indicator {
    margin-right:5px;
}
.tree li a {
    text-decoration: none;
    /*color:#369;*/
}
.tree li button, .tree li button:active, .tree li button:focus {
    text-decoration: none;
    /*color:#369;*/
    border:none;
    background:transparent;
    margin:0px 0px 0px 0px;
    padding:0px 0px 0px 0px;
    outline: 0;
}
</style>
@endsection

@section('content')
<?php
    $objLanguage = new App\Models\Language();
    $objDocumentation = new App\Models\Documentation();

    if(\Session::has('locale')) {
        $locale = \Session::get('locale');
    }else {
        $locale = 'en';
    }

    $language = $objLanguage->getLanguageByCode( $locale );
    $all_documentation = [];
    $all_documentation1 = [];
    $all_documentation2 = [];
    $all_documentation3 = [];
    if($language) {
        $all_documentation = $objDocumentation->getAllDocumentationByLanguage(['sort'=>'sort_order', 'order'=>'asc', 'parent_id'=>'0', 'language_id'=>$language->language_id])->get();
    }
?>
<div class="container">
    <div class="row profile">
        <div class="col-md-12">
            <!-- HTML to write -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <ul id="tree3">

                                    <?php
                                        if(count($all_documentation) > 0) {
                                            foreach ($all_documentation as $documentation) { ?>

                                                <?php
                                                    $all_documentation1 = $objDocumentation->getAllDocumentationByLanguage(['sort'=>'sort_order', 'order'=>'asc', 'parent_id'=>$documentation->documentation_id, 'language_id'=>$language->language_id])->get();

                                                    if(count($all_documentation1) > 0) { ?>

                                                        <li><a href="#"><?php echo $documentation->name; ?></a>

                                                            <ul>
                                                                <?php
                                                                foreach ($all_documentation1 as $documentation1) { ?>
                                                                    
                                                                    <?php
                                                                        $all_documentation2 = $objDocumentation->getAllDocumentationByLanguage(['sort'=>'sort_order', 'order'=>'asc', 'parent_id'=>$documentation1->documentation_id, 'language_id'=>$language->language_id])->get();

                                                                        if(count($all_documentation2) > 0) { ?>

                                                                            <li><a href="#"><?php echo $documentation1->name; ?></a>

                                                                                <ul>
                                                                                    <?php
                                                                                    foreach ($all_documentation2 as $documentation2) { ?>
                                                                                        
                                                                                        <?php
                                                                                            $all_documentation3 = $objDocumentation->getAllDocumentationByLanguage(['sort'=>'sort_order', 'order'=>'asc', 'parent_id'=>$documentation2->documentation_id, 'language_id'=>$language->language_id])->get();

                                                                                            if(count($all_documentation3) > 0) { ?>

                                                                                                <li><a href="#"><?php echo $documentation2->name; ?></a>

                                                                                                    <ul>
                                                                                                        <?php
                                                                                                        foreach ($all_documentation3 as $documentation3) { ?>
                                                                                                            <!-- sub menu level 3 -->
                                                                                                        <?php   } ?>

                                                                                                    </ul>

                                                                                                </li>                                                       
                                                                                                
                                                                                        <?php } else { ?>
                                                                                            <li><a href="#" class="getdocumentation" data-id="<?php echo $documentation2->documentation_id; ?>"><i class="fa fa-btn fa-minus-square-o"></i><?php echo $documentation2->name; ?></a></li>
                                                                                        <?php } ?>

                                                                                    <?php   } ?>

                                                                                </ul>

                                                                            </li>                                                       
                                                                            
                                                                    <?php } else { ?>
                                                                        <li><a href="#" class="getdocumentation" data-id="<?php echo $documentation1->documentation_id; ?>"><i class="fa fa-btn fa-minus-square-o"></i><?php echo $documentation1->name; ?></a></li>
                                                                    <?php } ?>

                                                                <?php   } ?>

                                                            </ul>

                                                        </li>                                                       
                                                        
                                                <?php } else { ?>
                                                    <li><a href="#" class="getdocumentation" data-id="<?php echo $documentation->documentation_id; ?>"><i class="fa fa-btn fa-minus-square-o"></i><?php echo $documentation->name; ?></a></li>
                                                <?php } ?>

                                        <?php   }
                                        }
                                    ?>

                                    <!-- <li><a href="#">Header</a>

                                        <ul>
                                            <li>Company Maintenance</li>
                                            <li><a href="#">Employees</a>
                                                <ul>
                                                    <li>Reports
                                                        <ul>
                                                            <li><a href="#">Report1</a></li>
                                                            <li>Report2</li>
                                                            <li>Report3</li>
                                                        </ul>
                                                    </li>
                                                    <li>Employee Maint.</li>
                                                </ul>
                                            </li>
                                            <li>Human Resources</li>
                                        </ul>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div id="display-list">
                
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
$.fn.extend({
    treed: function (o) {
      
      var openedClass = 'fa fa-btn fa-minus-square-o';
      var closedClass = 'fa fa-btn fa-plus-square-o';
      
      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };
      
        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

//Initialization of treeviews

$('#tree3').treed({openedClass:'fa fa-btn fa-plus-square-o', closedClass:'fa fa-btn fa-plus-square-o'});

</script>
<script type="text/javascript">
$(document).ready(function() {
    loadingList("<?php echo $data->action_list; ?>");

    $(document).on('click', '.getdocumentation', function() {
        var documentation_id = $(this).data("id");
        loadingList("<?php echo $data->action_list.'?documentation_id='; ?>"+documentation_id);
        return false;
    });

});
</script>
@endsection