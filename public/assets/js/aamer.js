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





