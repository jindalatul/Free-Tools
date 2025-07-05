<!DOCTYPE html>
<html>
<head>
<title>Guest Posting Calculator</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
      rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>

$( function() {

    $( "#traffic-slider" ).slider({
      value:1000,
      min: 1000,
      max: 100000,
      step: 100,
      slide: function( event, ui ) {
        $( "#total_site_traffic" ).val( "" + ui.value );
      }
    });

    $( "#total_site_traffic" ).val( "" + $( "#traffic-slider" ).slider( "value" ) );
      
      $("#calculate-roi").click(function() {
            //alert("Button clicked!");
            makeCalculations();
        });

        $.getJSON("data-guest-post.json", function(data) {
          var items = '<option value="">Select Your Industry</option>';
          $.each(data, function(key, val) {
              items += "<option value='" + key + "'>" + val.industry + "</option>";
              //console.log(key);
              //console.log(val);
          });

          $("#industry-select").html(items);
      });

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

function getValue()
{
  $.getJSON("data-guest-post.json", function(data) {
    
    let index = $('#industry-select').val();
    console.log(index);
    console.log("-------Industry---------");
    console.log(data[index]);
    console.log("------Subscribers----------");

     
    let averageReferral_traffic_percentage = averageOfRange(data[index]["referral_traffic_percentage"][0], data[index]["referral_traffic_percentage"][1]);
    let averageConversion_rate = averageOfRange(data[index]["conversion_rate"][0], data[index]["conversion_rate"][1]);
   
    $("#referral_traffic_percentage").val(averageReferral_traffic_percentage);
    $("#conversion_rate").val(averageConversion_rate);

  });
}

function makeCalculations()
{
    let averageConversion_value = $("#conversion_value").val(); 

    let total_site_traffic = $("#total_site_traffic").val();
    let cost_of_guest_post = $("#cost_of_guest_post").val();
    let averageReferral_traffic_percentage = $("#referral_traffic_percentage").val(); 
    let averageConversion_rate = $("#conversion_rate").val();

    let referral_traffic_visitors = total_site_traffic * (averageReferral_traffic_percentage/100);
    $("#referral-traffic-visitors").text("Referral Traffic Visitors " + referral_traffic_visitors.toFixed(2));

    let total_conversions = referral_traffic_visitors * (averageConversion_rate/100);
    $("#total-conversions").text("Total Conversions "+total_conversions.toFixed(2));

    let Revenue_from_conversions = total_conversions*averageConversion_value;

    $("#Revenue_from_converstions").text("Revenue from Conversions $"+Revenue_from_conversions.toFixed(2));
    

    let ROI = ((Revenue_from_conversions-cost_of_guest_post)/cost_of_guest_post)*100;

    $("#roi").text("Your ROI "+ROI.toFixed(2)+"%");

    $("#results").show();

}
//let subscribers = $("#subscribers").val();
//Total Marketing Spend = subscribers * 

</script>
</head>
<body>

<div style="width:50%; height:50%;">
  
        <div style="margin:50px;">
        
        <h1>Guest Posting ROI Calculator</h1>

        <select id="industry-select"></select>

        <div style="margin-top:10px;">
            <label style="padding-top:10px;" for="total_site_traffic">Estimated Visitors on Website</label>
            <input type="text" id="total_site_traffic" readonly="" style="border:0; color:#f6931f; font-weight:bold;">
        </div>

        <div style="margin-top:10px;" id = "traffic-slider"></div>

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
                    <label for="referral_traffic_percentage">Referral Traffic Percentage</label>
                    <input type="text" id="referral_traffic_percentage" style="border:1; color:#f6931f; font-weight:bold;" />
                </div>

                <div style="margin-top:20px;">
                    <label for="conversion_rate">Conversion Rate From Referral</label>
                    <input type="text" id="conversion_rate" style="border:1; color:#f6931f; font-weight:bold;" />
                </div>
                
          </div>
        
          <button style="margin-top: 20px;" id="calculate-roi">Calculate ROI</button>
        
            <div id="results" style="display:none;">
              <h2 id="referral-traffic-visitors"></h2>
              <h2 id="total-conversions"></h2>
              <h2 id="Revenue_from_converstions"></h2>
              <h2 id="ltv"></h2>
              <h2 id="roi"></h2>
            </div>

      </div>

</div>
</body>
</html>