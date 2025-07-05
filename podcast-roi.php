<!DOCTYPE html>
<html>
<head>
<title>Podcast ROI Calculator</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
      rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>

$( function() {

    $( "#podcast_audience_size-slider" ).slider({
      value:1000,
      min: 1000,
      max: 100000,
      step: 100,
      slide: function( event, ui ) {
        $( "#podcast_audience_size" ).val( "" + ui.value );
      }
    });

    $( "#podcast_audience_size" ).val( "" + $( "#podcast_audience_size-slider" ).slider( "value" ) );
 
    $( "#podcast_cost_to_appear-slider" ).slider({
      value:500,
      min: 200,
      max: 5000,
      step: 100,
      slide: function( event, ui ) {
        $( "#podcast_cost_to_appear" ).val( "" + ui.value );
      }
    });

    $( "#podcast_cost_to_appear" ).val( "" + $( "#podcast_cost_to_appear-slider" ).slider( "value" ) );
      
    
      $("#calculate-roi").click(function() {
            //alert("Button clicked!");
            makeCalculations();
        });

        $.getJSON("data-podcast.json", function(data) {
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
  $.getJSON("data-podcast.json", function(data) {
    
    let index = $('#industry-select').val();
    console.log(index);
    console.log("-------Industry---------");
    console.log(data[index]);
    console.log("------Subscribers----------");

     
    let averageEngagement_rate = averageOfRange(data[index]["engagementRate"][0], data[index]["engagementRate"][1]);
    let averageConversion_rate_to_lead = averageOfRange(data[index]["conversionRateToLead"][0], data[index]["conversionRateToLead"][1]);
    let averageLead_to_customer_conversion_rate = averageOfRange(data[index]["leadToCustomerRate"][0], data[index]["leadToCustomerRate"][1]);

    $("#engagement_rate").val(averageEngagement_rate);
    $("#conversion_rate_to_lead").val(averageConversion_rate_to_lead);
    $("#lead_to_customer_conversion_rate").val(averageLead_to_customer_conversion_rate);
  });
}

function makeCalculations()
{
    let podcast_cost_to_appear = $( "#podcast_cost_to_appear" ).val(); 
    let podcast_audience_size =  $( "#podcast_audience_size" ).val();
    let conversion_value = $("#conversion_value").val();

    let engagement_rate = $("#engagement_rate").val();
    let conversion_rate_to_lead = $("#conversion_rate_to_lead").val();
    let lead_to_customer_conversion_rate = $("#lead_to_customer_conversion_rate").val();

    let Engaged_Listeners = podcast_audience_size * engagement_rate;
    $("#Engaged_Listeners").text("Engaged Listeners " + Engaged_Listeners.toFixed(2));

    let Leads = Engaged_Listeners * conversion_rate_to_lead;
    $("#Leads").text("Leads "+Leads.toFixed(2));

    let New_Customers = Leads*lead_to_customer_conversion_rate;
    $("#New_Customers").text("New Customers "+New_Customers.toFixed(2));
    
    let Revenue = New_Customers*conversion_value;
    $("#Revenue").text("Revenue Generated $"+Revenue.toFixed(2));

    let ROI = ((Revenue-podcast_cost_to_appear)/podcast_cost_to_appear)*100;

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
        
        <h1>Podcast ROI Calculator</h1>

        <select id="industry-select"></select>

        <div style="margin-top:10px;">
            <label style="padding-top:10px;" for="podcast_audience_size">Podcast Audience Size</label>
            <input type="text" id="podcast_audience_size" readonly="" style="border:0; color:#f6931f; font-weight:bold;">
        </div>

        <div style="margin-top:10px;" id = "podcast_audience_size-slider"></div>

        <div style="margin-top:10px;">
            <label style="padding-top:10px;" for="podcast_cost_to_appear">Cost to Appear $</label>
            <input type="text" id="podcast_cost_to_appear" readonly="" style="border:0; color:#f6931f; font-weight:bold;">
        </div>

        <div style="margin-top:10px;" id = "podcast_cost_to_appear-slider"></div>

        <div style="margin-top:20px;">
                    <label for="conversion_value">Average Converstion Value</label>
                    <input type="text" value=1 id="conversion_value" style="border:1; color:#f6931f; font-weight:bold;" />
        </div>

        <div id="benchmarks" style=""><?php //display:none;?>
                <h2>Industry Benchmarks</h2>
                
                <div style="margin-top:20px;"> 
                    <label for="engagement_rate">Engagement Rate</label>
                    <input type="text" id="engagement_rate" style="border:1; color:#f6931f; font-weight:bold;" />
                </div>

                <div style="margin-top:20px;">
                    <label for="conversion_rate_to_lead">Conversion Rate to Lead</label>
                    <input type="text" id="conversion_rate_to_lead" style="border:1; color:#f6931f; font-weight:bold;" />
                </div>

                <div style="margin-top:20px;">
                    <label for="lead_to_customer_conversion_rate">Lead-to-Customer Conversion Rate</label>
                    <input type="text" id="lead_to_customer_conversion_rate" style="border:1; color:#f6931f; font-weight:bold;" />
                </div>
                
                
          </div>
        
          <button style="margin-top: 20px;" id="calculate-roi">Calculate ROI</button>
        
            <div id="results" style="display:none;">
              <h2 id="Engaged_Listeners"></h2>
              <h2 id="Leads"></h2>
              <h2 id="New_Customers"></h2>
              <h2 id="Revenue"></h2>
              <h2 id="roi"></h2>
            </div>

      </div>

</div>
</body>
</html>