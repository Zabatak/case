<div style="display:none;">
    <?php echo Kohana::lang('ui_main.title'); ?>
    <?php echo Kohana::lang('ui_main.location'); ?>
    <?php echo Kohana::lang('ui_main.date'); ?>
    <?php echo Kohana::lang('ui_main.category'); ?>

    <a class="more" href="<?php echo url::site() . 'reports/' ?>">
        <?php echo Kohana::lang('ui_main.view_more'); ?></a>
</div>

<?php print form::open(NULL, array('enctype' => 'multipart/form-data', 'id' => 'caseFormOpen', 'name' => 'caseFormOpen')); ?>

<input type="hidden" name="save" id="save" value="">
<!-- report-form -->
<div class="report_row">
    <?php
    if ($form_error) {
        ?>
        <!-- red-box -->
        <div class="red-box">
            <h3><?php echo Kohana::lang('ui_main.error'); ?></h3>
            <ul>
                <?php
                foreach ($errors as $error_item => $error_description) {
                    print (!$error_description) ? '' : "<li>" . $error_description . "</li>";
                }
                ?>
            </ul>
        </div>
        <?php
    }

    if ($form_saved) {
        ?>
        <!-- green-box -->
        <div class="green-box">
            <h3><?php echo Kohana::lang('ui_main.report_saved'); ?></h3>
        </div>
        <?php
    }
    ?>
       <div class="report_row">

                <h4>Case Title :<span></span></h4>

       </div>
        
        <div class="report_row">
          
                <?php print form::label('title', $form['title'], ' class="text title"'); ?>
        </div>


       <div class="report_row">
                <h4>Case Description :<span></span></h4>

        </div>
        <div class="report_row">
                <?php print form::label('Description', $form['description'], ' class="text title"'); ?>

         </div>
        <div class="report_row">
            <h5>Comments linked to that case = <?php print count($comments); ?></h5> </td>
         </div>
        <div class="report_row">
           
                <table class="table" style="width:80px; height: 50px">
                    <thead>
                        <tr>

                            <th>Email</th>
                            <th>Date </th>
                        </tr>
                        <tr>
                            <th>Comment</th>
                        </tr>

                    </thead>
                    <?php
                    foreach ($comments as $comment) {

                        $role_style = "style=\"background:#eee; color:#888;\"";
                        echo "<tr>";
                        echo "<td align=left>";
                        echo"Date :" . $comment->comment_date;
                        echo "&nbsp;&nbsp;&nbsp;";
                        echo "</td>";
                        echo "<td>";
                        echo" Email" . $comment->comment_email;
                        echo "&nbsp;&nbsp;&nbsp;";
                        echo "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<td colspan=2 align=center>";
                        echo "" . $comment->comment;
                        echo "&nbsp;&nbsp;&nbsp;";

                        echo "</td>";
                        echo "</tr>";
                        
                        echo "<tr>";
                        echo "<td align=right>";
                        echo "" . "Rating";
                        echo "&nbsp;&nbsp;&nbsp;";

                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
        </div>


    <br/>
</div>

<hr/>
<div class="row">
    <h6>comment</h6>
    <?php print form::input('comment', $form['comment'], ' class="text title"'); ?>
</div>

<div class="row">
    <h6>Author Mail</h6>
    <?php print form::input('email', $form['email'], ' class="text title"'); ?>
</div>

<div class="report_row">
    <input name="submit" type="submit" value="<?php echo Kohana::lang('ui_main.reports_btn_submit'); ?>" class="btn_submit" /> 
</div>

<?php print form::close(); ?>                 
<?php
if ($id) {
    // Hidden Form to Perform the Delete function
    print form::open(url::site() . 'admin/case_settings', array('id' => 'reportMain', 'name' => 'reportMain'));
    $array = array('action' => 'd', 'group_id[]' => $id);
    print form::hidden($array);
    print form::close();
}
?>