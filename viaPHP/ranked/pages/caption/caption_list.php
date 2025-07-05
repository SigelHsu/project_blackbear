
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-0 text-gray-800">Caption</h1>
</div>

<!-- Content Row -->
<div class="row">

	<div class="col-xl-12 col-lg-12">
		<div class="card shadow mb-4">
		
			<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Caption List</h6>
				<div class="dropdown no-arrow">
					<a href="./index.php?loc=newCaption" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
						<i class="fas fa-plus fa-sm text-white-50"></i> Add new Caption
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
				$ary_captionList = fun_getCaptionsData();
			?>
			<!-- Card Body -->
			<div class="card-body">
				<div class="table-area">
					<table class="table">
						<thead>
							<tr class="text-center">
								<th scope="col-2">SNO</th>
								<th scope="col-2">Code</th>
								<th scope="col-4">字幕組名稱</th>
								<th scope="col-4">工具</th>
							</tr>
						</thead>
						<tbody>
						<?php
							foreach($ary_captionList AS $Key => $Values) :
						?>
							<tr>
								<th class="col-2"><?=$Values["Caption_ID"]; ?></th>
								<td class="col-2"><?=$Values["Caption_Code"]; ?></td>
								<td class="col-4"><?=$Values["Caption_Title"]; ?></td>
								<td class="col-4 text-center">
									<button type = "button" class = "btn btn-secondary ml-1" class = "col" onclick = "javaScript: window.open('./index.php?loc=showCaption&code=<?=$Values["Caption_Code"]; ?>')" data-toggle = "tooltip" data-placement = "top" title = "查看字幕組(無編輯功能)">
										<i class = "far fa-file-alt"></i>查看字幕頁
									</button>
									<button type = "button" class = "btn btn-secondary ml-1" class = "col" onclick = "javaScript: location.href='./index.php?loc=editCaption&code=<?=$Values["Caption_Code"]; ?>'" data-toggle = "tooltip" data-placement = "top" title = "修改、編輯字幕組、設定">
										<i class = "fas fa-pen"></i>設置編輯
									</button>
									<button type = "button" class = "btn btn-secondary ml-1" class = "col" onclick = "javaScript: location.href='./index.php?loc=subtitleList&code=<?=$Values["Caption_Code"]; ?>'" data-toggle = "tooltip" data-placement = "top" title = "新增/編輯/調整字幕內容">
										<i class = "far fa-closed-captioning"></i>字幕編輯
									</button>
									<button type = "button" class = "btn btn-secondary ml-1" class = "col" onclick = "javaScript: location.href='./index.php?loc=pubSubtitle&code=<?=$Values["Caption_Code"]; ?>'" data-toggle = "tooltip" data-placement = "top" title = "發布字幕">
										<i class = "fas fa-level-up-alt"></i>發佈字幕
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