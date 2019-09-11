
<!-- section there-->
<div class="footer-aamer">
    <p class="pull-right fonts-infooter bold "> تم التطوير بواسطة<img class="footer-log" src="{{asset('public/assets/img/unicom-logo.png')}}" alt=""> <img src="{{asset('public/assets/img/attechllc-logo.png')}}" alt=""></p>
    <p class="pull-left fonts-infooter bold">2019 &copy; جميع الحقوق محفوظة للهيئه الاتحادية
        للهويه والجنسيه</p>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('public/assets/js/bootstrap.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="{{asset('public/assets/js/aamer.js')}}"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.18/datatables.min.js"></script>
<script src="{{asset('public/assets/js/jquery.printPage.js')}}"></script>
<script>
    $(document).ready(function() {
        $(".printPage").printPage({
            message: 'Loading your document. Please wait...'
        });
        $('.sendmail').click(function(){
            $('.emailForm').show();
        })
    });

</script>
@yield('script')

</body>



</html>
