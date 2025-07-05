
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Event</h1>
</div>

<!-- Content Row -->
<div class="row">

	<div class="col-xl-12 col-lg-12">
		<div class="card shadow mb-4">
		
			<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Event List</h6>
				<div class="dropdown no-arrow">
					<a href="./index.php?loc=newEvent" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
						<i class="fas fa-plus fa-sm text-white-50"></i> Add new Event
					</a>
					<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
						 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
							 aria-labelledby="dropdownMenuLink">
						<div class="dropdown-header">Dropdown Header:</div>
						<a class="dropdown-item" href="#">Action</a>
						<a class="dropdown-item" href="#">Another action</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Something else here</a>
					</div>
				</div>
			</div>
			
			<!-- Card Body -->
			<div class="card-body">
				<div class="table-area">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">ENO</th>
								<th scope="col">活動名稱</th>
								<th scope="col">工具</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$ary_productList = array(
									0 => array(
										"prod_id" 			=> 1,
										"prod_no" 			=> 'PNO001',
										"prod_code" 		=> 'TR-001',
										"prod_type" 		=> '紙盒',
										"prod_name" 		=> '印刷紙盒',
										"prod_barcode" 	=> '0123456789',
										"prod_quantity" => array(
																				"imports" 	=> '10000',
																				"exports" 	=> '5000',
																				"destroy" 	=> '4000',
																			 ),
										"prod_version" => "1.01",
									),
									1 => array(
										"prod_id" 			=> 2,
										"prod_no" 			=> 'PNO002',
										"prod_code" 		=> 'TR-002',
										"prod_type" 		=> '貼紙',
										"prod_name" 		=> 'TR-001封膜貼紙',
										"prod_barcode" 	=> '',
										"prod_quantity" => array(
																				"imports" 	=> '5000',
																				"exports" 	=> '4000',
																				"destroy" 	=> '0',
																			 ),
										"prod_version" => "1.01",
									),
									2 => array(
										"prod_id" 			=> 3,
										"prod_no" 			=> 'PNO003',
										"prod_code" 		=> 'TR-003',
										"prod_type" 		=> '說明書',
										"prod_name" 		=> 'TR-001說明書',
										"prod_barcode" 	=> '',
										"prod_quantity" => array(
																				"imports" 	=> '5000',
																				"exports" 	=> '4800',
																				"destroy" 	=> '0',
																			 ),
										"prod_version" => "1.01",
									),
								);
							?>
							<?php
								foreach($ary_productList AS $Key => $Values) {
									echo "<tr>";
									echo 	"<th scope = \"row\">".$Values["prod_no"]."</th>";
									echo 	"<td>".$Values["prod_name"]."</td>";
									echo 	"<td class = \"row\">";
									echo 		"<button type = \"button\" class = \"btn btn-secondary\" class = \"col\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"Tooltip on top\">";
									echo 		"<i class = \"far fa-file-alt\"></i>查看";
									echo 		"</button>";
									echo 		"<button type = \"button\" class = \"btn btn-secondary\" class = \"col\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"Tooltip on top\">";
									echo 		"<i class = \"far fa-file-alt\"></i>記分板";
									echo 		"</button>";
									echo 		"<button type = \"button\" class = \"btn btn-secondary\" class = \"col\" data-toggle = \"tooltip\" data-placement = \"top\" title = \"Tooltip on top\">";
									echo 		"<i class = \"fas fa-pen\"></i>編輯";
									echo 		"</button>";
									echo 	"</td>";
									echo "</tr>";
								}
							?>
						</tbody>
					</table>
				</div>
				<div class="paging-area text-center">
					留一行給分頁使用
				</div>
			</div>
		</div>
	</div>
	
</div>