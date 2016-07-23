<?php 
function graphSurvey($form_id, $numQuestions)
{
        $array = array();
        $current_user = wp_get_current_user();
        $username = $current_user->user_login;
        $search_criteria['field_filters'][] = array(
                'key' => 'created_by',
                'value' => $current_user->ID
        );
        $search_criteria2['field_filters'][] = array(
                'key' => 'content',
                'value' => '1'
        );
        $form = GFAPI::get_form($form_id, $search_criteria2);
        $entries = GFAPI::get_entries($form_id, $search_criteria);
//  var_dump($form);
//      echo '</br>count: ' . $count;
//      echo '</br>' . $username . '</br>';
        if ($entries == TRUE) {
                $search_criteria['field_filters'][] = array(
                        'key' => 'created_by',
                        'value' => $current_user->ID
                );
                $user_score = GFAPI::get_entries($form_id, $search_criteria);
                $entries = GFAPI::get_entries($form_id, array() , null, array(
                        'offset' => 0,
                        'page_size' => 99999
                ));
                $countEntries = count($entries);
                // var_dump($entries);
                $full_user_score = ($user_score[0] {
                        "gsurvey_score"
                }) / $numQuestions;
                $full_user_score = roundToNearestFraction($full_user_score, 1 / 5);
//            echo '</br>' . $full_user_score;
//            echo '</br>submissions: n=' . $countEntries;
        echo '<div style="font-size: 2em; font-weight: bold;">FormID: ' .$form_id. '</div>';
                for ($i = 0; $i < $countEntries; $i++) {
                        echo '</br>iteration: <strong>' . $i . '</strong>';
                        echo '</br>raw entry score: ' . $entries[$i] {
                                "gsurvey_score"
                        };
                        $g_survey_score = (($entries[$i] {
                                "gsurvey_score"
                        } / $numQuestions));
                        echo '</br>gsurvey_score= ' . (($entries[$i] {
                                "gsurvey_score"
                        } / $numQuestions));
                        array_push($array, $g_survey_score);
                        $avgScore = (array_sum($array) / count($array));
                        echo '</br> array avg: ' . $avgScore . '</br>';
                        echo '</br>rounded g_survey_score= ' . roundToNearestFraction(($entries[$i] {
                                "gsurvey_score"
                        } / $numQuestions) , 1 / 5);
                }
        }
        else {
                echo do_shortcode('[gravityform id="' . $form_id . '" title=false description=true]'); //if no entries exist for the user,  display form
        }
        echo '
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
   <div id="container" style="width: 75%;">
        <canvas id="' . $form_id . '"></canvas>
    </div>
    <script>
        var userScore = ' . $full_user_score . ';
        var allScore = ' . $avgScore . ';
        var formID = ' . $form_id . ';
        document.write(allScore);
        document.write("</br>");
        document.write(userScore);
                var barChartData = {
                    labels: ["1"],
                    datasets: [{
                        label: "Your Score",
                        backgroundColor: "rgba(220,220,220,0.5)",
                        data: [userScore]
                    }, {
                        label: "Average Score",
                        backgroundColor: "rgba(151,187,205,0.5)",
                        data: [allScore]
                    }]
                };
                window.onload = function() {
                    var ctx = document.getElementById(' . $form_id . ').getContext("2d");
                    window.myBar = new Chart(ctx, {
                        type: "bar",
                        data: barChartData,
                        options: {
                        scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        suggestedMax: 5,
                        beginAtZero: true   // minimum value will be 0.
                    }
                }]
            },
                            // Elements options apply to all of the options unless overridden in a dataset
                            // In this case, we are setting the border of each bar to be 2px wide and green
                            elements: {
                                rectangle: {
                                    borderWidth: 2,
                                    borderColor: "rgb(0, 255, 0)",
                                    borderSkipped: "bottom"
                                }
                            },
                            responsive: true,
                            legend: {
                                position: "top",
                            },
                            title: {
                                display: true,
                                text: "Chart.js Bar Chart"
                            }
                        }
                    });
                };
    </script>';
};

?>