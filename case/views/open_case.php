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
            <!-- credibility fields -->
            <div class="credibility">
                <table class="rating-table" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td><?php echo Kohana::lang('ui_main.credibility'); ?>:</td>
                        <td><a href="javascript:rating('<?php echo $case_id; ?>','add','original','oloader_<?php echo $case_id; ?>')">
                                <img id="oup_<?php echo $case_id; ?>" src="<?php echo url::file_loc('img'); ?>media/img/up.png" alt="UP" title="UP" border="0" /></a></td>
                        <td><a href="javascript:rating('<?php echo $case_id; ?>','subtract','original')">
                                <img id="odown_<?php echo $case_id; ?>" src="<?php echo url::file_loc('img'); ?>media/img/down.png" alt="DOWN" title="DOWN" border="0" /></a></td>
                        <td><a href="" class="rating_value" id="orating_<?php echo $case_id; ?>"><?php echo $rating; ?></a></td>
                        <td><a href="" id="oloader_<?php echo $case_id; ?>" class="rating_loading" ></a></td>
                    </tr>
                </table>
            </div>

            <!-- end credibility fields -->
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

    </div>
</div>




