
					</div>
					<!-- container -->
				</div>
				<!-- content -->
			</div>
			<!-- end content-page -->
		</div>
		<!-- END wrapper -->

		<script>
		function f_copy(str_url){
			navigator.clipboard.writeText(str_url);

			alert("복사하였습니다.");
		}
		</script>

		<!-- bundle -->
		<script src="<?php echo G5_URL;?>/page/assets/js/vendor.min.js"></script>
		<script src="<?php echo G5_URL;?>/page/assets/js/app.min.js"></script>
	</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다.