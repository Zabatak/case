<div class="content-blocks clearingfix" style="v-align:center">

    <ul class="content-column" >

        <li class="block-reports">
            <div id="content-block" style="width: 900px">
                <h5 class="right">الحالات المفــــــــتوحة</h5>
                <br/>
                <br/>
                <br/>
                <!-- start comments block -->
                <div class="content-bg" style="padding-left: 30px">


                    <?php
                    foreach ($cases as $case) {
                        $case_id = $case->id;
                        $case_title = $case->title;
                        $case_desc = $case->description;
                        $case_date = $case->entry_date;

                        if ($case->id != 1) {

                            print"<div class=rb_report> ";
                            //<!-- start details block -->
                            print"<div class=r_details>";
                            print"<h3>" . $case_title;
                            print "<a href=\"" . url::site() . "case/openCase/" . $case_id . "\" class=r_comments >";

                            //Get incident IDs which linked to that case
                            $comments = ORM::factory('case_comments')
                                    ->select('*')
                                    ->where(array('cases_case_id' => $case_id))
                                    ->find_all();
                            print count($comments);
                            print"</a>";
                            print"</h3>";

                            print"<p class=r_date r-3 bottom-cap> Date [ " . $case_date . " ] </p>";
                            print"<br />";
                            print"<div class=r_description>" . $case_desc . "</div>";
                            print"</div>";
                            print"</div>";
                        }
                    }
                    ?>


                </div>
            </div>

            <br />
            </div>
            </div>
        </li>
    </ul>    

</div>

