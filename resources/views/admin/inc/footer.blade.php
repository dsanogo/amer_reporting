
<!-- section there-->
<div class="footer-aamer">
    <p class="pull-right fonts-infooter bold "> تم التطوير بواسطة<img class="footer-log" src="{{asset('public/assets/img/unicom-logo.png')}}" alt=""> <img src="{{asset('public/assets/img/attechllc-logo.png')}}" alt=""></p>
    <p class="pull-left fonts-infooter bold">2019 &copy; جميع الحقوق محفوظة للهيئه الاتحادية
        للهويه والجنسيه</p>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{asset('public/assets/js/jquery1.2.min.js')}}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('public/assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/assets/js/chart.js')}}"></script>
<script src="{{asset('public/assets/js/aamer.js')}}"></script>
<script type="text/javascript" src="{{asset('public/assets/js/jquery.last.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/assets/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/assets/js/daterangepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/assets/js/datatables.min.js')}}"></script>
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
