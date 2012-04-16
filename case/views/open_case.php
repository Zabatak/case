<?php print form::open(NULL, array('enctype' => 'multipart/form-data', 'id' => 'caseFormOpen', 'name' => 'caseFormOpen')); ?>

<input type="hidden" name="save" id="save" value="">

<!-- Case  form  confirmation message   -->
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
</div>

<div id="main" class="report_detail">
    <div class="left-col"> 
        <p class="r_verified"><? print $form['contact_person']; ?></p>
        <h1 class="report-title"><? print $form['title']; ?></h1>


        <div class="report-category-list">
            <p>


                <?
                print "<a href=\"" . url::site() . "case" . "\" >";
                print"العودة للحالات";
                print"</a>";
                ?> 


            </p>
        </div>
        <p class="report-when-where">
            <span class="r_date"><? print $form['date']; ?></span>
            <span class="r_location">location</span>

        </p>
        <!-- start report description -->
        <div class="report-description-text">
            <h5>وصف</h5>
            <?php print $form['description']; ?>
            <br>
            <!-- start additional fields -->
            <div class="credibility">
                <h5>معلومات اضافية</h5>
                <div class="report-custom-forms-text">
                    <table>
                        <tbody>
                            <tr>
                                <td><strong>عدد التعليقـــات: </strong></td>
                                <td class="answer"><?php print count($comments); ?></td></tr>
                            <tr><td><strong>الحــــــالــــــة: </strong></td>
                                <td class="answer">مفـتوح</td></tr><tr></tr></tbody></table>
                </div>
                <br>
            </div>

           
            <!-- end additional fields -->
            <div class="credibility">
                <table class="rating-table" cellspacing="0" cellpadding="0" border="0">
                    <tbody><tr>
                            <td>المصداقية:</td>
                            <td><a href="javascript:rating('2344','add','original','oloader_2344')"><img id="oup_2344" src="http://zabatak.com/media/img/up.png" alt="UP" title="UP" border="0"></a></td>
                            <td><a href="javascript:rating('2344','subtract','original')"><img id="odown_2344" src="http://zabatak.com/media/img/down.png" alt="DOWN" title="DOWN" border="0"></a></td>
                            <td><a href="" class="rating_value" id="orating_2344">0</a></td>
                            <td><a href="" id="oloader_2344" class="rating_loading"></a></td>
                        </tr>
                    </tbody></table>
            </div>


            <div class="content">

                <table class="rating-table" cellspacing="0" cellpadding="0" border="1" style="width: 450px;
                       ">

                    <?php
                    foreach ($comments as $comment) {


                        //<!-- start details Table -->
                        print" <tr>";
                        print"    <td align=left>";
                        print"       Date [ " . $comment->comment_date . " ]";
                        print"    </td>";
                        print"    <td>" . $comment->comment_email . "</td>";

                        print"</tr>";

                        print" <tr>";
                        print"     <td colspan=2 align=center>";
                        print"         <p>" . $comment->comment . "</p>";
                        print"     </td>";
                        print"  </tr>";
                    }
                    ?>
                </table>

            </div>
        </div>

        <div class="row">
            <h5>البريد الالكترونى</h5>
            <?php print form::input('email', $form['email'], ' class="text title"'); ?>
        </div>

        <div class="row">
            <h5>التــعليق :</h5>
            <?php print form::textArea('comment', $form['comment'], ' rows="3" cols="40" class="textarea long" '); ?>
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
    </div>
</div>




