<?php
/*
Template Name: Statisctics
 */
get_header();

$args = array(
    'post_type' => 'cheltuieli',
    'posts_per_page' => -1,
    'order' => 'ASC'
);
$query = new WP_Query( $args );
//echo '<pre>';
//print_r($query);
//echo '</pre>';
echo "<ul>";
while($query->have_posts()){
    $query->the_post();
//echo "<li>".get_the_ID()."</li>";
    $date = get_post_field('wpcf-data-cheltuielii', $post->ID);
//    echo $date."<br>";
}
echo "</ul>";

$values = array(
    array("Value" => 205, "Tip" => "Ianuarie"),
    array("Value" => 1549, "Tip" => "Februarie"),
    array("Value" => 3328, "Tip" => "Martie"),
    array("Value" => 735, "Tip" => "Aprelie"),
    array("Value" => 8432, "Tip" => "Mai"),
    array("Value" => 624, "Tip" => "Iunie"),
    array("Value" => 2435, "Tip" => "Iulie"),
    array("Value" => 3964, "Tip" => "August"),
    array("Value" => 98, "Tip" => "Septembrie"),
    array("Value" => 999, "Tip" => "Octombrie"),
    array("Value" => 768, "Tip" => "Noiembrie"),
    array("Value" => 868, "Tip" => "Decembrie"),
);

$values2 = array("hello", "world", "yayay");

//echo "<pre>";
//var_dump($values);
//echo "</pre>";

