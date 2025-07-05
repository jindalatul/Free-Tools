<!DOCTYPE html>
<html>
<head>
<title>Email Marketing Spend Calculator</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
      rel = "stylesheet">
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<script>

$( function() {
    $( "#subscribers-slider" ).slider({
      value:50,
      min: 0,
      max: 1000,
      step: 50,
      slide: function( event, ui ) {
        $( "#subscribers" ).val( "" + ui.value );
      }
    });

    $( "#subscribers" ).val( "" + $( "#subscribers-slider" ).slider( "value" ) );
      
      $("#calculate-roi").click(function() {
            //alert("Button clicked!");
            makeCalculations();
        });

        $.getJSON("data-email.json", function(data) {
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

function getRandomNumber(min, max) 
{
  min = Math.ceil(min);
  max = Math.floor(max);
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

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
  $.getJSON("data-email.json", function(data) {
    
    let index = $('#industry-select').val();
    console.log(index);
    console.log("-------Industry---------");
    console.log(data[index]);
    console.log("------Subscribers----------");
    let subscribers = $("#subscribers").val();

    console.log(subscribers);
    let averageCPS = averageOfRange(data[index]["cps"][0], data[index]["cps"][1]);
    let averageARPS = averageOfRange(data[index]["arps"][0], data[index]["arps"][1]);
    let average_subscriber_lifespan_years = averageOfRange(data[index]["subscriber_lifespan_years"][0], data[index]["subscriber_lifespan_years"][1]);
   
    let average_open_rate = averageOfRange(data[index]["open_rate"][0], data[index]["open_rate"][1]);
    let average_converstionrate = averageOfRange(data[index]["conversion_rate"][0], data[index]["conversion_rate"][1]);

    $("#cps").val(averageCPS);
    $("#arps").val(averageARPS);

    $("#converstionrate").val(average_converstionrate*100); 
    $("#openrate").val(average_open_rate*100);

    $("#subscriber_lifespan_years").val(average_subscriber_lifespan_years);
  });
}

function makeCalculations()
{
    let subscribers = $("#subscribers").val();

    let averageCPS = $("#cps").val(); //alert(averageCPS);
    let averageARPS = $("#arps").val(); //alert(averageARPS);

    let average_subscriber_lifespan_years =  $("#subscriber_lifespan_years").val(); //alert(average_subscriber_lifespan_years);

    let total_marketing_spend = subscribers * averageCPS;
    let Revenue_from_New_Subscribers = subscribers * averageARPS;
    let ltv = averageARPS*average_subscriber_lifespan_years;

    let ROI = ((Revenue_from_New_Subscribers-total_marketing_spend)/total_marketing_spend)*100;

    $("#marketing-spend").text("Total Marketing Spend $" + total_marketing_spend.toFixed(2));
    $("#Revenue_from_New_Subscribers").text("Revenue from New Subscribers $"+Revenue_from_New_Subscribers.toFixed(2));

    $("#ltv").text("Lifetime Value (LTV) per subscriber $"+ltv.toFixed(2));

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
        
        <h1>Total Email Marketing Spend Calculator</h1>

        <select id="industry-select"></select>

        <div style="margin-top:10px;">
            <label style="padding-top:10px;" for="subscribers">Subscribers</label>
            <input type="text" id="subscribers" readonly="" style="border:0; color:#f6931f; font-weight:bold;">
        </div>

        <div style="margin-top:10px;" id = "subscribers-slider"></div>
      
          <div id="benchmarks" style="display:none;">
                <h2>Industry Benchmarks</h2>
                
                <div style="margin-top:20px;">
                    <label for="openrate">Email Open Rate in %</label>
                    <input type="text" id="openrate" style="border:1; color:#f6931f; font-weight:bold;" />
                </div>

                <div style="margin-top:20px;">
                    <label for="converstionrate">Email Conversion Rate %</label>
                    <input type="text" id="converstionrate" style="border:1; color:#f6931f; font-weight:bold;" />
                </div>

                <div style="margin-top:20px;">
                    <label for="arps">Average Revenue per Subscriber $</label>
                    <input type="text" id="arps" style="border:1; color:#f6931f; font-weight:bold;" />
                </div>

                <div style="margin-top:20px;">
                    <label for="subscriber_lifespan_years">Subscriber Lifespan (Years)</label>
                    <input type="text" id="subscriber_lifespan_years" style="border:1; color:#f6931f; font-weight:bold;" />
                </div>
                
                <div style="margin-top:20px;">
                    <label for="cps">Cost Per Subscriber $</label>
                    <input type="text" id="cps" style="border:1; color:#f6931f; font-weight:bold;" />
                </div>
          </div>
        
          <button style="margin-top: 20px;" id="calculate-roi">Calculate ROI</button>
        
            <div id="results" style="display:none;">
              <h2 id="marketing-spend"></h2>
              <h2 id="Revenue_from_New_Subscribers"></h2>
              <h2 id="ltv"></h2>
              <h2 id="roi"></h2>
            </div>

      </div>

</div>
</body>
</html>