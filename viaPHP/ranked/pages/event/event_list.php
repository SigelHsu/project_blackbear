
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
			
			
			<?php 
				//從資料庫中讀取活動資料
				$ary_eventList = fun_getEventsData();
			?>
			<!-- Card Body -->
			<div class="card-body">
				<div class="table-area">
					<table class="table">
						<thead>
							<tr class="text-center">
								<th scope="col-2">ENO</th>
								<th scope="col-2">Code</th>
								<th scope="col-4">活動名稱</th>
								<th scope="col-4">工具</th>
							</tr>
						</thead>
						<tbody>
						<?php
							foreach($ary_eventList AS $Key => $Values) :
						?>
							<tr>
								<th class="col-2"><?=$Values["Event_No"]; ?></th>
								<td class="col-2">
									<?=$Values["Event_Code"]; ?>
									<div class="dropdown no-arrow">
										<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink_<?=$Key; ?>"
											 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
										</a>
										<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
												 aria-labelledby="dropdownMenuLink_<?=$Key; ?>">
											<button type = "button" class = "btn btn-secondary ml-2" class = "col" onclick = "javaScript: location.href='./index.php?loc=newEvent&code=<?=$Values["Event_Code"]; ?>'" data-toggle = "tooltip" data-placement = "top" title = "複製此活動內容、設定">
												<i class="fas fa-copy"></i>複製
											</button>
											<button type = "button" class = "btn btn-secondary ml-2" class = "col" onclick = "javaScript: window.open('./tools/ajax/ajax_getRankData.php?tag=1&code=<?=$Values["Event_Code"]; ?>')" data-toggle = "tooltip" data-placement = "top" title = "JSON連結">
												<i class="fab fa-js-square"></i>JSON
											</button>
										</div>
									</div>
								</td>
								<td class="col-4"><?=$Values["Event_Title"]; ?></td>
								<td class="col-4 text-center">
									<button type = "button" class = "btn btn-secondary ml-1" class = "col" onclick = "javaScript: window.open('./index.php?loc=scoreBoard&code=<?=$Values["Event_Code"]; ?>')" data-toggle = "tooltip" data-placement = "top" title = "查看記分板(無編輯功能)">
										<i class="fab fa-flipboard"></i></i>查看
									</button>
									<button type = "button" class = "btn btn-secondary ml-1" class = "col" onclick = "javaScript: location.href='./index.php?loc=scoreEvent&code=<?=$Values["Event_Code"]; ?>'" data-toggle = "tooltip" data-placement = "top" title = "編輯記分板，用以修改即時分數">
										<i class = "far fa-file-alt"></i>編輯
									</button>
									<button type = "button" class = "btn btn-secondary ml-1" class = "col" onclick = "javaScript: location.href='./index.php?loc=editEvent&code=<?=$Values["Event_Code"]; ?>'" data-toggle = "tooltip" data-placement = "top" title = "修改、編輯活動內容、設定">
										<i class = "fas fa-pen"></i>內容
									</button>									
								</td>
							</tr>
						<?php 
							endforeach;
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