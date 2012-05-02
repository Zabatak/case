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


            <!-- end credibility fields -->
            <div class="content">

                <table id="table-comment">
                    <thead>
                        <tr>
                            <th>التاريخ </th>
                            <th>البريد </th>
                        </tr>


                    </thead>
                    <tbody> 
                        <?php
                        foreach ($comments as $comment) {

                            //<!-- start details Table -->
                            print"<tr>";
                            print"<td><p class=date>";
                            print $comment->comment_date;
                            print"</p></td>";

                            print"<td>" . $comment->comment_email . "</td>";

                            print"</tr>";
                            print"<tr>";
                            print"<td colspan=2 >";
                            print $comment->comment;
                            print"</td>";
                            print"</tr>";

                            print"<tr>";

                            print"<td>";
                            print"Rate This :" ;
                            print "<a href=\"" . url::site() . "case/rating2/" . $case_id . '/' . $comment->id . '/' . 'add' . "\" class=r_comments >";
                            print"<img id=oup_" . $case_id . " src=" . url::file_loc('img') . "media/img/up.png" . " alt=UP title=UP border=0 />";
                            print"</a>";
                            print "<a href=\"" . url::site() . "case/rating2/" . $case_id . '/' . $comment->id . '/' . 'sub' . "\" class=r_comments >";
                            print"<img id=oup_" . $case_id . " src=" . url::file_loc('img') . "media/img/down.png" . " alt=DOWN title=DOWN border=0 />";
                            print"</a>";
                            print"</td>";

                            print"<td>";
                            print"Total :" . $comment->rating;
                            print"</td>";
                            print"</tr>";
                        }
                        ?>

                    </tbody>
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




