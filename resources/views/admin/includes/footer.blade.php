 <!-- content-wrapper ends -->
 <!-- partial:partials/_footer.html -->
 <!-- <footer class="footer">
     <div class="d-sm-flex justify-content-center justify-content-sm-between">
         <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
         <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard templates</a> from Bootstrapdash.com</span>
     </div>

     <div>
         <span class="text-muted d-block text-center text-sm-left d-sm-inline-block"> Distributed By: <a href="https://themewagon.com/" target="_blank">Themewagon</a></span>
     </div>
 </footer> -->
 <!-- partial -->
 </div>
 <!-- main-panel ends -->
 </div>
 <!-- page-body-wrapper ends -->
 </div>


 <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

 <script src="{{ asset('assets') }}/vendors/js/vendor.bundle.base.js"></script>
 <!-- endinject -->
 <!-- Plugin js for this page -->
 <script src="{{ asset('assets')}}/vendors/select2/select2.min.js"></script>
 <script src="{{ asset('assets') }}/vendors/jquery-bar-rating/jquery.barrating.min.js"></script>
 <script src="{{ asset('assets') }}/vendors/chart.js/Chart.min.js"></script>
 <script src="{{ asset('assets') }}/vendors/flot/jquery.flot.js"></script>
 <script src="{{ asset('assets') }}/vendors/flot/jquery.flot.resize.js"></script>
 <script src="{{ asset('assets') }}/vendors/flot/jquery.flot.categories.js"></script>
 <script src="{{ asset('assets') }}/vendors/flot/jquery.flot.fillbetween.js"></script>
 <script src="{{ asset('assets') }}/vendors/flot/jquery.flot.stack.js"></script>


 <!-- End plugin js for this page -->
 <script src="{{ asset('assets')}}/js/select2.js"></script>
 <!-- inject:js -->
 <script src="{{ asset('assets') }}/js/off-canvas.js"></script>
 <script src="{{ asset('assets') }}/js/hoverable-collapse.js"></script>
 <!-- <script src="{{ asset('assets') }}/js/misc.js"></script> -->
 <script src="{{ asset('assets') }}/js/settings.js"></script>
 <script src="{{ asset('assets') }}/js/todolist.js"></script>
 <!-- endinject -->
 <!-- Custom js for this page -->
 <script src="{{ asset('assets') }}/js/dashboard.js"></script>
 <!-- End custom js for this page -->

 <!--sweet alert-->
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <!-- axios library-->
 <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
 <script src="{{ asset('assets') }}/custom.js"></script>
 <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


 <script>
     $(function() {
         $('.daterange').daterangepicker({
             opens: 'left'
         }, function(start, end, label) {});

         $(".multiple-select1").select2({});
         $(".multiple-select2").select2({});
     });

     imgInp.onchange = evt => {
         const [file] = imgInp.files
         if (file) {
             imgPreview.src = URL.createObjectURL(file)
         }
     }
 </script>
 @stack('modal')
 @stack('script')
 @stack('order')
 </body>

 </html>
