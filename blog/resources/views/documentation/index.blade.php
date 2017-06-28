@extends('layouts.app')

@section('stylesheet')
<style type="text/css">
#tree3 {
    margin: 0px;
    padding: 0px 10px;
}
#tree3 ul {
    list-style: none;
    padding: 0;
}
#tree3 li {
    padding-left: 1.3em;
    list-style: none;
}
#tree3 li.active > a{
    color: #0F97B7;
}
#tree3 li:before {
    content: "\f105"; /* FontAwesome Unicode */
    font-family: FontAwesome;
    color: #27C3ED;
    display: inline-block;
    margin-left: -1.3em; /* same as padding-left set on li */
    width: 1.3em; /* same as padding-left set on li */
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
                        <h4><i class="fa fa-btn fa-file"></i>Documentation</h4>
                        <hr />
                        <div class="row">
                            <div class="col-sm-12">
                                <ul id="tree3">

                                    <?php
                                        if(count($all_documentation) > 0) {
                                            foreach ($all_documentation as $documentation) { ?>

                                                <?php
                                                    $all_documentation1 = $objDocumentation->getAllDocumentationByLanguage(['sort'=>'sort_order', 'order'=>'asc', 'parent_id'=>$documentation->documentation_id, 'language_id'=>$language->language_id])->get();

                                                    if(count($all_documentation1) > 0) { ?>

                                                        <li <?php echo (($data->doc_id==$documentation->documentation_id)? 'class="active"':''); ?> ><a href="<?php echo $data->action_documentation.'?doc_id='.$documentation->documentation_id; ?>"><?php echo $documentation->name; ?></a>

                                                            <ul>
                                                                <?php
                                                                foreach ($all_documentation1 as $documentation1) { ?>
                                                                    
                                                                    <?php
                                                                        $all_documentation2 = $objDocumentation->getAllDocumentationByLanguage(['sort'=>'sort_order', 'order'=>'asc', 'parent_id'=>$documentation1->documentation_id, 'language_id'=>$language->language_id])->get();

                                                                        if(count($all_documentation2) > 0) { ?>

                                                                            <li <?php echo (($data->doc_id==$documentation1->documentation_id)? 'class="active"':''); ?>><a href="<?php echo $data->action_documentation.'?doc_id='.$documentation1->documentation_id; ?>"><?php echo $documentation1->name; ?></a>

                                                                                <ul>
                                                                                    <?php
                                                                                    foreach ($all_documentation2 as $documentation2) { ?>
                                                                                        
                                                                                        <?php
                                                                                            $all_documentation3 = $objDocumentation->getAllDocumentationByLanguage(['sort'=>'sort_order', 'order'=>'asc', 'parent_id'=>$documentation2->documentation_id, 'language_id'=>$language->language_id])->get();

                                                                                            if(count($all_documentation3) > 0) { ?>

                                                                                                <li <?php echo (($data->doc_id==$documentation2->documentation_id)? 'class="active"':''); ?>><a href="<?php echo $data->action_documentation.'?doc_id='.$documentation2->documentation_id; ?>"><?php echo $documentation2->name; ?></a>

                                                                                                    <ul>
                                                                                                        <?php
                                                                                                        foreach ($all_documentation3 as $documentation3) { ?>
                                                                                                            <!-- sub menu level 3 -->
                                                                                                        <?php   } ?>

                                                                                                    </ul>

                                                                                                </li>                                                       
                                                                                                
                                                                                        <?php } else { ?>
                                                                                            <li <?php echo (($data->doc_id==$documentation2->documentation_id)? 'class="active"':''); ?>><a href="<?php echo $data->action_documentation.'?doc_id='.$documentation2->documentation_id; ?>"><?php echo $documentation2->name; ?></a></li>
                                                                                        <?php } ?>

                                                                                    <?php   } ?>

                                                                                </ul>

                                                                            </li>                                                       
                                                                            
                                                                    <?php } else { ?>
                                                                        <li <?php echo (($data->doc_id==$documentation1->documentation_id)? 'class="active"':''); ?>><a href="<?php echo $data->action_documentation.'?doc_id='.$documentation1->documentation_id; ?>"><?php echo $documentation1->name; ?></a></li>
                                                                    <?php } ?>

                                                                <?php   } ?>

                                                            </ul>

                                                        </li>                                                       
                                                        
                                                <?php } else { ?>
                                                    <li <?php echo (($data->doc_id==$documentation->documentation_id)? 'class="active"':''); ?>><a href="<?php echo $data->action_documentation.'?doc_id='.$documentation->documentation_id; ?>"><?php echo $documentation->name; ?></a></li>
                                                <?php } ?>

                                        <?php   }
                                        }
                                    ?>

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
$(document).ready(function() {
    loadingList("<?php echo $data->action_list; ?>");
});
</script>
@endsection