?>
<script>
    $(document).ready(function(){

        var values = <?php echo json_encode($values);?>;
//        var object = JSON.parse(values);
//        console.log(values[2]);

        var graph = document.getElementById("graph");
        var ctx = graph.getContext("2d");
        var tipCanvas = document.getElementById("tip");
        var tipCtx = tipCanvas.getContext("2d");

        var canvasOffset = $("#graph").offset();
        var offsetX = canvasOffset.left;
        var offsetY = canvasOffset.top;

//        var graph;
        var xPadding = 45;
        var yPadding = 30;



	    var objects = {values:[]};
	    for (var i = 0; i < values.length; i++) {
		    objects.values.push({X:i, Y: values[i].Value, Tip:values[i].Tip});
	    }

	    data = objects;

// define tooltips for each data point
        var dots = [];
        for (var i = 0; i < data.values.length; i++) {
            dots.push({
                x: getXPixel(data.values[i].X),
                y: getYPixel(data.values[i].Y),
                r: 4,
                rXr: 16,
                color: "red",
                tip: "#text" + (i + 1)
            });
        }
//        var object = JSON.parse(values);
//        console.log();

// request mousemove events
        $("#graph").mousemove(function (e) {
            handleMouseMove(e);
        });

        tips = ["hello1", "hello2", "hello3", "hello4", "hell5", "hello6", "hello7", "hello8"];
//        console.log(values[2].Tip);

// show tooltip when mouse hovers over dot
        function handleMouseMove(e) {
            mouseX = parseInt(e.clientX - offsetX);
            mouseY = parseInt(e.clientY - offsetY);

            // Put your mousemove stuff here
            var hit = false;
            for (var i = 0; i < dots.length; i++) {
                var dot = dots[i];
                var dx = mouseX - dot.x;
                var dy = mouseY - dot.y;
                if (dx * dx + dy * dy < dot.rXr) {
                    tipCanvas.style.left = (dot.x) + "px";
                    tipCanvas.style.top = (dot.y - 40) + "px";
                    tipCtx.clearRect(0, 0, tipCanvas.width, tipCanvas.height);
                    //                  tipCtx.rect(0,0,tipCanvas.width,tipCanvas.height);
                    tipCtx.fillText(data.values[i].Tip, 5, 15);
                    hit = true;
                }
            }
            if (!hit) {
                tipCanvas.style.left = "-200px";
            }
        }


// unchanged code follows

// Returns the max Y value in our data list
        function getMaxY() {
            var max = 0;

            for (var i = 0; i < data.values.length; i++) {
                if (data.values[i].Y > max) {
                    max = data.values[i].Y;
                }
            }

            max += 10 - max % 10;
            return max;
        }

// Returns the max X value in our data list
        function getMaxX() {
            var max = 0;

            for (var i = 0; i < data.values.length; i++) {
                if (data.values[i].X > max) {
                    max = data.values[i].X;
                }
            }

            // omited
            //max += 10 - max % 10;
            return max;
        }

// Return the x pixel for a graph point
        function getXPixel(val) {
            // uses the getMaxX() function
            return ((graph.width - xPadding) / (getMaxX() + 1)) * val + (xPadding * 1.5);
            // was
            //return ((graph.width - xPadding) / getMaxX()) * val + (xPadding * 1.5);
        }

// Return the y pixel for a graph point
        function getYPixel(val) {
            return graph.height - (((graph.height - yPadding) / getMaxY()) * val) - yPadding;
        }

        graph = document.getElementById("graph");
        var finalObject = graph.getContext('2d');

        function drawGraphic(c){

            c.lineWidth = 4;
            c.strokeStyle = '#999';
            c.font = 'italic 8pt sans-serif';
            c.textAlign = "center";

// Draw the axises
            c.beginPath();
            c.moveTo(xPadding, 0);
            c.lineTo(xPadding, graph.height - yPadding);
            c.lineTo(graph.width, graph.height - yPadding);
            c.stroke();

// Draw the X value texts
            var myMaxX = getMaxX();
            for (var i = 0; i <= myMaxX; i++) {
                // uses data.values[i].X
                c.fillText(i, getXPixel(i), graph.height - yPadding + 20);
            }
            for(var i = 0; i < data.values.length; i ++) {
                // uses data.values[i].X
                c.fillText(data.values[i].X, getXPixel(data.values[i].X), graph.height - yPadding + 20);
            }


            step = getMaxY()/10;
// Draw the Y value texts
            c.textAlign = "right"
            c.textBaseline = "middle";

            for (var i = 0; i < getMaxY(); i += step) {
                roundStep = Math.round(i/10)*10;
                c.fillText(roundStep, xPadding -5, getYPixel(roundStep));
            }

            c.strokeStyle = '#f00';

// Draw the line graph
            c.beginPath();
            c.moveTo(getXPixel(data.values[0].X), getYPixel(data.values[0].Y));
            for (var i = 1; i < data.values.length; i++) {
                c.lineTo(getXPixel(data.values[i].X), getYPixel(data.values[i].Y));
            }
            c.stroke();

// Draw the dots
            c.fillStyle = '#333';

            for (var i = 0; i < data.values.length; i++) {
                c.beginPath();
                c.arc(getXPixel(data.values[i].X), getYPixel(data.values[i].Y), 5, 0, Math.PI * 2, true);
                c.fill();
            }
        }
        drawGraphic(finalObject);

    });

</script>
<div class="page left">
    <p>Hover over data-dots for tooltip</p>
    <div id="wrapper2">
        <canvas id="graph" width=600 height=300></canvas>
        <canvas id="tip" width=100 height=25></canvas>
    </div>
<!--    <br>
    <br>
    <input type="text" id="text1" value="text 1" />
    <br>
    <br>
    <input type="text" id="text2" value="text 2" />
    <br>
    <br>
    <input type="text" id="text3" value="text 3" />
    <br>
    <br>
    <input type="text" id="text4" value="text 4" />
    <br>
    <br>
    <input type="text" id="text5" value="text 5" />
    <br>
    <br>
    <input type="text" id="text6" value="text 6" />
    <br>
    <br>
    <input type="text" id="text7" value="text 7" />
    <br>
    <br>
-->

<!--

second canvas, with random values
<canvas id="myCanvas" width="600" height="600" style="border:1px solid #000000;"></canvas>-->
</div>
    <div class="right sidebar">
        <?php
        get_sidebar();
        ?>
    </div>
<?php
get_footer();
