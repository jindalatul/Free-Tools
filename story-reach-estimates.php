<!DOCTYPE html>
<html>
<head>
<title>Story Reach Calculator</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
      rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>

$( function() {

    $( "#follower_count-slider" ).slider({
      value:1000,
      min: 1000,
      max: 110000,
      step: 100,
      slide: function( event, ui ) {
        $( "#follower_count" ).val( "" + ui.value );
      }
    });

    $( "#follower_count" ).val( "" + $( "#follower_count-slider" ).slider( "value" ) );
      
      $("#calculate-reach").click(function() {
            //alert("Button clicked!");
            makeCalculations();
        });

       let platforms = ["Instagram Stories","Facebook Stories","TikTok Posts","YouTube Shorts"];
          var items = '<option value="">Select Your Platform</option>';
          $.each(platforms, function(key, val) {
              items += "<option value='" + val + "'>" + val + "</option>";
          });

          $("#industry-select").html(items);

      $('#industry-select').change(function() {
        $("#results").hide();
        getValue();
        $("#benchmarks").show();
      });
  });

function averageOfRange(start, end) 
{
  let sum = 0;
  let count = 0;

  for (let i = start; i <= end; i++) {
    sum += i;
    count++;
  }

  if (count === 0) {
    return 0;
  }

  return sum / count;
}

function checkIfWordExists(string, word) 
{
  return string.includes(word);
}

function isNumberInRange(number, start, end) 
{
  return number >= start && number <= end;
}

function getValue()
{
  
  $.getJSON("data-social-story.json", function(data) {

    let buffer = null;
    
    $.each(data, function(key, val) {
            let platform = $('#industry-select').val();
            let follower_count = $('#follower_count').val();

            if (checkIfWordExists(data[key]["platform"], platform)) 
            {
                if (isNumberInRange(follower_count, data[key]["min_followers"], data[key]["max_followers"])) 
                {
                buffer = data[key];
                }
            } 
    });
    //console.log(buffer);
    //console.log("-------buffer---------");

    let reach_rate = averageOfRange(buffer["reach_rate"][0], buffer["reach_rate"][1]);
    $("#reach_rate").val(reach_rate);
    let averageCTR = averageOfRange(buffer["ctr"][0], buffer["ctr"][1]);
    $("#CTR").val(averageCTR);
  });
}

function makeCalculations()
{
    let follower_count = $('#follower_count').val();
    let Reach_Rate = $("#reach_rate").val();
    let ctr = $("#CTR").val();

    let Estimated_Views = follower_count * Reach_Rate;
    $("#Estimated_Views").text("Estimated Views "+Estimated_Views.toFixed(2));

    let clicks = Estimated_Views*ctr;
    $("#clicks").text("Estimated Clicks "+clicks.toFixed(2));

    $("#results").show();

}
//let subscribers = $("#subscribers").val();
//Total Marketing Spend = subscribers * 

</script>
</head>
<body>

<div style="width:50%; height:50%;">
  
        <div style="margin:50px;">
        
        <h1>Story Reach Calculator</h1>

        <select id="industry-select"></select>

        <div style="margin-top:10px;">
            <label style="padding-top:10px;" for="follower_count">Estimated Follower Counts</label>
            <input type="text" id="follower_count" readonly="" style="border:0; color:#f6931f; font-weight:bold;">
        </div>

        <div style="margin-top:10px;" id = "follower_count-slider"></div>

        <div style="margin-top:20px;">
                    <label for="cost_of_guest_post">Cost of Guest Post (Includes writing, outreach costs).$</label>
                    <input type="text" value=200 id="cost_of_guest_post" style="border:1; color:#f6931f; font-weight:bold;" />
        </div>

        <div style="margin-top:20px;">
                    <label for="conversion_value">Average Converstion Value</label>
                    <input type="text" value=1 id="conversion_value" style="border:1; color:#f6931f; font-weight:bold;" />
        </div>

        <div id="benchmarks" style=""><?php //display:none;?>
                <h2>Industry Benchmarks</h2>
                
                <div style="margin-top:20px;"> 
                    <label for="reach_rate">Reach Rate</label>
                    <input type="text" id="reach_rate" style="border:1; color:#f6931f; font-weight:bold;" />
                </div>

                <div style="margin-top:20px;">
                    <label for="CTR">Click Through Rate</label>
                    <input type="text" id="CTR" style="border:1; color:#f6931f; font-weight:bold;" />
                </div>
                
          </div>
        
          <button style="margin-top: 20px;" id="calculate-reach">Calculate Reach</button>
        
            <div id="results" style="display:none;">
              <h2 id="Estimated_Views"></h2>
              <h2 id="clicks"></h2>
              <h2 id="Revenue_from_converstions"></h2>
              <h2 id="ltv"></h2>
              <h2 id="roi"></h2>
            </div>

      </div>

</div>
</body>
</html>