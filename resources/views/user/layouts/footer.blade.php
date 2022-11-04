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


 <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
 <!-- endinject -->
 <!-- Plugin js for this page -->
 <script src="{{ asset('assets/vendors/select2/select2.min.js')}}"></script>
 <script src="{{ asset('assets/vendors/jquery-bar-rating/jquery.barrating.min.js') }}"></script>
 <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
 <script src="{{ asset('assets/vendors/flot/jquery.flot.js') }}"></script>
 <script src="{{ asset('assets/vendors/flot/jquery.flot.resize.js') }}"></script>
 <script src="{{ asset('assets/vendors/flot/jquery.flot.categories.js') }}"></script>
 <script src="{{ asset('assets/vendors/flot/jquery.flot.fillbetween.js') }}"></script>
 <script src="{{ asset('assets/vendors/flot/jquery.flot.stack.js') }}"></script>
 <!-- End plugin js for this page -->
 <script src="{{ asset('assets/js/select2.js')}}"></script>
 <!-- inject:js -->
 <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
 <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
 <script src="{{ asset('assets/js/misc.js') }}"></script>
 <script src="{{ asset('assets/js/settings.js') }}"></script>
 <script src="{{ asset('assets/js/todolist.js') }}"></script>
 <!-- endinject -->
 <!-- Custom js for this page -->
 <script src="{{ asset('assets/js/dashboard.js') }}"></script>
 <!-- End custom js for this page -->

 <!--sweet alert-->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <!-- axios library-->
 <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

 <script>
     $('[data-toggle="tooltip"]').tooltip();
     $('.accordion-toggle').click(function() {
         $('.hiddenRow').hide();
         $(this).next('tr').find('.hiddenRow').show();
     });
 </script>
 @stack('modal')
 @stack('script')
 </body>

 </html>