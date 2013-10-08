<?php

Asse::addJs('jquery.flot.js', Yii::getPathOfAlias('webroot.web.flot'));
Asse::addJs('jquery.flot.navigate.js', Yii::getPathOfAlias('webroot.web.flot'));
Asse::addJs('jquery.flot.symbol.js', Yii::getPathOfAlias('webroot.web.flot'));


?>

<script type="text/javascript">

    var profilePointsInfo = <?php echo json_encode($result) ?>;

    $(function () {

        var profilePoints = [
            <?php
                foreach($result as $res){
                    if(!empty($res['profiles'])){
                        $point = new LocationPoint($res['scale_cxy']);
                        echo "[{$point->cx},{$point->cy}],";
                    }
                }
            ?>
        ];


        var spiritsPoints = [
            <?php
                foreach($result as $res){
                    if(!empty($res['spirits'])){
                        $point = new LocationPoint($res['scale_cxy']);
                        echo "[{$point->cx},{$point->cy}],";
                    }
                }
            ?>
        ];

        var data = [
            {
                "data": profilePoints,
                "color": '#c99b12',
                points: { symbol: "square"}
            },
            {
                "data": spiritsPoints,
                "color": '#069b08',
                points: { symbol: "cross"}
            }
        ];
        var placeholder = $("#plot");

        var plot = $.plot(placeholder, data, {
            series: {
                points: { show: true, radius: 5},
                lines: { show: false, fill: false },
                shadowSize: 0
            },
            grid: {
                hoverable: true,
                clickable: true
            },
            xaxis: {
                position: "top",
                zoomRange: [1, 10000000],
                panRange: [0, 10000000]
            },
            yaxis: {
                zoomRange: [1, 10000000],
                panRange: [-10000000, 0]
            },
            zoom: {
                interactive: true
            },
            pan: {
                interactive: true
            }
        });

        function showTooltip(x, y, contents) {

            $("<div id='tooltip'>" + contents + "</div>").css({
                position: "absolute",
                display: "none",
                top: y + 5,
                left: x + 5,
                border: "1px solid #fdd",
                padding: "2px",
                "background-color": "#fee",
                opacity: 0.80
            }).appendTo("body").fadeIn(200);
        }

        var previousPoint = null;
        $("#plot").bind("plothover", function (event, pos, item) {


                if (item) {
                    if (previousPoint != item.dataIndex) {

                        previousPoint = item.dataIndex;

                        $("#tooltip").remove();
                        var x = item.datapoint[0],
                            y = item.datapoint[1];



                        showTooltip(item.pageX, item.pageY,
                            x + ":" + y+ "<br/>" +
//                        "spirits points: " + profilePointsInfo[""+x+":"+y]['spirits'].length + "<br/>" +
//                        "profiles points: " + profilePointsInfo[""+x+":"+y]['profiles'].length + "<br/>" +
//                        "real_cxyxy: " + profilePointsInfo[""+x+":"+y]['real_cxyxy'] + "<br/>" +
                            ""
                        );
                    }
                } else {
                    $("#tooltip").remove();
                    previousPoint = null;
                }

        });
    });

</script>
<div id="plot" style="width: 800px; height: 800px;"></div>
<div id="plotpan"></div>