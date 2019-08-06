$('#tabel').click(function() {
    $(".table-responsive").show();
    $("#Allthumbnail").hide();
    $(".map-amaer").hide();
 
    $('#tabel').addClass("active");
    $('#map').removeClass("active");
    $('#net').removeClass("active");
    
});
$('#net').click(function() {
    $("#Allthumbnail").show();
    $(".table-responsive").hide();
    $(".map-amaer").hide();
  
    $('#net').addClass("active");
    $('#map').removeClass("active");
    $('#tabel').removeClass("active");
 
});
$('#map').click(function() {
    $(".map-amaer").show();
    $(".table-responsive").hide()
    $("#Allthumbnail").hide()
  
    $('#map').addClass("active");
    $('#net').removeClass("active");
    $('#tabel').removeClass("active");
 
});



var ctx = document.getElementById('myChart').getContext('2d');

var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'May', 'June', 'July',],
        datasets: [{
            label: 'عدد المعاملات',
            backgroundColor: 'rgb(46, 148, 94)',
            borderWidth: 1,
            data: [0, 10, 5, 2, 20, 30, 45, 100, 30, 20]
        },{
            label: 'قيمه المبالغ المحصله',
            data: [50, 30, 5, 2, 20, 30, 45, 100, 30, 20],
          
          
            
            backgroundColor: 'rgba(4, 0, 255, 0.05)',
            borderWidth: 2,
            pointBorderColor: 'rgb(46, 93, 247)',
            pointBackgroundColor: 'rgb(255, 255, 255)',
     
            borderColor: 'rgb(46, 93, 247)',
            // Changes this dataset to become a line
            type: 'line'
        }],
        labels:['January', 'February', 'March', 'April', 'May', 'June', 'July', 'May', 'June', 'July',],
    },

    // Configuration options go here
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    suggestedMin: 50,
                    suggestedMax: 200
                    
                }
            }],
        
        xAxes: [{
            barPercentage: 0.8,
            
            maxBarThickness: 30,
            minBarLength: 2
           
        }]

        },
        legend: {
            labels: {
                // This more specific font property overrides the global property
                fontColor: 'rgb(46, 148, 94)',
                fontFamily: "Bahij",
                radius:5
            }
        }
    }
});

// $(document).ready( function () {
//     $('#myTable').DataTable();
// } );
// $(function() {
//     $('#daterange').daterangepicker({
//       opens: 'left'
//     }, function(start, end, label) {
//       console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
//     });
//   });